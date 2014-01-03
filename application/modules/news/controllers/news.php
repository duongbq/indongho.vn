<?php
/**
 * Sửa lại toàn bộ module NEWS
 * @author: Tuấn Anh
 * @date: 2011-09-10
 */
class News extends MX_Controller
{
    var $parent_id = NULL;
    function __construct()
    {
        parent::__construct();
//        $this->output->enable_profiler(TRUE);
    }

    /**
     * Chuẩn bị layout, các phần dữ liệu cần thiết cho module này
     *
     * @param type $method
     * @param type $para1
     * @param type $para2
     */
    function dispatcher($method=NULL, $para1=NULL, $para2=NULL, $para3=NULL)
    {
        $main_content           = NULL;
        $layout                 = 'layout/content_layout';
        $current_url            = '';
        $breadcrumbs            = '';
        $lang                   = $this->_lang;
        $uri                    = '/' . $this->uri->uri_string();
        $options                = array();
        $options['lang']        = $lang;
        $options['current_menu'] = $uri;
        $is_detail              = FALSE;
        
        switch ($method)
        {
            case 'list_news' :
                $main_content       = $this->get_news_list(array('page' => $para1, 'lang' => $lang));
                $breadcrumbs        = modules::run('breadcrumbs/breadcrumbs_by_menus', array('uri' => $uri));
                if($this->input->get('q') != '')
                    $current_url = get_url_by_lang($lang, 'search') . '@?q='.str_replace (' ', '+', $this->input->get('q'));
                else
                    $current_url        = get_url_by_lang($lang, 'search');
                break;
            case 'list_news_by_cat' :
                $main_content       = $this->get_news_list(array('lang' => $para1, 'cat_id' => $para2, 'page' => $para3));
                if($lang != 'vi')
                    $current_url        = '/' . $lang . '/' . $this->uri->segment(2);
                else
                    $current_url        = '/' . $this->uri->segment(1);
                $breadcrumbs        = modules::run('breadcrumbs/breadcrumbs_by_menus', array('uri' => '/' . $this->uri->segment(1)));
                break;
            case 'news_detail' :
                $main_content       = $this->get_news_detail(array('cat_id' => $para2 , 'id' => $para3, 'lang' => $lang));
                $is_detail          = TRUE;
                $options['current_menu'] = '/' . $this->uri->segment(1) . '-n' . $para2;
                $breadcrumbs        = modules::run('breadcrumbs/breadcrumbs_news_detail', array('id' => $para3)); 
                break;
        }

        $view_data                      = modules::run('pages/pages/get_genaral_content', $options);
        $view_data['url']               = isset($current_url) ? $current_url : '';
        $view_data['breadcrumbs']       = $breadcrumbs;
        $view_data['main_content']      = $main_content;
        
        if($is_detail)
            $view_data['right_content']  = $this->get_latest_news(array(
                                            'cat_id' => $para2,
                                            'except_id' => $para3
                                            ));
        
        $view_data['title']             = $this->_title;
        $view_data['keywords']          = $this->_keywords;
        $view_data['description']       = $this->_description;
        
        $this->load->view($layout, $view_data);
    }

    /**
     * Trả lại menu là danh sách các Danh mục tin tức
     * @author Tuấn Anh
     * @date 2011-09-10
     * @param type $options
     * @return type
     */
    function get_categories_menu($options = array())
    {
        $view_data                  = array();
        $options['categories']      = $this->news_categories_model->get_categories($options);
        $options['parent_id']       = ROOT_CATEGORY_ID;
        $view_data['cat_id']        = isset ($options['cat_id']) ? $options['cat_id']: '';
        $cat_menu = '';
        $cat_menu .= $this->_visit($options);
        $cat_menu .= '';
        $view_data['categories']    = $cat_menu;
        $view_data['title']    = __('IP_news_categories');
        return $this->load->view('news/categories_menus', $view_data, TRUE);
    }

    private function _visit($options = array())
    {
        $output = '';
        $sub_cat = $this->_get_sub_cat($options);
        foreach($sub_cat as $cat)
        {
            $class = ($options['cat_id'] == $cat->id) ? ' class="selected"' : '';
            $output .= '<li'.$class.'>';
            $output .= '<a href="' . get_base_url() . url_title($cat->category, 'dash', TRUE) . '-n' . $cat->id . '">';
            $output .= $cat->category . '</a>';
            $output .= '<ul class="sub_categories">';
            $options['parent_id'] = $cat->id;
            $output .= $this->_visit($options);
            $output .= '</ul></li>';

        }
        return $output;

    }

    private function _get_sub_cat($options = array())
    {
        $cats = $options['categories'];
        $sub_cat = array();
        foreach($cats as $index => $cat)
        {
            if($cat->parent_id == $options['parent_id'])
                $sub_cat[$index] = $cat;
        }
        return $sub_cat;
    }

