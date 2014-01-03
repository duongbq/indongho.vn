<?php
class Configurations_Model extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }

    function get_configuration($options = array())
    {
        $result = $this->db->get('configuration');
        if(isset($options['array']))
            return $result->row_array();
        return $result->row(0);
    }
    
    function update_configruation($data = array())
    {
        $this->db->update('configuration', $data);
    }
}
?>