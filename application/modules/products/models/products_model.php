<?php
class Products_Model extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }

    /**
     * Thiết lập tất cả điều kiện tìm kiếm, lọc thông tin
     * 
     * @author Tuấn Anh
     * @date   2011-05-02
     * @param <type> $options
     */
    private function _set_where_conditions($options = array())
    {
        // return the only one menu if id is specified
        if (isset($options['id']))
            $this->db->where('products.id', $options['id']);
        
        if (isset($options['lang']))
            $this->db->where('products.lang', $options['lang']);

        if (isset($options['product_name']))
            $this->db->like('products.product_name', $options['product_name']);

        if (isset($options['users_id']))
            $this->db->where('products.users_id', $options['users_id']);
        
        if (isset($options['cat_id']) && $options['cat_id'] != DEFAULT_COMBO_VALUE && $options['cat_id'] != '')
            $this->db->where('(categories_id = ' . $options['cat_id'] . ' OR parent_id = ' . $options['cat_id'] . ')');
        
        if(isset($options['cats_id']))
        {
            $this->db->where_in('categories_id', $options['cats_id']);
        }
        
        if(isset($options['keyword']) && $options['keyword'] != '')
        {
            $where  = "(product_name like'%" . $this->db->escape_str($options['keyword']) . "%'";
            $where .= " or description like'%" . $this->db->escape_str($options['keyword']) . "%')";
            $this->db->where($where);
        }
        
        if(!isset($options['is_admin']))
        {
            $this->db->where('status', ACTIVE_PRODUCT);
            $this->db->where('((product_images.position=1) OR (product_images.image_name <> NULL))');
        }
        else
            $this->db->where('((product_images.position=1) OR ISNULL(product_images.image_name))');

        if(isset ($options['top_seller']) && $options['top_seller'] != '')
            $this->db->where('top_seller', IS_SPECIAL_PRODUCT);
        if(isset ($options['highlight']) && $options['highlight'] != '')
            $this->db->where('highlight', IS_SPECIAL_PRODUCT);
        if(isset($options['except_id']))
            $this->db->where('products_id !=', $options['except_id']);
    }
    
    /**
     * Trả lại tổng số sản phầm dựa trên các điều kiện lọc
     * 
     * @param <type> $options
     */
    function get_products_count($options = array())
    {
        $this->db->join('categories', 'products.categories_id = categories.id', 'left');
        $this->db->join('product_images', 'products.id = product_images.products_id', 'left');
        // where
        $this->_set_where_conditions($options);
        // get
        return $this->db->count_all_results('products');
    }

    /**
     * Trả lại danh sách các sản phẩm dựa trên điệu kiện lọc
     * @param <type> $options
     */
    function get_products($options = array())
    {
        // select
        $this->db->select(' products.*,
                            categories.category,
                            categories.parent_id,
                            categories.meta_title cat_meta_title,
                            categories.meta_keywords cat_meta_keywords,
                            categories.meta_description cat_meta_title,
                            product_images.id image_id,
                            product_images.image_name,
                            units.name as unit
                        ');
        //join users
        // join images
        $this->db->join('product_images', 'products.id = product_images.products_id', 'left');
        $this->db->join('units', 'products.unit_id = units.id', 'LEFT OUTER');
//        $this->db->where('((product_images.position=1) OR ISNULL(product_images.image_name))');
        // join categories
        $this->db->join('categories', 'products.categories_id = categories.id', 'left');
        // where
        $this->_set_where_conditions($options);
        // limit / offset
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);
        // order
        if (!isset($options['order']))
            $this->db->order_by('updated_date desc');
        else
            $this->db->order_by($options['order']);
        // get
        $query = $this->db->get('products');
        if(isset ($options['id']))
            return $query->row(0);
//        if(isset ($options['array']))
//            return $query->result_array();
        return $query->result();
    }
    
    /**
     * Thêm sản phẩm
     * 
     * @author Tuấn Anh
     * @date   2011-05-02
     * @param type $data 
     */    
    function add_product($data = array())
    {
        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Sửa sản phẩm
     * 
     * @author Tuấn Anh
     * @date   2011-05-02
     * @param type $data 
     */    
    function update_product($data = array())
    {
        if (isset($data['id']))
        {
            $this->db->where('id', $data['id']);
            $this->db->update('products', $data);
        }
    }
    
    /**
     * Xóa sản phẩm.
     * Trước khi thực hiện xóa sản phẩm, phải xóa các bảng liên quan
     *      + Xóa dữ liệu trong bảng products_images với product_id
     *      + Xóa dữ liệu trong bảng products_tags, products_views, like_products
     * @author Tuấn Anh
     * @date   2011-05-03
     * @param type $id 
     */
    function delete_product($id = 0)
    {
        // 1. Xóa ảnh trong bảng products_images và ảnh vật lý
        // 2. Xóa tags trong bảng products_tags
        // 3. Xóa tags trong bảng products_views
        // 4. Xóa tags trong bảng like_products
        // 5. Xóa sản phẩm trong bảng products
        $this->db->where('id', $id);
        $this->db->delete('products');
    }
    
    /**
     * Làm mới sản phẩm
     * 
     * @author Tuấn Anh
     * @date   2011-05-03
     * @param type $id
     * @param type $updated_date 
     */
    function up_product($id = 0, $updated_date = NULL)
    {
        $data = array();
        if (is_null($updated_date))
            $data['updated_date'] = date('Y-m-d H:i:s');
        else
            $data['updated_date'] = $updated_date;

        $this->db->where('id', $id);
        $this->db->update('products', $data);
    }

    /*
     * Cập nhật số lần xem khi xem chi tiết sản phẩm
     * @author duongbq
     * @date 3-8-2011
     */
    public function update_view($id = 0)
    {
        $this->db->set('viewed', 'viewed + 1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('products');
    }

    public function change_status($id = 0, $status = 0)
    {
        $this->db->update('products', array('status' => $status ), array('id' => $id));
    }
}
?>