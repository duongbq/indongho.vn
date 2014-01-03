<?php
class News_Admin extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if(!modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE))) redirect('/');
        if(!$this->phpsession->get("news_lang")) $this->phpsession->save('news_lang', 'vi');
    }

    function dispatcher($method=NULL, $para1=NULL, $para2=NULL)
    {
        $layout             = 'duongbq/admin_layout';
        $current_url        = '/dashboard/pages';
        
        switch ($method)
        {
            case 'list_news' :
//            case 'dashboard' :
                $lang = switch_language($para1);
                $this->phpsession->save('news_lang', $lang);
                $main_content   = $this->list_news(array('lang' => $para1, 'page' => $para2));
                $current_url    = '/dashboard/news/' . $para1;
                break;
            case 'add_news' :
                $main_content   = $this->add_news();
                break;
            case 'edit_news' :
                $main_content   = $this->edit_news();
                break;
            case 'delete_news' :
                $main_content   = $this->delete_news();
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

    function list_news($options = array())
    {
        $options            = array_merge($options, $this->_get_data_from_filter());
        $total_row          = $this->news_model->get_news_count($options);
        $total_pages        = (int)($total_row / ADMIN_NEWS_PER_PAGE);
        if ($total_pages * ADMIN_NEWS_PER_PAGE < $total_row) $total_pages++;
        if ((int)$options['page'] > $total_pages) $options['page'] = $total_pages;

        $options['offset']  = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int)$options['page'] - 1) * ADMIN_NEWS_PER_PAGE;
        $options['limit']   = ADMIN_NEWS_PER_PAGE;

        $config = prepare_pagination(
            array(
                'total_rows'    => $total_row,
                'per_page'      => $options['limit'],
                'offset'        => $options['offset'],
                'js_function'   => 'change_page_admin'
            )
        );
        $this->pagination->initialize($config);

        $view_data = array();
        $view_data['news']                  = $this->news_model->get_news($options);
        $view_data['search']                = $options['search'];
        $view_data['categories_combobox']   = $this->news_categories_model->get_categories_combo(array('categories_combobox' => $options['cat_id'], 'lang' => $options['lang']));
        $view_data['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();"'));

        $view_data['post_uri']              = 'news_admin';
        $view_data['page']                  = $options['page'];
        $view_data['total_rows']            = $total_row;
        $view_data['total_pages']           = $total_pages;
        $view_data['page_links']            = $this->pagination->create_ajax_links();
        $view_data['lang']                  = $options['lang'] != 'vi' ? '/' . $options['lang'] : '';

        $this->_title       = 'Quản lý tin tức' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/news_list',$view_data, TRUE);
    }
    /**
     * Lấy dữ liệu từ filter
     * @return string
     */
    private function _get_data_from_filter()
    {
        $options = array();

        if ( $this->is_postback())
        {
            $options['search']                  = $this->input->post('search', TRUE);
            $options['cat_id']                  = $this->input->post('categories_combobox');

            $this->phpsession->save('news_search_options', $options);
        }
        else
        {
            $temp_options = $this->phpsession->get('news_search_options');
            if (is_array($temp_options))
            {
                $options['search']              = $temp_options['search'];
                $options['cat_id']              = $temp_options['cat_id'];
            }
            else
            {
                $options['search']              = '';
                $options['cat_id']              = DEFAULT_COMBO_VALUE;
            }
        }
        $options['offset'] = $this->uri->segment(3);
        return $options;
    }

    public function add_news()
    {
        $options    = array();
        $view_data  = array();
        if($this->is_postback())
        {
            if (!$this->_do_add_news())
                $options['error'] = validation_errors();
        }
        $view_data = $this->_get_add_news_form_data();
        if (isset($options['error'])) $view_data['options']   = $options;

        //header
        $this->_title   = 'Thêm mới tin tức' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/add_news_form', $view_data, TRUE);
    }

    /**
     * Chuẩn bị dữ liệu cho form add
     * @return type
     */
    private function _get_add_news_form_data()
    {
        $view_data                  = array();
        $view_data['title']         = $this->input->post('title');
        $view_data['summary']       = $this->input->post('summary');
        $view_data['thumb']         = $this->input->post('thumb');
        $view_data['content']       = '';
        $view_data['meta_title']            = $this->input->post('meta_title');
        $view_data['meta_keywords']         = $this->input->post('meta_keywords');
        $view_data['meta_description']      = $this->input->post('meta_description');
        $view_data['tags']                  = $this->input->post('tags');
        if($this->is_postback())
        {
            $view_data['created_date']  = $this->input->post('created_date');
            $view_data['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang', TRUE), 'extra' => 'onchange="javascript:get_categories_by_lang();"'));
            $view_data['categories_combobox']   = $this->news_categories_model->get_categories_combo(array('categories_combobox' => $this->input->post('categories_combobox')
                                                                                                        , 'lang'                => $this->input->post('lang', TRUE)
                                                                                                        ));
        }
        else
        {
            $view_data['created_date']  = date('d-m-Y');
            $view_data['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get('news_lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();"'));
            $view_data['categories_combobox']   = $this->news_categories_model->get_categories_combo(array('categories_combobox' => $this->input->post('categories_combobox')
                                                                                                        , 'lang'                => $this->phpsession->get('news_lang')
                                                                                                        ));
        }

        $view_data['scripts']               = $this->_get_scripts();
        $view_data['header']        = 'Đăng tin tức';
        $view_data['button_name']   = 'Đăng tin tức';
        $view_data['submit_uri']    = '/dashboard/news/add';

//        $view_data['images_list'] = $this->_get_images_list();

        return $view_data;
    }

    private function _do_add_news()
    {
        $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required|xss_clean|max_length[256]');
        $this->form_validation->set_rules('categories_combobox', 'Loại tin', 'is_not_default_combo');
        $this->form_validation->set_rules('thumb', 'Hình minh họa', 'trim|required|xss_clean');
        $this->form_validation->set_rules('summary', 'Tóm tắt', 'trim|required|xss_clean|max_length[512]');
        $this->form_validation->set_rules('content', 'Nội dung', 'trim|required|xss_clean');
        $this->form_validation->set_rules('created_date', 'Ngày đăng tin', 'trim|required|xss_clean|is_date');
//        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|xss_clean|matches_value[' . $this->phpsession->get('captcha') . ']');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_news_data();
            $this->news_model->add_news($post_data);

            redirect('/dashboard/news/' . $this->phpsession->get('news_lang'));
        }
        return FALSE;
    }

    private function _get_posted_news_data()
    {
//        $thumbnail = $this->_add_news_thumbnail();

        $content = str_replace('&lt;', '<', $this->input->post('content'));
        $content = str_replace('&gt;', '>', $content);
        $post_data = array(
            'title'               => my_trim($this->input->post('title', TRUE)),
            'summary'             => my_trim($this->input->post('summary', TRUE)),
            'content'             => my_trim($content),
            'cat_id'              => $this->input->post('categories_combobox', TRUE),
            'meta_title'          => $this->input->post('meta_title', TRUE),
            'meta_keywords'       => $this->input->post('meta_keywords', TRUE),
            'meta_description'    => $this->input->post('meta_description', TRUE),
            'tags'                => $this->input->post('tags', TRUE),
            'lang'                => $this->input->post('lang', TRUE)
        );

        $created_date = explode('-', $this->input->post('created_date', TRUE));
        $post_data['created_date']  = date('Y-m-d', mktime(0, 0, 0, $created_date[1], $created_date[0], $created_date[2]));
        $post_data['created_date']  .= date(' H:i:s');

//        if ($this->input->post('image_id') != FALSE)
        $post_data['thumbnail'] = $this->input->post('thumb');
        return $post_data;
    }

    public function edit_news()
    {
        if(!$this->is_postback()) redirect('/dashboard/news');

        $view_data  = array();
        $options    = array();
        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit_news())
                $options['error'] = validation_errors();
        }


        $view_data = $this->_get_edit_form_data();
        if (isset($options['error'])) $view_data['options'] = $options;

        //header
        $this->_title   = 'Sửa tin tức' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/add_news_form', $view_data, TRUE);
    }
    /**
     * Chuẩn bị dữ liệu cho form sửa
     * @return type
     */
    private function _get_edit_form_data()
    {
        $news_id        = $this->input->post('news_id');

        // khi vừa vào trang sửa
        if($this->input->post('from_list'))
        {
            $news           = $this->news_model->get_news(array('id' => $news_id));
            $id             = $news->id;
            $title          = $news->title;
            $summary        = $news->summary;
            $content        = $news->content;
            $created_date   = date('d-m-Y', strtotime($news->created_date));
            $cat_id         = $news->cat_id;
            $thumb          = $news->thumbnail;
            $meta_title     = $news->meta_title;
            $meta_keywords  = $news->meta_keywords;
            $meta_description = $news->meta_description;
            $tags           = $news->tags;
            $lang           = $news->lang;
        }

        // khi submit
        else
        {
            $id             = $news_id;
            $title          = my_trim($this->input->post('title', TRUE));
            $summary        = my_trim($this->input->post('summary', TRUE));
            $content        = '';
            $created_date   = my_trim($this->input->post('created_date', TRUE));
            $cat_id         = $this->input->post('categories_combobox');
            $thumb          = $this->input->post('thumb');
            $meta_title     = $this->input->post('meta_title', TRUE);
            $meta_keywords  = $this->input->post('meta_keywords', TRUE);
            $meta_description = $this->input->post('meta_description', TRUE);
            $tags           = $this->input->post('tags', TRUE);
            $lang           = $this->input->post('lang', TRUE);
            
        }

        $view_data                  = array();
        $view_data['id']            = $id;
        $view_data['title']         = $title;
        $view_data['summary']       = $summary;
        $view_data['thumb']         = $thumb;
        $view_data['content']       = $content;
        $view_data['created_date']  = $created_date;
        $view_data['meta_title']            = $meta_title;
        $view_data['meta_keywords']         = $meta_keywords;
        $view_data['meta_description']      = $meta_description;
        $view_data['tags']                  = $tags;
        $view_data['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'onchange="javascript:get_categories_by_lang();"'));
        $view_data['header']        = 'Sửa tin tức';
        $view_data['button_name']   = 'Sửa tin tức';
        $view_data['submit_uri']    = '/dashboard/news/edit';
        $view_data['categories_combobox']   = $this->news_categories_model->get_categories_combo(array('categories_combobox' => $cat_id, 'lang' => $lang));
        $view_data['scripts']               = $this->_get_scripts();

        return $view_data;
    }
    /**
     *  sửa trong DB nếu Validate OK
     * @return type
     */
    private function _do_edit_news()
    {
        $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required|xss_clean|max_length[256]');
        $this->form_validation->set_rules('categories_combobox', 'Loại tin', 'is_not_default_combo');
        $this->form_validation->set_rules('thumb', 'Hình minh họa', 'trim|required|xss_clean');
        $this->form_validation->set_rules('summary', 'Tóm tắt', 'trim|required|xss_clean|max_length[512]');
        $this->form_validation->set_rules('content', 'Nội dung', 'trim|required|xss_clean');
        $this->form_validation->set_rules('created_date', 'Ngày đăng tin', 'trim|required|xss_clean|is_date');
//        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|xss_clean|matches_value[' . $this->phpsession->get('captcha') . ']');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_news_data();
            $post_data['id'] = $this->input->post('news_id');
            $this->news_model->update_news($post_data);

            redirect('/dashboard/news/' . $this->phpsession->get('news_lang'));
        }
        return FALSE;
    }

    /**
     * Xóa tin
     */
    public function delete_news()
    {
        if($this->is_postback())
        {
            $news_id = $this->input->post('news_id');
            $this->news_model->delete_news($news_id);
        }
        redirect('/dashboard/news/' . $this->phpsession->get('news_lang'));
    }

    private function _get_scripts()
    {
        $scripts                     = '<script type="text/javascript" src="/duongbq/scripts/tiny_mce/tiny_mce.js?v=20111006"></script>';
        $scripts                    .= '<script language="javascript" type="text/javascript" src="/duongbq/scripts/tiny_mce/plugins/imagemanager/js/mcimagemanager.js?v=20111006"></script>';
        $scripts                    .= '<script type="text/javascript">enable_advanced_wysiwyg("wysiwyg");</script>';
        return $scripts;
    }
}