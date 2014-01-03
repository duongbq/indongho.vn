<?php
class RealSeo_Model extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }

    private function _set_where_condition($options = array())
    {
        if(isset($options['id']))
            $this->db->where('id', $options['id']);
    }
    function get_keywords($options = array())
    {
        $this->_set_where_condition($options);
        $this->db->order_by('CHAR_LENGTH(keyword)', 'desc');
        $query = $this->db->get('keywords');
        if(isset($options['id']))
            return $query->row(0);
        return $query->result();
    }
    function add_keyword($data = array())
    {
        $this->db->insert('keywords', $data);
    }
    
    function edit_keyword($data = array())
    {
        $this->db->where('id', $data['id']);
        $this->db->update('keywords', $data);
    }
    
    function delete_keyword($id=0)
    {
        $this->db->where('id', $id);
        $this->db->delete('keywords');
    }
    
    function get_array_keywords($options = array())
    {
        $output = array();
        $keywords = $this->get_keywords($options);
        foreach($keywords as $keyword)
        {
            $output[$keyword->id] = array($keyword->keyword, $keyword->link, $keyword->title);
        }
        return $output;
    }
}
?>