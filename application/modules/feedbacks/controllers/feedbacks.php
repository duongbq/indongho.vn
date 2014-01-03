<?php

class Feedbacks extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function dispatcher($method='', $para1=NULL, $para2=NULL, $para3=NULL)
    {
        $current_menu        = array('current_menu' => '/');
        $main_content        = NULL;
        $main_content_params = array();
        $layout = 'layout/main_layout';

        switch ($method)
        {
            case 'send_feedback' :
                $adv_content            = modules::run('advertisements/advertisements/get_advertisements_slide_show');
                $main_content           = $adv_content . $this->feedback();
                break;
        }

        $view_data                      = array();
        $view_data['main_menu']         = modules::run('menus/menus/get_main_menus');
        $view_data['side_content']      = $this->_get_side_content(NULL);
        $view_data['main_content']      = $main_content;
        $view_data['title']             = $this->_title;
        $view_data['keywords']          = $this->_keywords;
        $view_data['description']       = $this->_description;

        $this->load->view($layout, $view_data);
    }

    /**
     * Chuẩn bị dữ liệu cho side content
     *
     * @param type $options
     */
    private function _get_side_content($options = array())
    {
        $output = modules::run('products/categories/left_categories', $options);
        $output .= modules::run('supports/supports/get_supports');
        $output .= $this->get_feedbacks();
        return $output;
    }

    function get_feedbacks()
    {
        $view_data              = array();
        $options                = array();
        $options['limit']       = FEEDBACK_LIMIT;
        $view_data['feedbacks'] = $this->feedbacks_model->get_feedbacks($options);
        return $this->load->view('feedbacks', $view_data, TRUE);
    }

    function feedback()
    {
        $options = array();

        if ($this->is_postback())
            if (!$this->_send_feedback())
                $options['error'] = $this->_last_message;
            else
                $options['succeed'] = $this->_last_message;

        // prepare page header info.

        $this->_title   = 'Ý kiến khách hàng' . DEFAULT_TITLE_SUFFIX;
        $this->_keywords    = $this->_title . ' ' . $this->_keywords;
        $this->_description = $this->_description;
        // end.

        return $this->load->view('feedback_form', array('options' => $options), TRUE);
    }

    private function _send_feedback()
    {
        $this->_last_message  = '';
        $options                    = array();

        $this->form_validation->set_rules('name', 'Họ tên', 'trim|required|xss_clean');
        $this->form_validation->set_rules('content', 'Ý kiến của bạn', 'trim|required|xss_clean');
        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|matches_value[' . $this->phpsession->get('captcha') . ']|xss_clean');

        if ($this->form_validation->run())
        {
            $data = array(
                'customer'      => $this->input->post('name'),
                'content'       => $this->input->post('content'),
                'created_date'  => date('Y-m-d H:i:s'),
                'status'        => INACTIVE_FEEDBACK

                );

            $this->feedbacks_model->add_feedback($data);
            $this->_last_message = '<p>Bạn đã gửi ý kiến phản hồi thành công.</p>';
            return TRUE;
        }
        else
        {
            $this->_last_message = validation_errors();
            return FALSE;
        }
    }

}
?>