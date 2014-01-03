<?php
class Feedbacks_Admin extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if(!modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE))) redirect('/');
        if(!$this->phpsession->get("feedback_lang")) $this->phpsession->save('feedback_lang', 'vi');
    }

    function dispatcher($method='', $para1=NULL, $para2=NULL)
    {
        $layout             = 'duongbq/admin_layout';
        $lang               = switch_language($para1);
        switch ($method)
        {
            
            case 'list_feedbacks':
                $this->phpsession->save('feedback_lang', $lang);
                $params        = array('page' => $para2, 'lang' => $lang);
                $main_content       = $this->list_feedbacks($params);
                $current_url        = '/dashboard/feedbacks/' . $lang;
                break;
            case 'add_feedback' :
                $main_content       = $this->add_feedback();
                break;
            case 'edit_feedback' :
                $main_content       = $this->edit_feedback();
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

    function list_feedbacks($options = array())
    {
        $options            = array_merge($options, $this->_get_data_from_filter());
        $total_row          = $this->feedbacks_model->get_feedbacks_count($options);
        $total_pages        = (int)($total_row / FEEDBACK_PER_PAGE);
        if ($total_pages * FEEDBACK_PER_PAGE < $total_row) $total_pages++;
        if ((int)$options['page'] > $total_pages) $options['page'] = $total_pages;

        $options['offset']  = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int)$options['page'] - 1) * FEEDBACK_PER_PAGE;
        $options['limit']   = FEEDBACK_PER_PAGE;

        $config = prepare_pagination(
            array(
                'total_rows'    => $total_row,
                'per_page'  => $options['limit'],
                'offset'        => $options['offset'],
                'js_function'   => 'change_page_admin'
            )
        );
        $this->pagination->initialize($config);

        $options['is_admin']                = TRUE;
        $view_data = array();
        $view_data['feedbacks']             = $this->feedbacks_model->get_feedbacks($options);
        $view_data['search']                = $options['search'];
        $view_data['page']                  = $options['page'];
        $view_data['total_rows']            = $total_row;
        $view_data['total_pages']           = $total_pages;
        $view_data['page_links']            = $this->pagination->create_ajax_links();
        $view_data['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();"'));
        $this->_title                       = 'Quản lý ý kiến phản hồi' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/list_feedbacks',$view_data, TRUE);
    }

    private function _get_data_from_filter()
    {
        $options = array();

        if ( $this->is_postback())
        {
            $options['search']                  = $this->input->post('search', TRUE);
            $this->phpsession->save('feedback_search', $options);
        }
        else
        {
            $temp_options = $this->phpsession->get('feedback_search');
            if (is_array($temp_options))
            {
                $options['search']              = $temp_options['search'];
            }
            else
            {
                $options['search']              = '';
            }
        }
        return $options;
    }

    public function add_feedback()
    {
        $options    = array();
        $view_data  = array();
        if($this->is_postback())
        {
            if (!$this->_do_add_feedback())
                $options['error'] = validation_errors();
        }
        $view_data = $this->_get_add_feedback_form_data();
        if (isset($options['error'])) $view_data['options']   = $options;
        
        //header
        $this->_title   = 'Thêm trang mới' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/add_feedback_form', $view_data, TRUE);
    }

    /**
     * Chuẩn bị dữ liệu cho form add
     * @return type
     */
    private function _get_add_feedback_form_data()
    {
        $view_data                          = array();
        $view_data['customer']              = $this->input->post('customer');
        $view_data['content']               = '';
        if($this->is_postback())
            $view_data['created_date']      = $this->input->post('created_date');
        else
            $view_data['created_date']      = date('d-m-Y');

        $view_data['header']                = 'Thêm ý kiến phản hồi';
        $view_data['button_name']           = 'Thêm';
        $view_data['submit_uri']            = '/dashboard/feedbacks/add';
        $view_data['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get("feedback_lang")));
        return $view_data;
    }

    private function _do_add_feedback()
    {
        $this->form_validation->set_rules('customer', 'Tên khách hàng', 'trim|required|xss_clean|max_length[50]');
        $this->form_validation->set_rules('content', 'Ý kiến phản hồi', 'trim|required|xss_clean');
        $this->form_validation->set_rules('created_date', 'Ngày đăng tin', 'trim|required|xss_clean|is_date');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_feedbacks_data();
            $this->feedbacks_model->add_feedback($post_data);

            redirect('/dashboard/feedbacks/' . $this->phpsession->get('feedback_lang'));
        }
        return FALSE;
    }

    private function _get_posted_feedbacks_data()
    {
        $post_data = array(
            'customer'            => my_trim($this->input->post('customer', TRUE)),
            'content'             => my_trim($this->input->post('content')),
            'status'              => ACTIVE_FEEDBACK,
            'lang'                => $this->input->post('lang')
        );

        $created_date = explode('-', $this->input->post('created_date', TRUE));
        $post_data['created_date']  = date('Y-m-d', mktime(0, 0, 0, $created_date[1], $created_date[0], $created_date[2]));
        $post_data['created_date']  .= date(' H:i:s');
        return $post_data;
    }

    public function edit_feedback()
    {
        if(!$this->is_postback()) redirect('/dashboard/feedbacks');

        $view_data  = array();
        $options    = array();
        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit_feedback())
                $options['error'] = validation_errors();
        }


        $view_data = $this->_get_edit_form_data();
        if (isset($options['error'])) $view_data['options'] = $options;

        //header
        $this->_title   = 'Sửa ý kiến phản hồi' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/add_feedback_form', $view_data, TRUE);
    }
    /**
     * Chuẩn bị dữ liệu cho form sửa
     * @return type
     */
    private function _get_edit_form_data()
    {
        $feedback_id        = $this->input->post('feedback_id');

        // khi vừa vào trang sửa
        if($this->input->post('from_list'))
        {
            $feedback       = $this->feedbacks_model->get_feedbacks(array('id' => $feedback_id, 'is_admin' => TRUE));
            $id             = $feedback->id;
            $customer       = $feedback->customer;
            $content        = $feedback->content;
            $created_date   = date('d-m-Y', strtotime($feedback->created_date));
            $lang           = $feedback->lang;
        }

        // khi submit
        else
        {
            $id             = $feedback_id;
            $customer       = my_trim($this->input->post('customer', TRUE));
            $content        = '';
            $created_date   = my_trim($this->input->post('created_date', TRUE));
            $lang           = $this->input->post('lang');
        }

        $view_data                          = array();
        $view_data['id']                    = $id;
        $view_data['customer']              = $customer;
        $view_data['content']               = $content;
        $view_data['created_date']          = $created_date;
        $view_data['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $lang));
        $view_data['header']                = 'Sửa ý kiến phản hồi';
        $view_data['button_name']           = 'Sửa';
        $view_data['submit_uri']            = '/dashboard/feedbacks/edit';
        return $view_data;
    }
    /**
     *  sửa trong DB nếu Validate OK
     * @return type
     */
    private function _do_edit_feedback()
    {
        $this->form_validation->set_rules('customer', 'Tên khách hàng', 'trim|required|xss_clean|max_length[50]');
        $this->form_validation->set_rules('content', 'Ý kiến phản hồi', 'trim|required|xss_clean');
        $this->form_validation->set_rules('created_date', 'Ngày đăng tin', 'trim|required|xss_clean|is_date');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_feedbacks_data();
            $post_data['id'] = $this->input->post('feedback_id');
            $this->feedbacks_model->update_feedback($post_data);

            redirect('/dashboard/feedbacks/' . $this->phpsession->get('feedback_lang'));
        }
        return FALSE;
    }

    /**
     * Xóa tin
     */
    public function delete_feedback()
    {
        if($this->is_postback())
        {
            $feedback_id = $this->input->post('feedback_id');
            $this->feedbacks_model->delete_feedback($feedback_id);
        }
        redirect('/dashboard/feedbacks/' . $this->phpsession->get('feedback_lang'));
    }

    function process_feedback_status()
    {
        $id = $this->input->post('id');
        $feedback = $this->feedbacks_model->get_feedbacks(array('id' =>$id, 'is_admin' => TRUE));
        $status = $feedback->status == ACTIVE_FEEDBACK ? INACTIVE_FEEDBACK : ACTIVE_FEEDBACK;
        $this->feedbacks_model->change_status($id, $status);
    }
}
?>
