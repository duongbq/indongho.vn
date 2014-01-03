<?php
class Advertisements_Model extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }

    function get_advertisements($options = array())
    {
        if(!isset($options['is_admin']))
            $this->db->where('status', ACTIVE_ADV);
        if(isset($options['id']))
            $this->db->where('id', $options['id']);
        if(isset($options['type']))
            $this->db->where('type', $options['type']);
        if(isset($options['lang']))
            $this->db->where('lang', $options['lang']);
        $this->db->order_by('position');
        $query = $this->db->get('advs');
        if(isset($options['id']))
            return $query->row(0);
        return $query->result();
    }

    function update_link($link = '', $id = 0)
    {
        $this->db->where('id', $id);
        $this->db->update('advs', array('url_path' => $link));
    }

    function update_title($title = '', $id = 0)
    {
        $this->db->where('id', $id);
        $this->db->update('advs', array('title' => $title));
    }

    public function change_status($id = 0, $status = 0)
    {
        $this->db->update('advs', array('status' => $status ), array('id' => $id));
    }

    function delete_advertisement($id = 0)
    {
        $this->db->where('id', $id);
        $this->db->delete('advs');
    }
}
?>