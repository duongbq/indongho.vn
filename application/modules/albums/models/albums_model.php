<?php
class Albums_Model extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }

    private function _set_where_conditions($options = array())
    {
        if(isset($options['id']))
            $this->db->where('albums.id', $options['id']);
        $this->db->where('((album_images.position=1) OR ISNULL(album_images.image_name))');
    }

    function get_albums($options = array())
    {
        $this->db->select('albums.*, album_images.image_name');
        $this->db->join('album_images', 'albums.id = album_images.album_id','left');
        $this->_set_where_conditions($options);
        $this->db->order_by('position');
//        $this->db->limit(3);
        $query = $this->db->get('albums');

        if(isset($options['id']))
            return $query->row(0);
        if(isset($options['last_row']))
            return $query->last_row();

        return $query->result();
    }

    function add_album($data = array())
    {
        $this->db->insert('albums', $data);
        return $this->db->insert_id();
    }

    function update_album($data = array())
    {
        $this->db->where('id', $data['id']);
        $this->db->update('albums',$data);
    }
    function delete_album($id = 0)
    {
        $this->db->where('id', $id);
        $this->db->delete('albums');
    }
    
    function get_album_combo($options = array())
    {
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'album_id';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        $data_options                       = array();
        $data_options[DEFAULT_COMBO_VALUE]  = 'Không xác định';
        $albums = $this->get_albums($options);
        foreach($albums as $album)
        {
            $data_options[$album->id] = $album->name;
        }
        if (!isset($options[$options['combo_name']]) || $options[$options['combo_name']] == '')
        {
            $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;
        }
        return form_dropdown($options['combo_name'], $data_options, $options[$options['combo_name']], $options['extra']);
    }
}
?>