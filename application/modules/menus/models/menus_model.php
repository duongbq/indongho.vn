<?php
class Menus_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @author Tuấn Anh
     * @param type $options 
     */
    private function _set_where_conditions($options = array(), $all = FALSE)
    {
        // joining with role table to get the appropriate menu items
        //TODO: thêm phần lấy menu cho admin & manager
//        $this->db->join('roles_menus', 'roles_menus.menus_id=menus.id', 'left');
//        if ( !isset($options['roles_id'])) $options['roles_id'] = -1;
//        $this->db->where('roles_id', $options['roles_id']);
        
        // only get the active menu items
        if ( ! $all ) { $this->db->where('menus.active', 1);}
        // get all child menus if specified
        if (isset($options['parent_id']))
            $this->db->where('menus.parent_id', $options['parent_id']);
        if(isset($options['footer_menu']))
        {
            $this->db->where('(menus.id in(' . $options['footer_menu'] . ') OR menus.parent_id in(' . $options['footer_menu'] . '))' );
        }
        if( isset($options['lang']) && $options['lang'] != '')
            $this->db->where('menus.lang', $options['lang']);
        // return the only one menu if id is specified
        if (isset($options['id']))
            $this->db->where('menus.id', $options['id']);
        if (isset($options['roles_id']))
            $this->db->where('roles_menus.roles_id', $options['roles_id']);
    }


    /**
     * This method only get menu which belong to the logged in role
     * @author Tuấn Anh
     * @param array $options
     * @return <type>
     */
    function get_menus($options = array(), $all = FALSE)
    {
        $this->db->select('menus.id
                            , caption
                            , url_path
                            , parent_id
                            , position
                            , css
                            , active
                            , lang
                        ');
        $this->_set_where_conditions($options, $all);
        // order by position
        if(isset($options['roles_id']))
            $this->db->join('roles_menus', 'roles_menus.menus_id = menus.id', 'INNER');
        
        $this->db->order_by('parent_id asc, position asc');
        // get the result
        $query = $this->db->get('menus');
        // return the menus records
        if(isset($options['last_row']))
            return $query->last_row();
        if(isset($options['array']))
            return $query->result_array();
        return $query->result();
    }


    function get_menus_array_by_parent_id1($options = array())
    {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id'])) return null;

        // Lấy ra tất cả các danh mục
        $menus = $this->get_menus();

        // Duyệt qua mảng và trả lại danh mục có thứ tự Danh mục cha > Danh mục con...
        $ordered_menus = array();
        $ordered_menus = $this->_visit1($menus, $options['parent_id'], '');
        return $ordered_menus;
    }
    
    function get_menus_array_by_parent_id($options = array())
    {
        $cond = array();
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id'])) return null;
        if (isset($options['lang']));
            $cond['lang'] = $options['lang'];
        // Lấy ra tất cả các danh mục
        $menus = $this->get_menus($cond);

        // Duyệt qua mảng và trả lại danh mục có thứ tự Danh mục cha > Danh mục con...
        $ordered_menus = array();
        $ordered_menus = $this->_visit($menus, $options['parent_id'], '');
        return $ordered_menus;
    }

    
    private function _visit1($menus = array(), $parent_id = null, $prefix = '')
    {
        $output         = array();

        $current_menu    = $this->_get_current_menus($menus, $parent_id);
        $sub_menus       = $this->_get_sub_menus($menus, $parent_id);

        // Thăm nút hiện tại
        if (is_object($current_menu))
        {
//            if($parent_id == 1)
                $output[$parent_id] = $current_menu;
                $prefix             .= ' » ';

        }
        // Thăm tất cả các nút con
        foreach($sub_menus as $menu)
        {
            $o = $this->_visit1($menus, $menu->id, $prefix);
            foreach($o as $i => $a)
            {
                    $output[$i]     = $a;
            }
        }
        return $output;
    }
    
    private function _visit($menus = array(), $parent_id = null, $prefix = '')
    {
        $output         = array();

        $current_menu    = $this->_get_current_menus($menus, $parent_id);
        $sub_menus       = $this->_get_sub_menus($menus, $parent_id);

        // Thăm nút hiện tại
        if (is_object($current_menu))
        {
//            if($parent_id == 1)
                $output[$parent_id] = $prefix . $current_menu->caption;
                $prefix             .= ' » ';

        }
        // Thăm tất cả các nút con
        foreach($sub_menus as $menu)
        {
            $o = $this->_visit($menus, $menu->id, $prefix);
            foreach($o as $i => $a)
            {
                    $output[$i]     = $a;
            }
        }
        return $output;
    }
    
    private function _get_current_menus($menus = array(), $parent_id = null)
    {
        foreach($menus as $menu)
        {
            if ($menu->id == $parent_id) return $menu;
        }
        return FALSE;
    }

    private function _get_sub_menus($menus = array(), $parent_id = null)
    {
        $sub_menus = array();
        foreach($menus as $index => $menu)
        {
            if ($menu->parent_id == $parent_id)
                $sub_menus[$index] = $menu;
        }
        return $sub_menus;
    }


    public function get_menus_combo($options = array())
    {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id'])) $options['parent_id'] = ROOT_CATEGORY_ID;

        // Default categories name
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'navigation';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        if($this->phpsession->get('menu_type') == FRONT_END_MENU)
            $menus[FRONT_END_MENU] = '-- Frontend menu';
        if($this->phpsession->get('menu_type') == BACK_END_MENU)
            $menus[BACK_END_MENU] = '-- Backend menu';
        $mnus = array();
        $mnus = $this->get_menus_array_by_parent_id($options);
        
        foreach($mnus as $id => $mn) {
            if(isset($options['current_id']) && $options['current_id'] != '') {
                
                if($id != $options['current_id'])
                    $menus[$id] = $mn;
            } else {
                $menus[$id] = $mn;
            }
        }
        if (!isset($options[$options['combo_name']])) $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;

        return form_dropdown($options['combo_name'], $menus, $options[$options['combo_name']], $options['extra']);
    }


    public function add_menu($data = array())
    {
        $this->db->insert('menus', $data);
        return $this->db->insert_id();
    }

    public function update_menu($data = array())
    {
        if(isset ($data['id']))
            $this->db->update('menus', $data, array('id' => $data['id']));
    }

    public function delete_menu($menu_id)
    {
        $this->db->delete('menus', array('id' => $menu_id));
        $this->db->delete('roles_menus', array('menus_id' => $menu_id));
    }
    
     function get_selected_menu_role( $cond = array(), $inner_html = FALSE)
    {
        $result = $this->db
                    ->select('roles.id,roles.role')
                    ->join('roles', 'roles_menus.roles_id = roles.id', 'INNER')
                    ->where($cond)
                    ->order_by('roles.id desc')
                    ->get('roles_menus');
        if($result->result() && sizeof($result->result()) > 0)
        {
            $options = FALSE;
            if($inner_html){
                foreach ($result->result() as $role) {
                    $options = '<option value="' . $role->id . '">' . $role->role . '</option>';
                }
            } else {
                foreach ($result->result() as $key => $role)
                {
                    $options[$role->id] = $role->role;
                }
            }
            return $options;
        } 
        else {
            return false;
        }
    }
    
    //@dzung.tt : 7-5-2012
    
    function update_menu_active($menu_id){
        if($menu_id){
            $result = $this->db->get_where('menus', array('id' => $menu_id));
            
            if($menu = $result->row_array())
            {    
                $active = $menu['active'] == 1 ? 0 : 1;
                $this->db->update('menus', array('active' => $active), array('id' => $menu_id));
                $this->db->update('menus', array('active' => $active), array('parent_id' => $menu_id));
                return $active;
            }
            
            return false;
        }
        return false;
    }
    
    function get_role($inner_html = FALSE)
    {
        $result = $this->db
                    ->select('roles.id,roles.role')
                    ->order_by('roles.id desc')
                    ->get('roles');
        if($result->result() && sizeof($result->result()) > 0)
        {
            $options = false;
            if($inner_html){
                foreach ($result->result() as $role) {
                    $options = '<option value="' . $role->id . '">' . $role->role . '</option>';
                }
            } else {
                foreach ($result->result() as $key => $role)
                {
                    $options[$role->id] = $role->role;
                }
            }
            return $options;
        } 
        else {
            return false;
        }
    }


    function update_menu_role($menu_id, $role_new)
    {
        if( $menu_id )
        {
            $this->db->delete('roles_menus', array('menus_id'=> $menu_id));
        }
        if(is_array($role_new))
        {
            foreach($role_new as $key => $value){
                $this->db->insert('roles_menus', array('menus_id' => $menu_id, 'roles_id' => $value));
            }
        }
    }
    
    function get_menus_array($options = array(), $all = FALSE)
    {
        $this->db->select('menus.id
                            , caption
                            , url_path
                            , parent_id
                            , position
                            , css
                            , active
                        ');
        $this->_set_where_conditions($options, $all);
        // order by position
        $this->db->order_by('parent_id asc, position asc');
        // get the result
        $query = $this->db->get('menus');
        return $query->result_array();
    }
    

}
?>