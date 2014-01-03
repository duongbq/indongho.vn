<?php
class Pages_Model extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }

    public function get_pages($options = array())
    {
        
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        if (isset($options['uri']))
            $this->db->where('uri', $options['uri']);

        // Tim kiem
        if (isset($options['search']))
        {
            $where  = "(title like'%" . $options['search'] . "%'";
            $where .= " or content like'%" . $options['search'] . "%')";
            $this->db->where($where);
        }
        if(isset($options['lang']) && !empty($options['lang'])){
            $this->db->where("uri REGEXP '^(([/]".$options['lang']."[/])|(".$options['lang']."[/]))'");
        }
        if(!isset($options['is_admin']))
            $this->db->where('status', ACTIVE_PAGE);
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $this->db->order_by('created_date desc');

        $query = $this->db->get('pages');

        if (isset($options['id']) || isset($options['uri']))
            return $query->row(0);
        if(isset($options['array']))
            return $query->result_array();
        return $query->result();
    }

    public function get_pages_count($options = array())
    {
        return count($this->get_pages($options));
    }

    function add_page($post_data = array())
    {
        $this->db->insert('pages', $post_data);
    }

    function update_page($post_data = array())
    {
        $this->db->where('id', $post_data['id']);
        $this->db->update('pages', $post_data);
    }

    function delete_page($id = 0)
    {
        $this->db->where('id', $id);
        $this->db->delete('pages');
    }

    public function change_status($id = 0, $status = 0)
    {
        $this->db->update('pages', array('status' => $status ), array('id' => $id));
    }
}
?>