<?php

class Advertisements extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function dispatcher($method='list_products', $para1=NULL, $para2=NULL, $para3=NULL)
    {
        $main_content           = NULL;
        $layout                 = 'layout/content_layout';
        $breadcrumbs            = '';
        $lang                   = switch_language($para1);
        
        switch ($method)
        {
            case 'list_project' :
                $main_content       = $this->get_partners_advertisements();
                $breadcrumbs = modules::run('breadcrumbs/breadcrumbs_with_param', array(array('uri' => get_url_by_lang($lang,'projects'), 'name' => __('IP_Projects'))));
                break;
        }

        $view_data                      = array();
        $view_data                      = modules::run('pages/pages/get_genaral_content', array('lang' => $lang, 'current_menu' => '/' . $this->uri->uri_string()));
        $view_data['breadcrumbs']       = $breadcrumbs;
        $view_data['url']               = isset($current_url) ? $current_url : '';
        $view_data['side_content']      = modules::run('pages/get_side_content', array('lang' => $lang)); 
        $view_data['main_content']      = $main_content;
        
        $config = get_cache('configurations');
        $view_data['title']             = $config['meta_title'] . DEFAULT_TITLE_SUFFIX;
        $view_data['keywords']          = $config['meta_keywords'];
        $view_data['description']       = $config['meta_description'];

        $this->load->view($layout, $view_data);
    }
    
    function get_advertisements_slide_show($options = array())
    {
        
        $this->output->link_js('/scripts/jquery.slideshow.js');
        $view_data = array();
        $options['type'] = SLIDE;
        $options['lang'] = $this->_lang;
        $view_data['advs'] = $this->advertisements_model->get_advertisements($options);
        if(count($view_data['advs']) == 0)
        {
            $options['lang'] = 'vi';
            $view_data['advs'] = $this->advertisements_model->get_advertisements($options);
        }
        
        return $this->load->view('advertisements_slide_show', $view_data, TRUE);
    }
    
    function get_service_advertisements()
    {
        $view_data = array();
        $view_data['advs'] = $this->advertisements_model->get_advertisements(array('type' => SERVICE));
        return $this->load->view('service_advertisements', $view_data, TRUE);
    }
    
    function get_partners_advertisements($options = array())
    {
        $view_data = array();
        $view_data['advs'] = $this->advertisements_model->get_advertisements(array('type' => PARTNER));
        return $this->load->view('partners_advertisements', $view_data, TRUE);
    }
}
?>