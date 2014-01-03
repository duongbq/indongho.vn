<?php
class News_Categories_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_categories($options = array())
    {
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        
        // lọc ngôn ngữ
        if(isset($options['lang']))
            $this->db->where('news_categories.lang', $options['lang']);
        
        if (isset($options['parent_id']) && $options['parent_id'] != DEFAULT_COMBO_VALUE)
            $this->db->where('parent_id', $options['parent_id']);
        if (isset($options['keyword']))
            $this->db->like('category', $options['keyword']);
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $this->db->order_by('parent_id, position');

        $query = $this->db->get('news_categories');

        if (isset($options['id'])) return $query->row(0);
        if(isset ($options['last_row']))
            return $query->last_row();
        return $query->result();
    }

    public function get_categories_count($options = array())
    {
        return count($this->get_categories($options));
    }

    function get_categories_array_by_parent_id($options = array())
    {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id'])) return null;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_categories(array('lang' => $options['lang']));
        $ordered_categories = array();
        $ordered_categories = $this->_visit($categories, $options['parent_id']);
//        print_r($ordered_categories);die;
        return $ordered_categories;
    }
    
    public function get_categories_combo($options = array())
    {
        if (!isset($options['parent_id'])) $options['parent_id'] = 0;
        // Default categories name
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'categories_combobox';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        if(isset($options['is_add_edit_cat']))
            $categories[ROOT_CATEGORY_ID] = 'Tất cả';
        else
            $categories[DEFAULT_COMBO_VALUE] = 'Tất cả';

        $cats = $this->get_categories_array_by_parent_id($options);
        
        foreach($cats as $id => $cat)
        {
            $categories[$id] = $cat;
        }
        if (!isset($options[$options['combo_name']])) 
            $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;
        
        return form_dropdown($options['combo_name'], $categories, $options[$options['combo_name']], $options['extra']);
    }
    
    // Duyet theo chieu sau
    private function _visit($categories = array(), $parent_id = null, $prefix = '')
    {
        $output         = array();

        $current_cat    = $this->_get_current_category($categories, $parent_id);
        $sub_cats       = $this->_get_sub_categories($categories, $parent_id);

        if (is_object($current_cat))
        {
            $output[$current_cat->id] = $prefix . $current_cat->category;
            $prefix .= '-- ';
        }

        if (count($sub_cats) > 0)
        {
            foreach($sub_cats as $cat)
            {
                $o = $this->_visit($categories, $cat->id, $prefix);
                foreach($o as $i => $a)
                {
                    $output[$i] = $a;
                }
            }
        }
        return $output;
    }

    /**
     * Lấy ra danh mục sản phẩm hiện tại
     * @author duongbq
     * @date   01-07-2011
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
     * @author duongbq
     * @date   01-07-2011
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

    
    function add_category($data = array())
    {
        $this->db->insert('news_categories', $data);
        return $this->db->insert_id();
    }
    
    function update_category($data = array())
    {
        $this->db->where('id', $data['id']);
        $this->db->update('news_categories', $data);
    }
    
    function delete_category($id = 0)
    {
        $this->db->delete('news', array('cat_id' => $id));
        $this->db->delete('news_categories', array('id' => $id));
        $this->db->delete('news_categories', array('parent_id' => $id));
    }


    function get_categories_object_array_by_parent_id($options = array())
    {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id'])) return null;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_categories(array('lang' => $options['lang']));
        $ordered_categories = array();
        $ordered_categories = $this->_visit1($categories, $options['parent_id']);
//        print_r($ordered_categories);die;
        return $ordered_categories;
    }

    private function _visit1($categories = array(), $parent_id = null)
    {
        $output         = array();

        $current_cat    = $this->_get_current_category($categories, $parent_id);
        $sub_cats       = $this->_get_sub_categories($categories, $parent_id);

        if (is_object($current_cat))
        {
            $output[$current_cat->id] = $current_cat;
        }

        if (count($sub_cats) > 0)
        {
            foreach($sub_cats as $cat)
            {
                $o = $this->_visit1($categories, $cat->id);
                foreach($o as $i => $a)
                {
                    $output[$i] = $a;
                }
            }
        }
        return $output;
    }
}