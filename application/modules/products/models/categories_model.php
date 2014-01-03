<?php
class Categories_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_last_message()
    {
        return $this->_last_message;
    }

    /**
     * @author Tuấn Anh
     * @param type $options
     */
    private function _set_where_conditions($options = array())
    {
        // return the only one menu if id is specified
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        // get all child categories if specified
        if (isset($options['parent_id']))
            $this->db->where('parent_id', $options['parent_id']);
        
        if (isset($options['lang']))
            $this->db->where('categories.lang', $options['lang']);
    }

    /**
     * @author Tuấn Anh
     * @param array $options
     * @return <type>
     */
    function get_categories($options = array())
    {
        $this->_set_where_conditions($options);
        // order by position
        $this->db->order_by('parent_id, position');
        // get the result
        $query = $this->db->get('categories');
        // return the categories records
        if(isset ($options['last_row']))
            return $query->last_row();
        return $query->result();
    }

    function get_categories_array($options = array())
    {
        $output = array();
        $categories = $this->get_categories($options);
        foreach($categories as $category)
        {
            $output[$category->id] = $category->category;
        }
        return $output;
    }
    /**
     * Phương thức này thực hiện việc duyệt qua toàn bộ cây phân loại sản phẩm
     * và trả lại 01 mảng các danh mục sản phẩm theo thứ tự từ:
     *      + Danh mục cha
     *          - Danh mục con 1
     *          - Danh mục con 2
     * @param type $options
     */
    function get_categories_array_by_parent_id($options = array())
    {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id'])) return null;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_categories(array('lang' => $options['lang']));

        // Duyệt qua mảng và trả lại danh mục có thứ tự Danh mục cha > Danh mục con...
        $ordered_categories = array();
        $ordered_categories = $this->_visit($categories, $options['parent_id'], '');
        return $ordered_categories;
    }

    /**
     * Duyệt qua toàn bộ cây danh mục sản phẩm để tạo thành một mảng đã được sắp xếp.
     *
     * @author Tuấn Anh
     * @date   2011-05-02
     * @param type $categories
     * @param type $parent_id
     * @param string $prefix
     * @return type
     */
    private function _visit($categories = array(), $parent_id = null, $prefix = '')
    {
        $output         = array();

        $current_cat    = $this->_get_current_category($categories, $parent_id);
        $sub_cats       = $this->_get_sub_categories($categories, $parent_id);

        // Thăm nút hiện tại
        if (is_object($current_cat))
        {
//            if($parent_id == 1)
                $output[$parent_id] = $prefix . $current_cat->category;
                $prefix             .= ' » ';

        }
        // Thăm tất cả các nút con
        foreach($sub_cats as $cat)
        {
            $o = $this->_visit($categories, $cat->id, $prefix);
            foreach($o as $i => $a)
            {
                    $output[$i]     = $a;
            }
        }
        return $output;
    }

    /**
     * Lấy ra danh mục sản phẩm hiện tại
     *
     * @author Tuấn Anh
     * @date   2011-05-02
     * @param type $categories
     * @param type $parent_id
     * @return type
     */
    private function _get_current_category($categories = array(), $parent_id = null)
    {
        foreach($categories as $cat)
        {
            if ($cat->id == $parent_id) return $cat;
        }
        return FALSE;
    }

    /**
     * Lấy ra các danh mục sản phẩm con của danh mục sản phẩm hiện tại
     *
     * @author Tuấn Anh
     * @date   2011-05-02
     * @param type $categories
     * @param type $parent_id
     * @return type
     */
    private function _get_sub_categories($categories = array(), $parent_id = null)
    {
        $sub_categories = array();
        foreach($categories as $index => $cat)
        {
            if ($cat->parent_id == $parent_id)
                $sub_categories[$index] = $cat;
        }
        return $sub_categories;
    }

    /**
     * Trả lại một combobox các danh mục sản phẩm
     *
     * @author Tuấn Anh
     * @date   2011-05-02
     * @param type $options
     * @return type
     */
    public function get_categories_combo($options = array())
    {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id'])) $options['parent_id'] = ROOT_CATEGORY_ID;

        // Default categories name
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'categories';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        if (isset($options['ALL']))
            $categories[DEFAULT_COMBO_VALUE] = 'Tất cả';
        else
            $categories[DEFAULT_COMBO_VALUE] = ' -- Chọn danh mục';
        $cats = array();
        $cats = $this->get_categories_array_by_parent_id($options);
        foreach($cats as $id => $cat)
        {
            $categories[$id] = $cat;
        }
        if (!isset($options[$options['combo_name']])) $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;

        return form_dropdown($options['combo_name'], $categories, $options[$options['combo_name']], $options['extra']);
    }

    function get_categories_array_follow_parent_id($options = array())
    {
        if (!isset($options['parent_id'])) return null;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_categories(array('lang' => $options['lang']));

        
        // Duyệt qua mảng và trả lại danh mục có thứ tự Danh mục cha > Danh mục con...
        $ordered_categories = array();
        $ordered_categories = $this->_visit_all_child($categories, $options['parent_id'], '');
        $output = array();
        foreach($ordered_categories as $value)
        {
            if($value->parent_id == 0)
            {
                $output[$value->id][] = $value->id;
                $b = $value->id;
            }
            else
            {
                if(isset($b))
                    $output[$b][] = $value->id;
                else
                    $output[0][] = $value->id;
            }
        }
        return $output;
    }
    
    private function _visit_all_child($categories = array(), $parent_id = null, $prefix = '')
    {
        $output         = array();

        $current_cat    = $this->_get_current_category($categories, $parent_id);
        $sub_cats       = $this->_get_sub_categories($categories, $parent_id);

        // Thăm nút hiện tại
        if (is_object($current_cat))
        {
                $output[$parent_id] = $current_cat;

        }
        // Thăm tất cả các nút con
        foreach($sub_cats as $cat)
        {
            $o = $this->_visit_all_child($categories, $cat->id, $prefix);
            foreach($o as $i => $a)
            {
                    $output[$i]     = $a;
            }
        }
        return $output;
    }
    
    public function add_category($data = array())
    {
        $this->db->insert('categories', $data);
    }

    public function update_categories($data = array())
    {
        if(isset ($data['id']))
            $this->db->update('categories', $data, array('id' => $data['id']));
    }

    public function delete_categories($cat_id)
    {
        $this->db->delete('categories', array('id' => $cat_id));
    }
}
?>