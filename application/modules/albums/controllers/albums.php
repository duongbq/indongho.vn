<?php

class Albums extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
    }
    
    function dispatcher($method=NULL, $para1=NULL, $para2=NULL, $para3=NULL)
    {
        $main_content           = NULL;
        $layout                 = 'layout/content_layout';
        $current_url            = '';
        $breadcrumbs            = '';
        $lang                   = $this->_lang;
        $uri                    = '/' . $this->uri->uri_string();
        switch ($method)
        {
            case 'list_album' :
                $main_content       = $this->list_album(array('page' => $para1, 'lang' => $lang));
                $breadcrumbs        = modules::run('breadcrumbs/breadcrumbs_by_menus', array('uri' => $uri));
                break;
            case 'album_detail' :
                $this->output->link_css('/css/fancybox/jquery.fancybox-1.3.4.css');
                $this->output->link_js('/duongbq/scripts/fancybox/jquery.fancybox-1.3.4.pack.js');
                $this->output->javascripts('show_fancy_box();');
                $main_content       = $this->get_album_detail(array('id' => $para1, 'lang' => $lang));
                $breadcrumbs        = modules::run('breadcrumbs/breadcrumbs_by_menus', array('uri' => '/' . $this->uri->segment(1)));
                break;
        }

        $view_data                      = modules::run('pages/pages/get_genaral_content', array('lang' => $lang, 'current_menu' => '/thu-vien-anh'));
        $view_data['url']               = isset($current_url) ? $current_url : '';
        $view_data['breadcrumbs']       = $breadcrumbs;
        $view_data['main_content']      = $main_content;

        $view_data['title']             = $this->_title;
        $view_data['keywords']          = $this->_keywords;
        $view_data['description']       = $this->_description;
        
        $this->load->view($layout, $view_data);
    }

    function list_album($options = array())
    {
        $this->output->link_js('/scripts/jquery.jcarousel.min.js');
        $this->output->javascripts('run_slide_images();');
        $view_data              = array();
        $album                  = $this->albums_model->get_albums();
        $view_data['albums']    = $album;
        return $this->load->view('albums', $view_data, TRUE);
    }
    
    function get_album_detail($options = array())
    {
        $view_data              = array();
        $album                  = $this->albums_model->get_albums($options);
        if(!is_object($album)) return show_404();
        $view_data['images']    = $this->albums_images_model->get_images(array('album_id' => $options['id']));
        $view_data['album_name']= $album->name;
        return $this->load->view('album_detail', $view_data, TRUE);
    }
}
?>