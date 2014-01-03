<?php
/**
 * Module này được sử dụng để cung cấp những từ khóa quan trọng nhất cho tin đăng
 * bất động sản
 */

class RealSeo extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function dispatcher($method='', $param1 = '', $param2 = '')
    {
        $main_content = NULL;
        $current_url        = '/dashboard/keywords';
        $layout             = 'duongbq/admin_layout';
        
        switch ($method) {
            case 'list_keyword':
                $main_content = $this->list_keywords();
                break;
            case 'add_keyword':
                $main_content = $this->add_keyword();
                break;
            case 'edit_keyword':
                $main_content = $this->edit_keyword(array('id' => $param1));
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
    
    function list_keywords()
    {
        $view_data = array();
        $view_data['keywords'] = $this->realseo_model->get_keywords();
        return $this->load->view('list_keywords', $view_data, TRUE);
    }
    
    function add_keyword($options = array())
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|required|xss_clean|max_length[256]');
        $this->form_validation->set_rules('link', 'Đường dẫn', 'trim|required|xss_clean|max_length[500]');
        if ($this->form_validation->run())
        {
            $data = array(
                'keyword'   => $this->input->post('keyword'),
                'link'      => $this->input->post('link'),
                'title'     => $this->input->post('title')
                );
            $this->realseo_model->add_keyword($data);
            redirect('/dashboard/keywords', 'refresh');
        }
        else
        {
            $options['error']       = validation_errors();
            $view_data              = array();
            $view_data['options']   = $options;
            $view_data['submit_uri']= '/dashboard/keywords/add';
            $view_data['button_name']= 'Thêm';
            return $this->load->view('add_keyword_form', $view_data, TRUE);
        }
        return FALSE;
    }

    function edit_keyword($options = array())
    {
        $view_data  = array();
        if ($this->is_postback())
        {
            if (!$this->_do_edit_keyword($options))
                $options['error'] = validation_errors();
        }


        $view_data = $this->_get_edit_form_data($options);
        if (isset($options['error'])) $view_data['options'] = $options;
        //header
        $view_data['submit_uri']= '/dashboard/keywords/edit/' . $options['id'];
        $view_data['button_name']= 'Sửa';
        return $this->load->view('add_keyword_form', $view_data, TRUE);
    }

    private function _get_edit_form_data($options = array())
    {
        $keyword_id        = $options['id'];

        $keyword          = $this->realseo_model->get_keywords(array('id' => $keyword_id));
        if(!is_object($keyword)) show_404();
        if(!$this->is_postback())
        {
            $id                     = $keyword->id;
            $keyword_name           = $keyword->keyword;
            $link                   = $keyword->link;
            $title                  = $keyword->title;
        }
        else
        {
            $id                     = $keyword_id;
            $keyword_name           = $this->input->post('keyword', TRUE);
            $link                   = $this->input->post('link', TRUE);
            $title                  = $this->input->post('title', TRUE);
        }

        $view_data                          = array();
        $view_data['id']                    = $id;
        $view_data['keyword']               = $keyword_name;
        $view_data['link']                  = $link;
        $view_data['title']                  = $title;
        return $view_data;
    }

    private function _do_edit_keyword($options = array())
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|required|xss_clean|max_length[256]');
        $this->form_validation->set_rules('link', 'Đường dẫn', 'trim|required|xss_clean|max_length[500]');
        if ($this->form_validation->run())
        {
            $data = array(
                'keyword'   => $this->input->post('keyword'),
                'link'      => $this->input->post('link'),
                'title'      => $this->input->post('title')
                );
            $data['id'] = $options['id'];
            $this->realseo_model->edit_keyword($data);
            redirect('/dashboard/keywords', 'refresh');
        }
        return FALSE;
    }
    
    public function delete_keyword($id=0)
    {
        $this->realseo_model->delete_keyword($id);
        redirect('/dashboard/keywords', 'refresh');
    }
}
?>