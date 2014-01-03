<?php

class Menus_Admin extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE)))
            redirect('/');
        if(!$this->phpsession->get("current_menus_lang")) $this->phpsession->save('current_menus_lang', 'vi');
    }

    function dispatcher($method = NULL, $para1 = NULL, $para2 = NULL) {
        $menu_params = array('current_menu' => '/' . $this->uri->uri_string());
        $layout = 'duongbq/admin_layout';
        $current_url = '/dashboard/menus';
        $main_content = '';

        switch ($method) {
            case 'list_menu' :
                $lang = switch_language($para1);
                $this->phpsession->save('current_menus_lang', $lang);
                $menu_params = array('parent' => FRONT_END_MENU, 'page_title' => 'Menu trang chủ', 'lang' => $lang);
                $this->phpsession->save('menu_type', FRONT_END_MENU);
                $main_content = $this->list_menu($menu_params);
                break;
            case 'list_backend_menu' :
                $lang = switch_language($para1);
                $this->phpsession->save('current_menus_lang', $lang);
                $menu_params = array('parent' => BACK_END_MENU, 'page_title' => 'Menu trang quản lý', 'lang' => $lang);
                $this->phpsession->save('menu_type', BACK_END_MENU);
                $main_content = $this->list_menu($menu_params);
                break;
            case 'add_menu' :
                $main_content = $this->add_menu();
                break;
            case 'edit_menu' :
                $main_content = $this->edit_menu();
                break;
            case 'delete_menu' :
                $menu_params = array('parent_id' => FRONT_END_MENU, 'page_title' => 'Menu trang chủ');
                $main_content = $this->delete_menu($menu_params);
                break;
        }

        $view_data = array();
        $view_data['url'] = isset($current_url) ? $current_url : '';
        $view_data['admin_menu'] = modules::run('menus/menus/get_dashboard_menus', $menu_params);
        $view_data['main_content'] = $main_content;
        // META data
        $view_data['title'] = $this->_title;

        $this->load->view($layout, $view_data);
    }

    function list_menu($options = array()) {
        $view_data = array();
        $this->output->link_js('/duongbq/scripts/menu_admin.js');
        
        $options['menus'] = $this->menus_model->get_menus($options, TRUE);
        $options['parent_id'] = $options['parent'];
        
        $list_menus = '<ul>';
        $list_menus .= $this->_visit($options);
        $list_menus .= '</ul>';
        
        $view_data['page_title'] = $options['page_title'];
        $view_data['list_menus'] = $list_menus;
        $view_data['language_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();"'));

        if($this->input->get('save_cache') == 'success')
            $options['succeed'] = 'Lưu cache thành công';
        else if($this->input->get('save_cache') == 'error')
            $options['error'] = 'Lưu cache không thành công';
        
        if (isset($options['error']) || isset($options['succeed']))
            $view_data['options'] = $options;
        //heading
        if($options['parent'] == FRONT_END_MENU)
            $view_data['back_url'] = '/dashboard/menu/';
        else
            $view_data['back_url'] = '/dashboard/menu-admin/';
        
        
        $this->_title = 'Quản lý menu' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/list_menu', $view_data, TRUE);
    }

    private function _visit($params = array()) {
        $output = '';
        $sub_menus = $this->_get_sub_menus($params);
        foreach ($sub_menus as $menu) {
            $link = 'href="javascript:void(0);" onclick="show_child(' . $menu->id . ');"';
            $output .= '<li id="id_' . $menu->id . '">

                                    <a ' . $link . '>' . $menu->caption . '</a>
                                    <div style="float:right;" >' .
                    ( $menu->active == 1 ? '<img menu_id="' . $menu->id . '" title="Active" class="active-menu" style="cursor:pointer;padding-right:5px;" src="/duongbq/images/ontime.png">' : '<img menu_id="' . $menu->id . '" title="Inactive" class="active-menu" style="cursor:pointer;padding-right:5px;" src="/duongbq/images/absent.png">'
                    ) . '
                                    <a class="edit" href="javascript:void(0);" onclick="submit_menu(' . $menu->id . ', \'edit\');" title="Sửa menu này"/><em>&nbsp;</em></a>
                                    <a class="del" href="javascript:void(0);" onclick="submit_menu(' . $menu->id . ', \'delete\');" title="Sửa menu này"/><em>&nbsp;</em></a>
                                    </div>';
            $params['parent_id'] = $menu->id;
            $output .= '<ul style="display:none;" id="list_item_' . $menu->id . '">';
            $output .= $this->_visit($params);
            $output .= '</ul></li>';
        }
        return $output;
    }

    private function _get_sub_menus($params = array()) {
        $menus = $params['menus'];
        $sub_menus = array();
        
        foreach ($menus as $index => $menu) {
            if ($menu->parent_id == $params['parent_id'])
                $sub_menus[$index] = $menu;
        }
        return $sub_menus;
    }

    function add_menu() {
        $this->output->link_js('/duongbq/scripts/role_select.js');
        $options = array();
        $options['lang'] = $this->phpsession->get('current_menus_lang') ;
        
        // khi submit
        if ($this->is_postback()) {
            if (!$this->_do_add_menu($options))
                $options['error'] = validation_errors();
        }
        $view_data = array();
        $view_data = $this->_get_form_add_menu($options);
        $view_data['role_menu'] = $this->menus_model->get_role();
        $view_data['current_role'] = array();
        if (isset($options['error']))
            $view_data['options'] = $options;
        $view_data['parent']        = $this->phpsession->get('menu_type');
        $view_data['submit_uri']    = '/dashboard/menu/add';
        $view_data['button_name']   = 'Thêm menu';

        $view_data['language'] = $this->utility_model->get_lang_combo( array(
                                                                        'combo_name' => 'language', 
                                                                        'language' => $options['lang'], 
                                                                        'extra' => 'id="language"') );
        //heading
        $this->_title = 'Thêm menu' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/add_menu_form', $view_data, TRUE);
    }

    /*
     * @author duongbq
     * @date 25-7-2011
     */

    private function _get_form_add_menu($options = array()) {
        $options['menu_name'] = $this->input->post('menu_name');
        $options['url_path'] = $this->input->post('url_path');
        $options['lang'] = $this->input->post('language') ? $this->input->post('language') :$options['lang'] ;
        $options['css'] = $this->input->post('css');
        $options['navigation_menu'] = $this->menus_model->get_menus_combo(array(
            'parent_id' => $this->phpsession->get('menu_type'),
            'combo_name' => 'navigation',
            'navigation' => $this->input->post('navigation'),
            'lang' => $options['lang']
                ));
        return $options;
    }

    /*
     * @author duongbq
     * @date 25-7-2011
     */

    private function _do_add_menu($options = array()) {
        $data = array();
        //validate
        $this->form_validation->set_rules('menu_name', 'Tên menu', 'trim|required|xss_clean');
        $this->form_validation->set_rules('url_path', 'Đường dẫn', 'trim|required|xss_clean');

        $data = array(
            'caption' => strip_tags($this->input->post('menu_name')),
            'url_path' => $this->input->post('url_path'),
            'lang' => $this->input->post('language'),
            'css' => $this->input->post('css'),
            'parent_id' => $this->input->post('navigation')
        );

        if ($this->form_validation->run()) {
            $menu = $this->menus_model->get_menus(array('parent_id' => $this->input->post('navigation'),
                'last_row' => TRUE));
            $data['position'] = is_object($menu) ? $menu->position + 1 : 1;
            $insert_id = $this->menus_model->add_menu($data);

            //@dzung.tt : Insert role (7-5-2012)
            $selected_role = $this->input->post('selected_role');
            $this->menus_model->update_menu_role($insert_id, $selected_role);

            if ($this->phpsession->get('menu_type') == FRONT_END_MENU)
                redirect('/dashboard/menu/' . $data['lang']);
            if ($this->phpsession->get('menu_type') == BACK_END_MENU)
                redirect('/dashboard/menu-admin/' . $data['lang']);
        }
        return FALSE;
    }

    /*
     * @author duongbq
     * @date 25-7-2011
     */

    function edit_menu($options = array()) {
        $this->output->link_js('/duongbq/scripts/role_select.js');
        
        $options['lang'] = $this->phpsession->get('current_menus_lang');
        
        if ($this->is_postback() && !$this->input->post('IS_FROM_LIST')) {
            if (!$this->_do_edit_menu($options))
                $options['error'] = validation_errors();
        }
        $view_data = array();
        $view_data = $this->_get_form_edit_menu($options);
        if (isset($options['error']))
            $view_data['options'] = $options;
        
        $view_data['language'] = $this->utility_model->get_lang_combo(array(
                                                                        'combo_name' => 'language', 
                                                                        'language' => $view_data['lang'],
                                                                        'extra' => 'id="language"'
                                                                       ));
        $view_data['parent']        = $this->phpsession->get('menu_type');
        
        if($this->phpsession->get('menu_type') == FRONT_END_MENU)
            $view_data['back_url'] = '/dashboard/menu/';
        else
            $view_data['back_url'] = '/dashboard/menu-admin/';
        $view_data['submit_uri'] = '/dashboard/menu/edit';
        $view_data['button_name'] = 'Sửa Menu';

        //heading
        $this->_title = 'Sửa menu' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/add_menu_form', $view_data, TRUE);
    }

    /*
     * @author duongbq
     * @date 25-7-2011
     */

    private function _get_form_edit_menu($options = array()) {
        $menu_id = $this->input->post('menu_id');
        $menu = $this->menus_model->get_menus(array( 'id' => $menu_id ));
        
        $current_role = $this->menus_model->get_selected_menu_role(array('menus_id' => $menu_id));
        $role_menu = $this->menus_model->get_role();

        if ($current_role) {
            foreach ($role_menu as $id => $role) {
                if (isset($current_role[$id]))
                    unset($role_menu[$id]);
            }
        }

        if ($this->input->post('IS_FROM_LIST')) {
            $caption    = $menu[0]->caption;
            $url_path   = $menu[0]->url_path;
            $lang       = $menu[0]->lang;
            $css        = $menu[0]->css;
            $parent_id  = $menu[0]->parent_id;
        } else {
            if ($this->input->post('submit') === 'Sửa Menu') {
                $caption        = $this->input->post('menu_name');
                $url_path       = $this->input->post('url_path');
                $lang           = $this->input->post('language');
                $css            = $this->input->post('css');
                $parent_id      = $this->input->post('navigation');
            }
        }
        $view_data = array();

        $view_data['menu_id'] = $menu_id;
        $view_data['menu_name'] = $caption;
        $view_data['css'] = $css;
        $view_data['lang'] = $lang;
        $view_data['url_path'] = $url_path;
        $view_data['role_menu'] = $role_menu;
        $view_data['current_role'] = $current_role ? $current_role : array();
        $view_data['navigation_menu'] = $this->menus_model->get_menus_combo(array(
            'combo_name' => 'navigation',
            'parent_id' => $this->phpsession->get('menu_type'),
            'navigation' => $parent_id,
            'current_id' => trim($menu_id),
            'lang' => $lang
                ));
        $view_data['parent_id'] = $parent_id;
        return $view_data;
    }

    /*
     * @author duongbq
     * @date 25-7-2011
     */

    private function _do_edit_menu($options = array()) {
        $data = array();
        //validate
        if ($this->input->post('submit') === 'Sửa Menu') {
            $this->form_validation->set_rules('menu_name', 'Tên menu', 'trim|required|xss_clean');
            $this->form_validation->set_rules('url_path', 'Đường dẫn', 'trim|required|xss_clean');

            $data = array(
                'id'        => $this->input->post('menu_id'),
                'caption'   => strip_tags($this->input->post('menu_name')),
                'url_path'  => $this->input->post('url_path'),
                'lang'      => $this->input->post('language'),
                'css'       => $this->input->post('css'),
                'parent_id' => $this->input->post('navigation')
            );

            if ($this->form_validation->run()) {

                //@dzung.tt : Update role (7-5-2012)
                $selected_role = $this->input->post('selected_role');
                $this->menus_model->update_menu_role($data['id'], $selected_role);

                if ($this->input->post('navigation') == DEFAULT_COMBO_VALUE) {
                    if ($data['parent_id'] != $this->input->post('parent_id')) {
                        $menu = $this->menus_model->get_menus(array('parent_id' => ROOT_CATEGORY_ID,
                            'last_row' => TRUE));
                        $data['position'] = is_object($menu) ? $menu->position + 1 : 1;
                    }
                } else {
                    if ($data['parent_id'] != $this->input->post('parent_id')) {
                        $menu = $this->menus_model->get_menus(array(
                            'parent_id' => $this->input->post('navigation'),
                            'lang' => $data['lang'],
                            'last_row' => TRUE
                                ));
                        if (is_object($menu)) {
                            $data['position'] = $menu->position + 1;
                        } else {
                            $menu = $this->menus_model->get_menus(array(
                                'id' => $this->input->post('categories'),
                                'lang' => $data['lang'],
                                'last_row' => TRUE
                                    ));
                            $data['position'] = 1;
                        }
                    }
                }

                $this->menus_model->update_menu($data);

                if ($this->phpsession->get('menu_type') == FRONT_END_MENU)
                    redirect('/dashboard/menu/' . $data['lang']);
                if ($this->phpsession->get('menu_type') == BACK_END_MENU)
                    redirect('/dashboard/menu-admin/' . $data['lang']);
            }
            return FALSE;
        }
    }

    /*
     * @author duongbq
     * @date 25-7-2011
     */

    public function delete_menu($options = array()) {
        if ($this->is_postback()) {
            $menu_id = $this->input->post('menu_id');
            $menu = $this->menus_model->get_menus(array('parent_id' => $menu_id));
            
            if (count($menu) == 0) {
                $this->menus_model->delete_menu($menu_id);
                if ($this->phpsession->get('menu_type') == FRONT_END_MENU) {
                    redirect('/dashboard/menu/' . $this->phpsession->get('current_menus_lang'));
                } else if ($this->phpsession->get('menu_type') == BACK_END_MENU) {
                    redirect('/dashboard/menu-admin/' . $this->phpsession->get('current_menus_lang'));
                }
            } else {
                $options['error'] = 'Không thể xóa menu này vì vẫn còn các menu con';
                if ($this->phpsession->get('menu_type') == FRONT_END_MENU) {
                    $options['parent'] = FRONT_END_MENU;
                } else if ($this->phpsession->get('menu_type') == BACK_END_MENU) {
                    $options['parent'] = BACK_END_MENU;
                }
            }
        }
        $options['lang']    = $this->phpsession->get('current_menus_lang');
        if(isset($options['parent_id'])) unset($options['parent_id']);
        
        return $this->list_menu($options);
    }   

    public function sort_menus() {
        $arr = $this->input->post('id');
        $category = $this->menus_model->get_menus(array('id' => $arr[0]));
        $i = 1;
        foreach ($arr as $recordidval) {
            $array = array('position' => $i);
            $this->db->where('id', $recordidval)
                    ->where('parent_id', $category[0]->parent_id)
                    ->update('menus', $array);
            $i = $i + 1;
        }
    }

    /*
     * @author dzung.tt
     * @date 9-5-2012
     */

    function update_menu_active() {
        $return = '';
        if (modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE))) {
            if ($menu_id = $this->input->get('menu_id')) {
                $return = ($this->menus_model->update_menu_active($menu_id) == 1 ? 'active' : 'inactive');
            }
        }
        die($return);
    }
    
    // ajax
    function get_combo_menu(){
        if($this->is_postback() && $this->input->post('is-ajax') == 1){
            echo $this->menus_model->get_menus_combo(array(
                'combo_name' => 'navigation',
                'parent_id' => $this->input->post('parent'),
                'lang' => $this->input->post('lang'),
                'current_id' => $this->input->post('current_id')
            ));
            die;
        }
    }
    
    function save_cache_menu()
    {
        if(save_cache('menus'))
            redirect('/dashboard/menu?save_cache=success');
        else
            redirect('/dashboard/menu?save_cache=error');
    }
}

?>