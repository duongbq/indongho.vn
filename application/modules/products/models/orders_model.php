<?php
class Orders_Model extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }

    function add_order($data = array())
    {
        $this->db->insert('orders',$data);
        return $this->db->insert_id();
    }
    
    function add_order_details($data = array())
    {
        $this->db->insert('orders_details',$data);
    }

    function get_orders_details($options = array())
    {

        if(isset($options['order_id']))
            $this->db->where('order_id', $options['order_id']);
        $this->db->select(
                'orders_details.*,
                 products.product_name
                '
                );
        $this->db->join('orders', 'orders_details.order_id = orders.id');
        $this->db->join('products', 'orders_details.product_id = products.id');
        $query = $this->db->get('orders_details');
        return $query->result();
    }

    function get_orders($options = array())
    {
        if(isset($options['order_id']))
            $this->db->where('id', $options['order_id']);
        if(isset($options['user_id']))
            $this->db->where('user_id', $options['user_id']);

        if(isset($options['year']) && $options['year'] != DEFAULT_COMBO_VALUE)
            $this->db->where('year(sale_date)', $options['year']);

        if(isset($options['month']) && $options['month'] != DEFAULT_COMBO_VALUE)
            $this->db->where('month(sale_date)', $options['month']);

        if(isset($options['day']) && $options['day'] != DEFAULT_COMBO_VALUE)
            $this->db->where('day(sale_date)', $options['day']);
        
        if (isset($options['keyword']) && $options['keyword'] != '')
        {
            $this->db->like('receiver', $options['keyword']);
        }

        if(isset($options['status']) && $options['status']!= '' && $options['status'] != DEFAULT_COMBO_VALUE)
            $this->db->where('order_status', $options['status']);

        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);


        $query = $this->db->get('orders');
        if(isset($options['order_id']))
            return $query->row(0);
        return $query->result();
    }

    public function get_orders_count($options = array())
    {
        return count($this->get_orders($options));
    }

    function update_order($data = array())
    {
        $this->db->where('id', $data['id']);
        $this->db->update('orders', $data);
    }

    function delete_order($id = 0)
    {
        $this->db->delete('orders_details', array('order_id' => $id));
        $this->db->delete('orders', array('id' => $id));
    }
}
?>
