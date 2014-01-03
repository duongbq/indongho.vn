<?php

class Feedbacks extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function dispatcher($method='', $para1=NULL, $para2=NULL, $para3=NULL)
    {
        $lang               = $this->_lang;
        $menu_params        = array('lang' => $lang);
        $main_content       = NULL;
        $layout             = 'layout/main_layout';

        switch ($method)
        {
            case 'send_feedback' :
                $adv_content            = modules::run('advertisements/advertisements/get_advertisements_slide_show', $menu_params);
                $main_content           = $adv_content . $this->feedback();
                break;
        }

        $view_data                      = array();
        $view_data['main_menu']         = modules::run('menus/menus/get_main_menus', $menu_params);
        $view_data['side_content']      = modules::run('products/products/get_side_content', $menu_params);
        $view_data['main_content']      = $main_content;
        $view_data['title']             = $this->_title;
        $view_data['keywords']          = $this->_keywords;
        $view_data['description']       = $this->_description;

        $this->load->view($layout, $view_data);
    }

    function get_feedbacks($options = array())
    {
        $view_data              = array();
        $options['limit']       = FEEDBACK_LIMIT;
        $view_data['feedbacks'] = $this->feedbacks_model->get_feedbacks($options);
        $view_data['lang']      = $this->_lang;
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

        $view_data = array();
        if(isset($options['error']) || isset($options['succeed']))
            $view_data['options'] = $options;
        $view_data['lang']  = $this->_lang;
        // prepare page header info.
        $this->_title       = __("IP_testimonial") . DEFAULT_TITLE_SUFFIX;
        $this->_keywords    = $this->_title . ' ' . $this->_keywords;
        $this->_description = $this->_description;
        // end.

        return $this->load->view('feedback_form', $view_data, TRUE);
    }

    private function _send_feedback()
    {
        $this->_last_message  = '';
        $this->form_validation->set_rules('name', __("IP_fullname"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('content', __("IP_your_testimonial"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('security_code', __("IP_captcha"), 'trim|required|matches_value[' . $this->phpsession->get('captcha') . ']|xss_clean');

        if ($this->form_validation->run())
        {
            $data = array(
                'customer'      => $this->input->post('name'),
                'content'       => $this->input->post('content'),
                'created_date'  => date('Y-m-d H:i:s'),
                'status'        => INACTIVE_FEEDBACK,
                'lang'          => $this->_lang
                );

            $this->feedbacks_model->add_feedback($data);
            $this->_last_message = '<p>' . __("IP_send_testimonial_success_mes") . '</p>';
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