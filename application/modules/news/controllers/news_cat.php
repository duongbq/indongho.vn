<?php
class News_Cat extends MX_Controller
{
   function  __construct()
    {
        parent::__construct();
        if(!modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE))) redirect('/');
        if(!$this->phpsession->get("news_cat_lang")) $this->phpsession->save('news_cat_lang', 'vi');
    }

    function dispatcher($method=NULL, $para1=NULL, $para2=NULL)
    {
        $menu_params        = array('current_menu' => '/' . $this->uri->uri_string());
        $layout             = 'duongbq/admin_layout';
        $current_url        = '/dashboard/pages';

        $lang = switch_language($para1);
        
        switch ($method)
        {
            case 'list_cat' :
                $main_content   = $this->list_cat(array('lang' => $lang, 'page' => $para2));
                $this->phpsession->save('news_cat_lang', $lang);
                break;
             case 'add_cat' :
                $main_content   = $this->add_cat();
                break;
            case 'edit_cat' :
                $main_content   = $this->edit_cat();
                break;
            case 'delete_cat' :
                $main_content   = $this->delete_cat();
                break;
        }

        $view_data                  = array();
        $view_data['url']           = isset($current_url) ? $current_url : '';
        $view_data['admin_menu']    = modules::run('menus/menus/get_dashboard_menus', $menu_params);
        $view_data['main_content']  = $main_content;
        $view_data['title']         = $this->_title;
        $this->load->view($layout, $view_data);
    }

    public function list_cat($options = array())
    {
        $view_data = array();
        $view_data['categories'] = $this->news_categories_model->get_categories_object_array_by_parent_id(array('parent_id' => ROOT_CATEGORY_ID, 'lang' => $options['lang']));
        if (isset($options['error']))
            $view_data['options']   = $options;
        $view_data['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();"'));
        $view_data['lang']                  = $options['lang'] != 'vi' ? '/' . $options['lang'] : '';
        //header
        $this->_title       = 'Danh mục tin tức' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('cat/list_cat', $view_data, TRUE);
    }

    public function add_cat()
    {
        $options    = array();

        if($this->is_postback())
        {
            if (!$this->_do_add_cat())
                $options['error'] = validation_errors();
        }
        $view_data  = array();
        $view_data = $this->_get_add_cat_form_data();

        if (isset($options['error'])) $view_data['options']   = $options;

        $view_data['header']        = 'Thêm danh mục tin tức mới';
        $view_data['button_name']   = 'Thêm danh mục';
        $view_data['submit_uri']    = '/dashboard/news/categories/add';

        //header
        $this->_title       = 'Thêm danh mục tin tức' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('cat/add_cat_form', $view_data, TRUE);
    }

    private function _get_add_cat_form_data()
    {
        $view_data = array();
        $view_data['category'] = $this->input->post('category');
        $view_data['meta_title']            = $this->input->post('meta_title');
        $view_data['meta_keywords']         = $this->input->post('meta_keywords');
        $view_data['meta_description']      = $this->input->post('meta_description');
        if($this->is_postback())
        {
            $view_data['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang', TRUE), 'extra' => 'onchange="javascript:get_categories_by_lang();"'));
            $view_data['categories_combobox']   = $this->news_categories_model->
                                                    get_categories_combo(array('categories_combobox' => 
                                                                                $this->input->post('categories_combobox')
                                                                                , 'is_add_edit_cat' => TRUE
                                                                                , 'lang' => $this->input->post('lang', TRUE)
                                                                                ));
        }
        else
        {
            $view_data['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get('news_cat_lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();"'));
            $view_data['categories_combobox']   = $this->news_categories_model->
                                                    get_categories_combo(array('categories_combobox' => 
                                                                                $this->input->post('categories_combobox')
                                                                                , 'is_add_edit_cat' => TRUE
                                                                                , 'lang' => $this->phpsession->get('news_cat_lang')
                                                                                ));
        }
        return $view_data;
    }

    private function _do_add_cat()
    {
        $this->form_validation->set_rules('category', 'Tên loại', 'trim|required|xss_clean|max_length[256]');
        if($this->form_validation->run())
        {
            $data = array(
                'category'          => strip_tags($this->input->post('category')),
                'parent_id'         => $this->input->post('categories_combobox') == DEFAULT_COMBO_VALUE ? ROOT_CATEGORY_ID : $this->input->post('categories_combobox'),
                'meta_title'        => $this->input->post('meta_title', TRUE),
                'meta_keywords'     => $this->input->post('meta_keywords', TRUE),
                'meta_description'  => $this->input->post('meta_description', TRUE),
                'lang'              => $this->input->post('lang', TRUE)
            );
            if($this->input->post('categories_combobox') == DEFAULT_COMBO_VALUE)
            {
               $categories = $this->news_categories_model->get_categories(array('parent_id' => ROOT_CATEGORY_ID,
                                                                           'last_row' => TRUE));
            }
            else
            {
                $categories = $this->news_categories_model->get_categories(array('parent_id' => $this->input->post('categories_combobox'),
                                                                            'last_row' => TRUE));
            }
            $data['position'] = is_object($categories) ? $categories->position + 1 : 1;
            $this->news_categories_model->add_category($data);

            redirect('/dashboard/news/categories/'  . $this->phpsession->get('news_cat_lang'));
        }
        return FALSE;
    }


    public function edit_cat()
    {
        $options    = array();

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit_cat())
                $options['error'] = validation_errors();
        }
        $view_data  = array();
        $view_data  = $this->_get_edit_cat_form_data();

        if (isset($options['error'])) $view_data['options']   = $options;

        $view_data['header']        = 'Sửa danh mục tin tức';
        $view_data['button_name']   = 'Sửa danh mục';
        $view_data['submit_uri']    = '/dashboard/news/categories/edit';

        //header
        $this->_title       = 'Sửa danh mục tin tức' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('cat/add_cat_form', $view_data, TRUE);
    }

    private function _get_edit_cat_form_data()
    {
        $cat_id = $this->input->post('cat_id');

        if($this->input->post('from_list'))
        {
            $categories = $this->news_categories_model->get_categories(array('id' => $cat_id));
            $category   = $categories->category;
            $parent_id  = $categories->parent_id;
            $meta_title             = $categories->meta_title;
            $meta_keywords          = $categories->meta_keywords;
            $meta_description       = $categories->meta_description;
            $lang                   = $categories->lang;
        }
        else
        {
            $category           = $this->input->post('category');
            $parent_id          = $this->input->post('categories_combobox');
            $meta_title         = $this->input->post('meta_title');
            $meta_keywords      = $this->input->post('meta_keywords');
            $meta_description   = $this->input->post('meta_description');
            $lang               = $this->input->post('lang');

        }
        $view_data = array();

        $view_data['cat_id'] = $cat_id;
        $view_data['category'] = $category;
        $view_data['categories_combobox']   = $this->news_categories_model->get_categories_combo(array('categories_combobox' => $parent_id, 'lang' => $lang, 'is_add_edit_cat' => TRUE));
        $view_data['meta_title']            = $meta_title;
        $view_data['meta_keywords']         = $meta_keywords;
        $view_data['meta_description']      = $meta_description;
        $view_data['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'onchange="javascript:get_categories_by_lang();"'));
        return $view_data;
    }

    private function _do_edit_cat()
    {
        $this->form_validation->set_rules('category', 'Tên loại', 'trim|required|xss_clean|max_length[256]');
        if($this->form_validation->run())
        {
            $data = array(
                'id'                => $this->input->post('cat_id'),
                'category'          => $this->input->post('category', TRUE),
                'parent_id'         => $this->input->post('categories_combobox'),
                'meta_title'        => $this->input->post('meta_title', TRUE),
                'meta_keywords'     => $this->input->post('meta_keywords', TRUE),
                'meta_description'  => $this->input->post('meta_description', TRUE),
                'lang'              => $this->input->post('lang', TRUE)

            );
            $this->news_categories_model->update_category($data);

            redirect('/dashboard/news/categories/' . $this->phpsession->get('news_cat_lang'));
        }
        return FALSE;

    }


    public function delete_cat()
    {
        if($this->is_postback())
        {
            $cat_id = $this->input->post('cat_id');
            $categories = $this->news_categories_model->get_categories(array('parent_id' => $cat_id));
            if(count($categories) == 0)
            {
                $this->news_categories_model->delete_category($cat_id);
                redirect('/dashboard/news/categories/' . $this->phpsession->get('news_cat_lang'));
            }
            else
            {
                $options['error'] = 'Không thể xóa danh mục này vì vẫn còn các danh mục con';
                $options['lang']  = $this->_lang;
            }
        }
        return $this->list_cat($options);
    }
    
    function get_categories_by_lang()
    {
        $lang = $this->input->post('lang', TRUE);
        if(!$this->input->post('is_add_edit'))
            echo $this->news_categories_model->get_categories_combo(array('lang' => $lang));
        else
            echo $this->news_categories_model->get_categories_combo(array('lang' => $lang, 'is_add_edit_cat' => TRUE));
    }

}

