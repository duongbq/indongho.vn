<?php 
class Advertisements_Admin extends MX_Controller
{
    private $_last_message = '';
    function __construct()
    {
        parent::__construct();
        $this->load->model('utility_model');
        if(!modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE))) redirect('/');
    }

    function dispatcher($method='', $para1=NULL, $para2=NULL)
    {
        $layout             = 'duongbq/admin_layout';
        $lang               = switch_language($para2);
        switch ($method)
        {
            case 'list_advertisements':
                $this->phpsession->save('adv_type', $para1);
                $this->phpsession->save('current_adv_lang', $lang);
                $main_content       = $this->list_advertisements(array('type' => $para1, 'lang' => $lang));
                break;
            case 'upload_adv':
                $main_content       = $this->upload_adv();
                break;
        }

        $view_data                  = array();
        $view_data['url']           = isset($current_url) ? $current_url : '';
        $view_data['admin_menu']    = modules::run('menus/menus/get_dashboard_menus');
        $view_data['main_content']  = $main_content;
        // META data
        $view_data['title']         = $this->_title;

        $this->load->view($layout, $view_data);
    }

    function list_advertisements($options = array())
    {
        $view_data = array();
        $options['is_admin']                = TRUE;
        $view_data['advs']                  = $this->advertisements_model->get_advertisements($options);
        $view_data['back_url']              = '/dashboard/advertisements/' . $this->uri->segment(3) . '/';
        if(isset($options['error'])) $view_data['options'] = $options;
        $this->_title                       = 'Quản lý quảng cáo' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/list_advertisements', $view_data, TRUE);
    }

    function ajax_upload_advertisement_images()
    {
        if (!empty($_FILES))
        {
            $image_path = './images/advs/';
            $adv_type = $this->phpsession->get('adv_type');
            $this->advertisements_images_model->upload_image($image_path, $adv_type);
        }
    }
    
    function upload_adv()
    {
        $image_path = './images/advs/';
        $adv_type = $this->phpsession->get('adv_type');
        $this->advertisements_images_model->upload_image($image_path, $adv_type);
        return $this->list_advertisements(array('error' => $this->advertisements_images_model->get_last_message(),
            'lang' => $this->phpsession->get('current_adv_lang'),
            'type' => $this->phpsession->get('adv_type')));
        
    }

    function sort_advertisement()
    {
        $arr = $this->input->post('id');
        $i = 1;
        foreach ($arr as $recordidval)
        {
            $array = array('position' => $i);
            $this->db->where('id', $recordidval)
                     ->update('advs', $array);
            $i = $i + 1;
        }
    }

    function edit_link()
    {
        $link   = $this->input->post('value');
        $id     = $this->input->post('id');
        $this->advertisements_model->update_link($link, $id);
        echo $link;
    }
    
    function edit_title()
    {
        $title   = $this->input->post('value');
        $id     = $this->input->post('id');
        $this->advertisements_model->update_title($title, $id);
        echo $title;
    }

    function change_adv_status()
    {
        $id = $this->input->post('id');
        $advertisement = $this->advertisements_model->get_advertisements(array('id' =>$id, 'is_admin' => TRUE));
        $status = $advertisement->status == ACTIVE_ADV ? INACTIVE_ADV : ACTIVE_ADV;
        $this->advertisements_model->change_status($id, $status);
    }

    function delete_adv()
    {
        $id         = $this->input->post('id');
        $image_path = './images/advs/';
        $this->advertisements_images_model->delete_image($id, $image_path);
        $this->advertisements_model->delete_advertisement($id);
    }

    

}
?>
