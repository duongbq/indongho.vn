<?php

class Pages_Admin extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('utility_model');
        if (!modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE)))
            redirect('/');
    }

    function dispatcher($method = '', $para1 = NULL, $para2 = NULL) {
        $current_menu = array();
        $menu_params = array('current_menu' => '/' . $this->uri->uri_string());
        $layout = 'duongbq/admin_layout';
        $current_url = '/dashboard/pages';

        switch ($method) {
            case 'list_pages':
                $menu_params = array('page' => $para1);
                $main_content = $this->list_pages($menu_params);
                $current_url = '/dashboard/pages';
                break;
            case 'add_page' :
                $main_content = $this->add_page();
                break;
            case 'edit_page' :
                $main_content = $this->edit_page();
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

    function list_pages($options = array()) {
        $options        = array_merge($options, $this->_get_data_from_filter());
        $total_row      = $this->pages_model->get_pages_count($options);
        $total_pages    = (int) ($total_row / PAGES_PER_PAGE);

        if ($total_pages * PAGES_PER_PAGE < $total_row)
            $total_pages++;
        if ((int) $options['page'] > $total_pages)
            $options['page'] = $total_pages;

        $options['offset'] = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int) $options['page'] - 1) * PAGES_PER_PAGE;
        $options['limit'] = PAGES_PER_PAGE;

        $config = prepare_pagination(
                array(
                    'total_rows' => $total_row,
                    'per_page' => $options['limit'],
                    'offset' => $options['offset'],
                    'js_function' => 'change_page_admin'
                )
        );
        
        $this->pagination->initialize($config);
        $options['is_admin'] = TRUE;
        $view_data = array();
        $view_data['pages'] = $this->pages_model->get_pages($options);
        $view_data['search'] = $options['search'];
        $view_data['post_uri'] = 'pages';
        $view_data['e_page'] = $options['page'];
        $view_data['total_rows'] = $total_row;
        $view_data['total_pages'] = $total_pages;
        $view_data['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'all' => TRUE));
        $view_data['page_links'] = $this->pagination->create_ajax_links();

        if($this->input->get('save_cache') == 'success')
            $options['succeed'] = 'Lưu cache thành công';
        else if($this->input->get('save_cache') == 'error')
            $options['error'] = 'Lưu cache không thành công';
        
        if (isset($options['error']) || isset($options['succeed']))
            $view_data['options'] = $options;
        
        $this->_title = 'Quản lý page' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/list_pages', $view_data, TRUE);
    }

    private function _get_data_from_filter() {
        $options = array();
        
        if ($this->is_postback()) {
            $options['search'] = $this->input->post('search', TRUE);
            $this->phpsession->save('page_search', $options);
            $options['lang'] = $this->input->post('lang');
            $this->phpsession->save('page_lang', $options['lang']);
        } else {
            $temp_options = $this->phpsession->get('page_search');
            if (is_array($temp_options)) {
                $options['search'] = $temp_options['search'];
            } else {
                $options['search'] = '';
            }
            $options['lang'] = $this->phpsession->get('page_lang');
        }
        return $options;
    }

    public function add_page() {
        $options = array();
        $view_data = array();
        if ($this->is_postback()) {
            if (!$this->_do_add_page())
                $options['error'] = validation_errors();
        }
        $view_data = $this->_get_add_page_form_data();
        if (isset($options['error']))
            $view_data['options'] = $options;

        //header
        $this->_title = 'Thêm trang mới' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/add_page_form', $view_data, TRUE);
    }

    /**
     * Chuẩn bị dữ liệu cho form add
     * @return type
     */
    private function _get_add_page_form_data() {
        $view_data = array();
        $view_data['title'] = $this->input->post('title');
        $view_data['uri'] = $this->input->post('uri');
        $view_data['summary'] = $this->input->post('summary');
        $view_data['content'] = '';
        $view_data['meta_title'] = $this->input->post('meta_title');
        $view_data['meta_keywords'] = $this->input->post('meta_keywords');
        $view_data['meta_description'] = $this->input->post('meta_description');
        $view_data['tags'] = $this->input->post('tags');
        if ($this->is_postback())
            $view_data['created_date'] = $this->input->post('created_date');
        else
            $view_data['created_date'] = date('d-m-Y');

        $view_data['scripts'] = $this->_get_scripts();
        $view_data['header'] = 'Thêm trang mới';
        $view_data['button_name'] = 'Thêm';
        $view_data['submit_uri'] = '/dashboard/pages/add';
        return $view_data;
    }

    private function _do_add_page() {
        $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required|xss_clean|max_length[256]');
        $this->form_validation->set_rules('uri', 'Đường dẫn', 'trim|required|xss_clean');
        $this->form_validation->set_rules('summary', 'Tóm tắt', 'trim|required|xss_clean|max_length[2000]');
        $this->form_validation->set_rules('content', 'Nội dung', 'trim|required|xss_clean');
        $this->form_validation->set_rules('created_date', 'Ngày đăng tin', 'trim|required|xss_clean|is_date');
//        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|xss_clean|matches_value[' . $this->phpsession->get('captcha') . ']');

        if ($this->form_validation->run()) {
            $post_data = $this->_get_posted_pages_data();
            $this->pages_model->add_page($post_data);

            redirect('/dashboard/pages');
        }
        return FALSE;
    }

    private function _get_posted_pages_data() {
        $content = str_replace('&lt;', '<', $this->input->post('content'));
        $content = str_replace('&gt;', '>', $content);
        $post_data = array(
            'title' => my_trim($this->input->post('title', TRUE)),
            'uri' => $this->input->post('uri', TRUE),
            'content' => my_trim($content),
            'uri' => $this->input->post('uri', TRUE),
            'summary' => $this->input->post('summary', TRUE),
            'meta_title' => $this->input->post('meta_title', TRUE),
            'meta_keywords' => $this->input->post('meta_keywords', TRUE),
            'meta_description' => $this->input->post('meta_description', TRUE),
            'tags' => $this->input->post('tags', TRUE),
            'status' => ACTIVE_PAGE
        );

        $created_date = explode('-', $this->input->post('created_date', TRUE));
        $post_data['created_date'] = date('Y-m-d', mktime(0, 0, 0, $created_date[1], $created_date[0], $created_date[2]));
        $post_data['created_date'] .= date(' H:i:s');
        return $post_data;
    }

    public function edit_page() {
        if (!$this->is_postback())
            redirect('/dashboard/pages');

        $view_data = array();
        $options = array();
        if ($this->is_postback() && !$this->input->post('from_list')) {
            if (!$this->_do_edit_page())
                $options['error'] = validation_errors();
        }


        $view_data = $this->_get_edit_form_data();
        if (isset($options['error']))
            $view_data['options'] = $options;

        //header
        $this->_title = 'Sửa page' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/add_page_form', $view_data, TRUE);
    }

    /**
     * Chuẩn bị dữ liệu cho form sửa
     * @return type
     */
    private function _get_edit_form_data() {
        $page_id = $this->input->post('page_id');

        // khi vừa vào trang sửa
        if ($this->input->post('from_list')) {
            $page = $this->pages_model->get_pages(array('id' => $page_id, 'is_admin' => TRUE));
            $id = $page->id;
            $title = $page->title;
            $uri = $page->uri;
            $summary = $page->summary;
            $content = $page->content;
            $created_date = date('d-m-Y', strtotime($page->created_date));
            $meta_title = $page->meta_title;
            $meta_keywords = $page->meta_keywords;
            $meta_description = $page->meta_description;
            $tags = $page->tags;
        }

        // khi submit
        else {
            $id = $page_id;
            $title = my_trim($this->input->post('title', TRUE));
            $uri = $this->input->post('uri');
            $summary = $this->input->post('summary');
            $content = '';
            $created_date = my_trim($this->input->post('created_date', TRUE));
            $meta_title = $this->input->post('meta_title', TRUE);
            $meta_keywords = $this->input->post('meta_keywords', TRUE);
            $meta_description = $this->input->post('meta_description', TRUE);
            $tags = $this->input->post('tags', TRUE);
        }

        $view_data = array();
        $view_data['id'] = $id;
        $view_data['title'] = $title;
        $view_data['uri'] = $uri;
        $view_data['summary'] = $summary;
        $view_data['content'] = $content;
        $view_data['created_date'] = $created_date;
        $view_data['meta_title'] = $meta_title;
        $view_data['meta_keywords'] = $meta_keywords;
        $view_data['meta_description'] = $meta_description;
        $view_data['tags'] = $tags;
        $view_data['header'] = 'SỬA TRANG';
        $view_data['button_name'] = 'Sửa';
        $view_data['submit_uri'] = '/dashboard/pages/edit';
        $view_data['scripts'] = $this->_get_scripts();

        return $view_data;
    }

    /**
     *  sửa trong DB nếu Validate OK
     * @return type
     */
    private function _do_edit_page() {
        $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required|xss_clean|max_length[256]');
        $this->form_validation->set_rules('uri', 'Đường dẫn', 'trim|required|xss_clean');
        $this->form_validation->set_rules('summary', 'Tóm tắt', 'trim|required|xss_clean|max_length[1000]');
        $this->form_validation->set_rules('content', 'Nội dung', 'trim|required|xss_clean');
        $this->form_validation->set_rules('created_date', 'Ngày đăng tin', 'trim|required|xss_clean|is_date');
//        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|xss_clean|matches_value[' . $this->phpsession->get('captcha') . ']');

        if ($this->form_validation->run()) {
            $post_data = $this->_get_posted_pages_data();
            $post_data['id'] = $this->input->post('page_id');
            $this->pages_model->update_page($post_data);

            redirect('/dashboard/pages');
        }
        return FALSE;
    }

    /**
     * Xóa tin
     */
    public function delete_page() {
        if ($this->is_postback()) {
            $page_id = $this->input->post('page_id');
            $this->pages_model->delete_page($page_id);
        }
        redirect('/dashboard/pages');
    }

    private function _get_scripts() {
        $scripts = '<script type="text/javascript" src="/duongbq/scripts/tiny_mce/tiny_mce.js?v=20111006"></script>';
        $scripts .= '<script language="javascript" type="text/javascript" src="/duongbq/scripts/tiny_mce/plugins/imagemanager/js/mcimagemanager.js?v=20111006"></script>';
        $scripts .= '<script type="text/javascript">enable_advanced_wysiwyg1("wysiwyg");</script>';
        return $scripts;
    }

    function process_page_status() {
        $id = $this->input->post('id');
        $page = $this->pages_model->get_pages(array('id' => $id, 'is_admin' => TRUE));
        $status = $page->status == ACTIVE_PAGE ? INACTIVE_PAGE : ACTIVE_PAGE;
        $this->pages_model->change_status($id, $status);
    }
    
    function save_cache()
    {
        if(save_cache('pages'))
            redirect('/dashboard/pages?save_cache=success');
        else
            redirect('/dashboard/pages?save_cache=error');
    }

}

?>
