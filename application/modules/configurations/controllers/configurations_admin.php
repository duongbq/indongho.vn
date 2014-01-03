<?php

class Configurations_Admin extends MX_Controller 
{
    private $_last_message = '';
    function __construct() 
    {
        parent::__construct();
        $this->load->model('utility_model');
        if (!modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE)))
            redirect('/');
    }

    function dispatcher($method = '', $para1 = NULL, $para2 = NULL) {
        $menu_params = array('current_menu' => '/' . $this->uri->uri_string());
        $layout = 'duongbq/admin_layout';

        switch ($method) 
        {
            case 'config':
                $main_content = $this->config();
                break;
        }

        $view_data = array();
        $view_data['url'] = isset($current_url) ? $current_url : '';
        $view_data['admin_menu'] = modules::run('menus/menus/get_dashboard_menus', $menu_params);
        $view_data['main_content'] = $main_content;
        // META data
        $view_data['title'] = $this->_title;
        $this->load->view($layout, $view_data);
    }
    
    public function config()
    {
        $options = array();
        if ($this->is_postback())
        {
            if($this->_do_config())
                $options['succeed'] = $this->_last_message;
            else
                $options['error'] = $this->_last_message;
        }
        $view_data  = array();
        $view_data  = $this->_get_form_config();
        
        if($this->input->get('save_cache') == 'success')
            $options['succeed'] = 'Lưu cache thành công';
        else if($this->input->get('save_cache') == 'error')
            $options['error'] = 'Lưu cache không thành công';
        
        if (isset($options['error']) || isset($options['succeed']))
            $view_data['options'] = $options;
//        include './cache/configurations.php';
        //heading
        $this->_title       = 'Thiết lập hệ thống' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/configurations_form', $view_data, TRUE);
    }
    
    private function _get_form_config()
    {
        $config = $this->configurations_model->get_configuration();
        if(!$this->is_postback())
        {
            $contact_email          = $config->contact_email;
            $order_email            = $config->order_email;
            $meta_title             = $config->meta_title;
            $meta_description       = $config->meta_description;
            $meta_keywords          = $config->meta_keywords;
            $news_per_page          = $config->news_per_page;
            $products_per_page      = $config->products_per_page;
            $news_side_per_page     = $config->news_side_per_page;
            $products_side_per_page = $config->products_side_per_page;
            $image_per_page         = $config->image_per_page;
            $google_tracker         = $config->google_tracker;
            $webmaster_tracker      = $config->webmaster_tracker;
        }
        else
        {
            $contact_email          = $this->input->post('contact_email', TRUE);
            $order_email            = $this->input->post('order_email', TRUE);
            $meta_title             = $this->input->post('meta_title', TRUE);
            $meta_description       = $this->input->post('meta_description', TRUE);
            $meta_keywords          = $this->input->post('meta_keywords', TRUE);
            $favicon                = '';
            $news_per_page          = $this->input->post('news_per_page', TRUE);
            $products_per_page      = $this->input->post('products_per_page', TRUE);
            $news_side_per_page     = $this->input->post('news_side_per_page', TRUE);
            $products_side_per_page = $this->input->post('products_side_per_page', TRUE);
            $image_per_page         = $this->input->post('image_per_page', TRUE);
            $google_tracker         = $this->input->post('google_tracker');
            $webmaster_tracker      = $this->input->post('webmaster_tracker');
        }
        $view_data                          = array();
        $view_data['contact_email']         = $contact_email;
        $view_data['order_email']           = $order_email;
        $view_data['meta_title']            = $meta_title;
        $view_data['meta_description']      = $meta_description;
        $view_data['meta_keywords']         = $meta_keywords;
        $view_data['products_per_page']     = $products_per_page;
        $view_data['news_per_page']         = $news_per_page;
        $view_data['news_side_per_page']    = $news_side_per_page;
        $view_data['products_side_per_page']= $products_side_per_page;
        $view_data['image_per_page']        = $image_per_page;
        $view_data['google_tracker']        = $google_tracker;
        $view_data['webmaster_tracker']     = $webmaster_tracker;
        return $view_data;
    }
    
    private function _do_config()
    {
        $this->form_validation->set_rules('products_per_page', 'Số sản phẩm chính / trang', 'trim|is_numeric|xss_clean');
        $this->form_validation->set_rules('products_side_per_page', 'Số sản phẩm bên trái', 'trim|is_numeric|xss_clean');
        $this->form_validation->set_rules('news_per_page', 'Số tin tức chính / trang', 'trim|is_numeric|xss_clean');
        $this->form_validation->set_rules('news_side_per_page', 'Số tin tức bên trái', 'trim|is_numeric|xss_clean');
        $this->form_validation->set_rules('image_per_page', 'Số ảnh hiển thị / trang', 'trim|is_numeric|xss_clean');
        if ($this->form_validation->run()) 
        {
            $data = array(
                'contact_email'             => $this->input->post('contact_email', TRUE),
                'order_email'               => $this->input->post('order_email', TRUE),
                'meta_title'                => $this->input->post('meta_title', TRUE),
                'meta_keywords'             => $this->input->post('meta_keywords', TRUE),
                'meta_description'          => $this->input->post('meta_description', TRUE),
                'products_per_page'         => $this->input->post('products_per_page', TRUE),
                'products_side_per_page'    => $this->input->post('products_side_per_page', TRUE),
                'news_per_page'             => $this->input->post('news_per_page', TRUE),
                'news_side_per_page'        => $this->input->post('news_side_per_page', TRUE),
                'image_per_page'            => $this->input->post('image_per_page', TRUE),
                'google_tracker'            => $this->input->post('google_tracker'),
                'webmaster_tracker'         => $this->input->post('webmaster_tracker'),
                );
            $this->configurations_model->update_configruation($data);
            $this->_last_message = '<p>Lưu lại thành công</p>';
            return TRUE;
        }
        else
            $this->_last_message = validation_errors();
        return FALSE;
    }
    
    function save_cache($options = array())
    {
        if(save_cache('configurations'))
            redirect('/dashboard/system_config?save_cache=success');
        else
            redirect('/dashboard/system_config?save_cache=error');
    }
}

?>
