<?php
class Feedbacks_Model extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }

    public function get_feedbacks($options = array())
    {
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        
        if (isset($options['lang']))
            $this->db->where('lang', $options['lang']);

        if(!isset($options['is_admin']))
            $this->db->where('status', ACTIVE_FEEDBACK);
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);
        
        if (isset($options['search']))
        {
            $where  = "(customer like'%" . $options['search'] . "%'";
            $where .= " or content like'%" . $options['search'] . "%')";
            $this->db->where($where);
        }

        $this->db->order_by('created_date desc');

        $query = $this->db->get('feedbacks');

        if (isset($options['id']) || isset($options['uri']))
            return $query->row(0);
        return $query->result();
    }

    public function get_feedbacks_count($options = array())
    {
        return count($this->get_feedbacks($options));
    }

    function add_feedback($post_data = array())
    {
        $this->db->insert('feedbacks', $post_data);
    }

    function update_feedback($post_data = array())
    {
        $this->db->where('id', $post_data['id']);
        $this->db->update('feedbacks', $post_data);
    }

    function delete_feedback($id = 0)
    {
        $this->db->where('id', $id);
        $this->db->delete('feedbacks');
    }

    public function change_status($id = 0, $status = 0)
    {
        $this->db->update('feedbacks', array('status' => $status ), array('id' => $id));
    }
}
?>