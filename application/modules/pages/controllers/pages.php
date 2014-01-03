<?php

class Pages extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Chuẩn bị layout, các phần dữ liệu cần thiết cho module này
     *
     * @param type $method
     * @param type $para1
     * @param type $para2
     */
    function dispatcher($method='', $para1=NULL, $para2=NULL, $para3=NULL)
    {
        $main_content           = NULL;
        $layout                 = 'layout/content_layout';
        $lang                   = $this->_lang;
        $breadcrumbs            = '';
        $data                   = NULL;
        switch ($method)
        {
            case 'page_detail' :
                $uri = '/' . (trim($para2) != '' ? $para1 . '/' . $para2 : $para1 ). '.htm';
                $main_content           = $this->get_page_detail($data, array('uri' => trim($uri)));
                $breadcrumbs        = modules::run('breadcrumbs/breadcrumbs_with_param', array(
                    array(
                        'uri' => $data['uri'], 
                        'name' => $data['title']
                    ),
                    array(
                        'uri' => get_base_url(), 
                        'name' => __('IP_home_page')
                    )
                ));
                break;
        }
        
        $view_data                      = $this->get_genaral_content(array('lang' => $lang, 'current_menu' => '/' . $this->uri->uri_string()));
        $view_data['breadcrumbs']       = $breadcrumbs;
        $view_data['main_content']      = $main_content;
        $view_data['title']             = $this->_title;
        $view_data['keywords']          = $this->_keywords;
        $view_data['description']       = $this->_description;
        
        $this->load->view($layout, $view_data);
    }
    
    public function get_genaral_content($options = array())
    {
        $view_data                      = array();
        $view_data['main_menu']         = modules::run('menus/menus/get_main_menus', $options);
        $view_data['slide_banner']      = modules::run('advertisements/advertisements/get_advertisements_slide_show',$options);
        $view_data['left_content']      = $this->_get_left_content($options);
        return $view_data;
    }
    
    private function _get_left_content($options = array())
    {
        $output = '';
        $output .= modules::run('products/categories/get_left_categories',$options);
        $output .= modules::run('advertisements/advertisements/get_partners_advertisements',$options);
        return $output;
    }

    function get_page_data($options = array())
    {
        $output = array();
        $pages = $this->pages_model->get_pages($options);
        foreach($pages as $page)
        {
            $output[$page['uri']] = $page;
        }
        return $output;
    }
    
    function get_page_detail( & $_data, $options = array())
    {
        $uri = $options['uri'];
        $pages = get_cache('pages');
        if(!isset($pages[$uri])) return show_404();
        $page = $pages[$uri];
        
        $_data              = $page;
        
        $view_data          = array();
        $view_data['page']  = $page;

        $this->_title       = $page['meta_title'] != '' ? $page['meta_title'] : $page['title'] . DEFAULT_TITLE_SUFFIX;
        $this->_keywords    = $page['meta_keywords'] != '' ? $page['meta_keywords'] : $page['title'];
        $this->_description = $page['meta_description'] != '' ? $page['meta_description'] : strip_tags($page['summary']);

        return $this->load->view('page_detail', $view_data, TRUE);
    }
    
    function get_static_page_content($options = array()) 
    {
        $output = '';
        $uri    = $options['uri'];
        $pages = get_cache('pages');
        if( isset($options['get_summary']) )
            $output = $pages[$uri]['summary'];
        else
            $output = $pages[$uri]['content'];
        return $output;
    }
}
?>
