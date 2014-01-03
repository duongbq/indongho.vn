<?php
class Homepage extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('commons');
        $this->load->model('pages/pages_model');
        }

    function index()
    {
        $current_menu           = array('current_menu' => '/'. $this->uri->uri_string());
        $layout                 = 'layout/main_layout';
        $options                = array();
        $view_data              = array();
        
        $lang = switch_language($this->uri->segment(1));
        $options['lang']                = $lang;
        $view_data['main_menu']         = modules::run('menus/menus/get_main_menus', $current_menu);
        $view_data['main_content']      = $this->_get_main_content(array('lang' => $lang));
        $view_data['slide_banner']      = modules::run('advertisements/advertisements/get_advertisements_slide_show',$options);
        $view_data['left_content']      = $this->_get_left_content(array('lang' => $lang));
        $view_data['is_home_page']      = TRUE;
        $this->load->helper('cache');
        $config = get_cache('configurations');
        $view_data['title']             = $config['meta_title'] . DEFAULT_TITLE_SUFFIX;
        $view_data['keywords']          = $config['meta_keywords'];
        $view_data['description']       = $config['meta_description'];
        $this->load->view($layout, $view_data, FALSE);
    }
    
    private function _get_main_content($options = array())
    {
        $output = '';
        $output .= modules::run('products/products/get_lastest_products');
        $output .= modules::run('news/news/get_latest_news',$options);
        return $output;
    }
    
    private function _get_left_content($options = array())
    {
        $output = '';
        $output .= modules::run('products/categories/get_left_categories',$options);
        $output .= modules::run('advertisements/advertisements/get_partners_advertisements',$options);
        return $output;
    }
    
    function get_sitemap_xml()
    {
        $this->load->model('sitemap_model');
        Header('Content-type: text/xml');
        echo $this->sitemap_model->generate_sitemap();
    }
    
}
?>
