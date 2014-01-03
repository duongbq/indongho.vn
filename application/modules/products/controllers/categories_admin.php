<?php
class Categories_Admin extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if(!modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE))) redirect('/');
        if(!$this->phpsession->get("product_cat_lang")) $this->phpsession->save('product_cat_lang', 'vi');
    }

    function dispatcher($method='dashboard', $para1=NULL, $para2=NULL)
    {
        $layout             = 'duongbq/admin_layout';
        $current_url        = '/dashboard/products';
        $lang               = switch_language($para1);
        switch ($method)
        {
            //CATEGORIES
            case 'list_categories':
                $main_content           = $this->list_categories(array('lang' => $lang));
                $this->phpsession->save('product_cat_lang', $lang);
                break;
            case 'add_categories':
                $main_content           = $this->add_categories();
                break;
            case 'edit_categories':
                $main_content           = $this->edit_categories();
                break;
            case 'delete_categories':
                $main_content           = $this->delete_categories();
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

    /*
     * @author duongbq
     * @date 23-7-2011
     */
    function list_categories($options = array())
    {
//        $view_data                  = array();
//        $view_data['categories']    = $this->categories_model->get_categories_array_by_parent_id(array('parent_id' => ROOT_CATEGORY_ID, 'lang' => $options['lang']));
        
        $options['categories']          = $this->categories_model->get_categories($options);
        $options['parent_id']           = ROOT_CATEGORY_ID;
        $list_categories                = '<ul>';
        $list_categories                .= $this->_visit($options);
        $list_categories                .= '</ul>';
        $view_data = array();
        $view_data['list_categories']   = $list_categories;
        if (isset($options['error'])) $view_data['options']   = $options;
        $view_data['lang_combobox']     = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();"'));
        //heading
        $this->_title       = 'Quản lý danh mục' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/categories/list_categories', $view_data, TRUE);
    }
    
    private function _visit($params = array())
    {
        $output                 = '';
        $sub_cats               = $this->_get_sub_cats($params);
        foreach($sub_cats as $cat)
        {
//            if ($cat->id == $params['cat_id']) $selected = ' selected'; else $selected = '';
            $a =  'href="javascript:void(0);" onclick="show_child(' . $cat->id . ');"';
            $output             .= '<li id="id_' . $cat->id . '">

                                    <a ' . $a . '>' . $cat->category . '</a>
                                    <div style="float:right;" >
                                    <a class="edit" href="javascript:void(0);" onclick="submit_cat(' . $cat->id . ', \'edit\');" title="Sửa danh mục này"/><em>&nbsp;</em></a>
                                    <a class="del" href="javascript:void(0);" onclick="submit_cat(' . $cat->id . ', \'delete\');" title="Sửa danh mục này"/><em>&nbsp;</em></a>
                                    </div>';
            $params['parent_id']= $cat->id;
            $output             .= '<ul style="display:none;" id="list_item_' . $cat->id . '">';
            $output             .= $this->_visit($params);
            $output             .= '</ul></li>';
        }

        return $output;
    }

    private function _get_sub_cats($params = array())
    {
        $cats      = $params['categories'];
        $sub_cats  = array();

        foreach($cats as $index => $menu)
        {
            if ($menu->parent_id == $params['parent_id'])
                $sub_cats[$index] = $menu;
        }
        return $sub_cats;
    }

    /*
     * @author duongbq
     * @date 25-7-2011
     */
    function add_categories()
    {
        $options = array();
        // khi submit
        if($this->is_postback())
        {
            if(!$this->_do_add_categories($options))
                $options['error'] = validation_errors();
        }
        $view_data = array();
        $view_data = $this->_get_form_add_categories($options);
        if (isset($options['error'])) $view_data['options']   = $options;
        $view_data['submit_uri']    = '/dashboard/products/categories/add';
        $view_data['button_name']   = 'Thêm loại danh mục';


        //heading
        $this->_title       = 'Thêm danh mục' . DEFAULT_TITLE_SUFFIX;
        $this->_keywords    = $this->_title . ' ' . $this->_keywords;
        $content            = $this->_description;
        $this->_description = my_trim(remove_new_line($content));

        return $this->load->view('admin/categories/add_categories_form', $view_data, TRUE);
    }
    /*
     * @author duongbq
     * @date 25-7-2011
     */
    private function _get_form_add_categories($options = array())
    {
        $options['cat_name']            = $this->input->post('cat_name');
        $options['css']                 = $this->input->post('css');
        $options['meta_title']          = $this->input->post('meta_title');
        $options['meta_keywords']       = $this->input->post('meta_keywords');
        $options['meta_description']    = $this->input->post('meta_description');
        if($this->is_postback())
        {
            $options['lang_combobox']   = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();"'));
            $options['cat_combo']       = $this->categories_model->get_categories_combo(array(
                                                                'combo_name' => 'categories',
                                                                'ALL' => TRUE,
                                                                'categories' => $this->input->post('categories'),
                                                                'lang' => $this->input->post('lang')
                                                                ));
        }
        else
        {
            $options['lang_combobox']   = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get('product_cat_lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();"'));
            $options['cat_combo']       = $this->categories_model->get_categories_combo(array(
                                                                'combo_name' => 'categories',
                                                                'ALL' => TRUE,
                                                                'categories' => $this->input->post('categories'),
                                                                'lang' => $this->phpsession->get('product_cat_lang')
                                                                ));
        }
        return $options;
    }

    /*
     * @author duongbq
     * @date 25-7-2011
     */

    private function _do_add_categories($options = array())
    {
        //validate
        $this->form_validation->set_rules('cat_name', 'Tên danh mục', 'trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $data = array(
                'category'         => strip_tags($this->input->post('cat_name')),
                'css'              => $this->input->post('css'),
                'parent_id'        => $this->input->post('categories') == DEFAULT_COMBO_VALUE ? 0 : $this->input->post('categories'),
                'meta_title'       => $this->input->post('meta_title', TRUE),
                'meta_keywords'    => $this->input->post('meta_keywords', TRUE),
                'meta_description' => $this->input->post('meta_description', TRUE),
                'lang'             => $this->input->post('lang')
            );
            if($this->input->post('categories') == DEFAULT_COMBO_VALUE)
            {
               $categories = $this->categories_model->get_categories(array('parent_id' => ROOT_CATEGORY_ID,
                                                                           'last_row' => TRUE));
            }
            else
                $categories = $this->categories_model->get_categories(array('parent_id' => $this->input->post('categories'),
                                                                            'last_row' => TRUE));
            $data['position'] = is_object($categories) ? $categories->position + 1 : 1;
            $this->categories_model->add_category($data);
            redirect('/dashboard/products/categories/'  . $this->phpsession->get('product_cat_lang'));
        }
        return FALSE;
    }

    /*
     * @author duongbq
     * @date 25-7-2011
     */
    function edit_categories($options = array())
    {
        $options    = array();

        if ($this->is_postback() && !$this->input->post('IS_FROM_LIST'))
        {
            if (!$this->_do_edit_categories($options))
                $options['error'] = validation_errors();
        }
        $view_data  = array();
        $view_data  = $this->_get_form_edit_categories($options);
        if (isset($options['error'])) $view_data['options']   = $options;
        $view_data['submit_uri']    = '/dashboard/products/categories/edit';
        $view_data['button_name']   = 'Sửa danh mục';

        //heading
        $this->_title       = 'Sửa danh mục' . DEFAULT_TITLE_SUFFIX;
        $this->_keywords    = $this->_title . ' ' . $this->_keywords;
        $content            = $this->_description;
        $this->_description = my_trim(remove_new_line($content));

        return $this->load->view('admin/categories/add_categories_form', $view_data, TRUE);
    }

    /*
     * @author duongbq
     * @date 25-7-2011
     */
    private function _get_form_edit_categories($options = array())
    {
        $cat_id = $this->input->post('cat_id');
        $categories = $this->categories_model->get_categories(array('id' => $cat_id));
        if($this->input->post('IS_FROM_LIST'))
        {
            $category           = $categories[0]->category;
            $css                = $categories[0]->css;
            $parent_id          = $categories[0]->parent_id;
            $meta_title         = $categories[0]->meta_title;
            $meta_keywords      = $categories[0]->meta_keywords;
            $meta_description   = $categories[0]->meta_description;
            $lang               = $categories[0]->lang;
        }
        else
        {            
            $category           = $this->input->post('cat_name');
            $css                = $this->input->post('css');
            $parent_id          = $this->input->post('categories');
            $meta_title         = $this->input->post('meta_title', TRUE);
            $meta_keywords      = $this->input->post('meta_keywords', TRUE);
            $meta_description   = $this->input->post('meta_description', TRUE);
            $lang               = $this->input->post('lang');
        }
        $view_data = array();

        $view_data['cat_id']            = $cat_id;
        $view_data['css']               = $css;
        $view_data['cat_name']          = $category;
        $view_data['lang_combobox']       = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'onchange="javascript:get_categories_by_lang();"'));
        $view_data['cat_combo']         = $options['cat_combo']   = $this->categories_model->get_categories_combo(array(
                                                            'combo_name' => 'categories',
                                                            'ALL' => TRUE,
                                                            'categories' => $parent_id,
                                                            'lang' => $lang
                                                            ));
        $view_data['meta_title']        = $meta_title;
        $view_data['meta_keywords']     = $meta_keywords;
        $view_data['meta_description']  = $meta_description;
        $view_data['parent_id']         = $parent_id;
        return $view_data;
    }

    /*
     * @author duongbq
     * @date 25-7-2011
     */
    private function _do_edit_categories($options = array())
    {
        //validate
        $this->form_validation->set_rules('cat_name', 'Tên danh mục', 'trim|required|xss_clean');
        if($this->form_validation->run())
        {
            $data = array(
                'id'        => $this->input->post('cat_id'),
                'css'       => $this->input->post('css'),
                'category'  => strip_tags($this->input->post('cat_name')),
                'parent_id' => $this->input->post('categories') == DEFAULT_COMBO_VALUE ? 0 : $this->input->post('categories'),
                'meta_title' => $this->input->post('meta_title', TRUE),
                'meta_keywords' => $this->input->post('meta_keywords', TRUE),
                'meta_description' => $this->input->post('meta_description', TRUE),
                'lang'              => $this->input->post('lang')

            );
            
            // trường hợp chuyển lên tất cả
            if($this->input->post('categories') == DEFAULT_COMBO_VALUE)
            {
                    if($data['parent_id'] != $this->input->post('parent_id'))
                    {
                        $categories = $this->categories_model->get_categories(array('parent_id' => ROOT_CATEGORY_ID,
                                                                                    'lang' => $data['lang'],
                                                                                    'last_row' => TRUE));
                        $data['position'] = is_object($categories) ? $categories->position + 1 : 1;
                    }
            }
            else
            {
                if($data['parent_id'] != $this->input->post('parent_id'))
                {
                    $categories = $this->categories_model->get_categories(array('parent_id' => $this->input->post('categories'),
                                                                                'lang' => $data['lang'],
                                                                                'last_row' => TRUE));
                    if(is_object($categories))
                    {
                        $data['position'] = $categories->position + 1;
                    }
                    else
                    {
                        $categories = $this->categories_model->get_categories(array('id' => $this->input->post('categories'),
                                                                                    'lang' => $data['lang'],
                                                                                    'last_row' => TRUE));   
                        $data['position'] = 1;
                    }
                }
            }

            $this->categories_model->update_categories($data);
            redirect('/dashboard/products/categories/' . $this->phpsession->get('product_cat_lang'));
        }
    }

    /*
     * @author duongbq
     * @date 25-7-2011
     */
    public function delete_categories($options = array())
    {
        if($this->is_postback())
        {
            $cat_id = $this->input->post('cat_id');
            $categories = $this->categories_model->get_categories(array('parent_id' => $cat_id));
            if(count($categories) == 0)
            {
                $this->categories_model->delete_categories($cat_id);
                redirect('/dashboard/products/categories/' . $this->phpsession->get('product_cat_lang'));
            }
            else
            {
                $options['error'] = 'Không thể xóa danh mục này vì vẫn còn các danh mục con';
                $options['lang']  = $this->_lang;
            }
        }
        return $this->list_categories($options);

    }
    
    function get_products_categories_by_lang()
    {
        $lang = $this->input->post('lang', TRUE);
        if(!$this->input->post('is_add_edit'))
            echo $this->categories_model->get_categories_combo(array('lang' => $lang));
        else
            echo $this->categories_model->get_categories_combo(array('lang' => $lang, 'ALL' => TRUE));
    }
    
    public function sort_categories()
    {
        $arr = $this->input->post('id');
        $category = $this->categories_model->get_categories(array('id' => $arr[0]));
        $i = 1;
        foreach ($arr as $recordidval)
        {
            $array = array('position' => $i);
            $this->db->where('id', $recordidval);
            $this->db->where('parent_id', $category[0]->parent_id);
            $this->db->update('categories', $array);
            $i = $i + 1;
        }
    }
}
?>
