<?php
class Menus extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function get_main_menus($options = array())
    {
        $menus = get_cache('menus');
//        $options['menus']       = $this->menus_model->get_menus($options);
        $options['menus']       = $menus;
        $options['parent_id']   = FRONT_END_MENU;
        $top_menus              = '<ul class="menus">';
        $top_menus              .= $this->_visit_main_menus($options);
        $top_menus              .= '</ul>';
        $top_menus              = str_replace('<ul class="sub_menus"></ul>', '', $top_menus);
        return $top_menus;
    }

    private function _visit_main_menus($params = array())
    {
        $output                 = '';
        $sub_menus              = $this->_get_sub_menus($params);
        foreach($sub_menus as $menu)
        {
            $params['parent_id']    = $menu['id'];
            $style                  = ($menu['url_path']===$params['current_menu']) ? ' class="active"' : '';
            $output                 .= '<li' . $style . '><a href="' . $menu['url_path'] . '">' . $menu['caption'] . '</a>';
            if(!isset($params['bottom_menus']))
            {
            $output                 .= '<ul class="sub_menus">';
            $output                 .= $this->_visit_main_menus($params);
            $output                 .= '</ul></li>';
            }
         else 
            {
                $output                 .= '</li>';
            }
        }
        return $output;
    }

    private function _get_sub_menus($params = array())
    {
        $menus      = $params['menus'];
        $sub_menus  = array();
        foreach($menus as $index => $menu)
        {
            if ($menu['parent_id'] == $params['parent_id'])
                $sub_menus[$index] = $menu;
        }
        return $sub_menus;
    }
    
    private function _get_sub_menus_admin($params = array())
    {
        $menus      = $params['menus'];
        $sub_menus  = array();

        foreach($menus as $index => $menu)
        {
            if ($menu->parent_id == $params['parent_id'])
                $sub_menus[$index] = $menu;
        }
        return $sub_menus;
    }

    function get_dashboard_menus($options = array())
    {
        $options['css']         = 'menu';
        $role = $this->phpsession->get('roles_id');

        $role_param = array();
        if($role != ROLE_ADMINISTRATOR && $role != ROLE_MANAGER)
            $role_param = array('roles_id' => $role);

        $options['menus']       = $this->menus_model->get_menus($role_param);


        $options['parent_id']   = BACK_END_MENU;
        $top_menus       = '<ul id="nav">';
        $top_menus       .= $this->_visit_admin_menus($options);
        $top_menus       .= '</ul>';
        $view_data = array();
        $view_data['top_menus']   = $top_menus;
        return $this->load->view('menus/dashboard_menus', $view_data, TRUE);
    }

    /**
     * Đổi lại CSS sang thẻ A
     *
     * @param type $params
     * @return string
     */
    private function _visit_admin_menus($params = array())
    {
        $output                 = '';
        $sub_menus              = $this->_get_sub_menus_admin($params);
        foreach($sub_menus as $menu)
        {

            $params['parent_id']    = $menu->id;
            $output                 .= '<li><a href="' . $menu->url_path . '">' . $menu->caption . '</a>';
            $output                 .= '<ul>';
            $output                 .= $this->_visit_admin_menus($params);
            $output                 .= '</ul></li>';
        }
        return $output;
    }
    
    
    function get_bottom_menus($options = array())
    {
        $menus = get_cache('menus');
        $options['parent_id']       = FRONT_END_MENU;
//        $options['menus']           = $this->menus_model->get_menus($options);
        $options['menus']           = $menus;
        $options['bottom_menus']    = TRUE;
        $bottom_menus               = '<ul>';
        $bottom_menus              .= $this->_visit_main_menus($options);
        $bottom_menus              .= '</ul>';
        return $bottom_menus;
        
    }
    
    function get_menu_data($options = array())
    {
        $options['lang'] = switch_language($this->uri->segment(1));
        $menu = $this->menus_model->get_menus($options);
        return $menu;
    }
}
?>