    /**
     * Trả lại danh sách các tin tức
     * @author Tuấn Anh
     * @date 2011-09-10
     * @param type $options
     * @return type
     */
    public function get_news_list($options = array())
    {
        $options   = $this->_get_data_from_filter($options);
        $options['search']  = $this->input->get('q');
        $view_data = array();
        $view_data = $this->_get_news($options);
        
        $view_data['post_uri'] = '/'.$this->uri->segment(1);
        $view_data['title']     = $view_data['title'];
        // header
        $this->_title       = $options['title'] . DEFAULT_TITLE_SUFFIX;
        $this->_keywords    = $options['keywords'];
        $this->_description = $options['description'];

        return $this->load->view('news/news_list', $view_data, TRUE);
    }
    /**
     * Trả lại danh sách các tin tức
     * @author Tuấn Anh
     * @date 2011-09-10
     * @param type $options
     * @return type
     */
    private function _get_news($options = array())
    {
        $config         = get_cache('configurations');
        $new_per_page   = $config['news_per_page'] != 0 ? $config['news_per_page'] : NEWS_PER_PAGE;
        $total_row          = $this->news_model->get_news_count($options);
        $total_pages        = (int)($total_row / $new_per_page);
        if ($total_pages * $new_per_page < $total_row) $total_pages++;
        if ((int)$options['page'] > $total_pages) $options['page'] = $total_pages;

        $options['offset']  = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int)$options['page'] - 1) * $new_per_page;

        $options['limit']   = $new_per_page;
        
        $config = prepare_pagination(
            array(
                'total_rows'    => $total_row,
                'per_page'      => $options['limit'],
                'offset'        => $options['offset'],
                'js_function'   => 'change_page'
            )
        );

        $this->pagination->initialize($config);


        $view_data                  = array();
        $news                       = $this->news_model->get_news($options);
        $view_data['news']          = $news;
        $view_data['pagination']    = $this->pagination->create_ajax_links();
        $view_data['title']         = $options['title'];
        $view_data['keywords']      = $options['keywords'];
//        $view_data['description']   = $options['description'];

        return $view_data;
    }
    /**
     * Chuẩn bị các dữ liệu cần thiết
     * @author Tuấn Anh
     * @date 2011-09-10
     * @param type $options
     * @return type
     */
    private function _get_data_from_filter($options = array())
    {
        if (isset($options['cat_id']) && $options['cat_id']!=DEFAULT_COMBO_VALUE)
        {
            $category               = $this->news_categories_model->get_categories(array('id' => $options['cat_id']));
            if(!is_object($category)) return show_404();
            $options['cat_id']      = $category->id;
            
            // vào danh mục rồi nhưng chưa có meta_title
            if(is_object($category) && $category->meta_title == '')
            {
                $options['title']       = $category->category;
                $options['keywords']    = $options['title'];
                $options['description'] = $options['title'];
            }
            else
            {
                $options['title']       = $category->meta_title;
                $options['keywords']    = $category->meta_keywords;
                $options['description'] = $category->meta_description;
            }
        }
        if (!isset($options['title']))
        {
            $options['title']       = __("IP_news_list");
            $options['keywords']    = $options['title'];
            $options['description'] = $options['title'];
        }
        return $options;
    }

    function get_news_detail($options = array(), & $extra = array())
    {
        $this->news_model->update_view($options['id']);

        $news                   = $this->news_model->get_news(array('id' => $options['id']));
        if(empty($news)){ show_404(); }
        $extra['cat_id']        = isset($news->categories_id) && !empty($news->categories_id) ? $news->categories_id : ROOT_CATEGORY_ID;
        $lastest_news['title']  = __('IP_newer_post');
        $lastest_news['news']   = $this->news_model->get_news(array('flag' => LATEST_NEWS,
                                                                'created_date' => $news->created_date,
                                                                'cat_id' => $options['cat_id']));

        $older_news['title']    = __('IP_older_post');
        $older_news['news']     = $this->news_model->get_news(array('id' => $news->id,
                                                                     'flag' => OLDER_NEWS,
                                                                     'created_date' => $news->created_date,
                                                                     'cat_id' => $options['cat_id']));
        $view_data['lastest_news']  = $this->load->view('related_news', $lastest_news, TRUE);
        $view_data['older_news']    = $this->load->view('related_news', $older_news, TRUE);
        $view_data['news']          = $news;
        if($news->tags != '')
            $view_data['tags']          = genarate_tags($news->tags, 'tin-tuc');

        $view_data['title'] = $news->meta_title != '' ? $news->meta_title : $news->title;
        //header
        $this->_title       = ($news->meta_title != '' ? $news->meta_title : $news->title) . DEFAULT_TITLE_SUFFIX;
        $this->_keywords    = $news->meta_keywords != '' ? $news->meta_keywords : $news->title;
        $this->_description = $news->meta_description != '' ? $news->meta_description : $news->summary;
        return $this->load->view('news/news_detail', $view_data, TRUE);
    }

    function get_latest_news($options = array())
    {
        $config                     = get_cache('configurations');
        $options['limit']           = $config['news_side_per_page'] != 0 ? $config['news_side_per_page'] : LATEST_NEWS;
        $options['lang']            = $this->_lang;
        $view_data                  = array();
        $view_data['news']          = $this->news_model->get_news($options);
        return $this->load->view('news/latest_news', $view_data, TRUE);
    }

    function get_related_news($options = array())
    {
        
        $options['limit']           = RELATED_NEWS_LIMIT;
        $view_data = array();
        $view_data['news']          = $this->news_model->get_news($options);
        return $this->load->view('news/related_news', $view_data, TRUE);
    }
}
