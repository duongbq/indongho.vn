<?php
class Albums_Images_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_image($data = array())
    {
        $images = $this->get_images(array('album_id' => $data['album_id'], 'last_row' => TRUE));
        $data['position'] = (isset($images->position)) ? $images->position + 1 : 1;   // Chưa tồn tại ảnh trong product thì gán ảnh mới = 1
        $this->db->insert('album_images', $data);

        if ($this->db->affected_rows()==1)
        {
            $id = $this->db->insert_id();
            return $id;
        }

        return NULL;
    }

    private function _set_where_conditions($options = array())
    {
        // WHERE
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        if (isset($options['album_id']))
            $this->db->where('album_id', $options['album_id']);
        if (isset($options['position']))
            $this->db->where('position', $options['position']);
        if(!isset($options['is_admin']))
            $this->db->where('status', ACTIVE_ADV);
    }

    function get_images($options = array())
    {
        $this->_set_where_conditions($options);
        
        // ORDER
        if (isset($options['order']))
            $this->db->order_by($options['order']);
        else
            $this->db->order_by('position');

        // GET
        $query = $this->db->get('album_images');

        // RETURN
        if (isset($options['id']))
        {
            return $query->row(0);
        }
        if(isset($options['last_row']))
        {
            return $query->last_row();
        }
        return $query->result();
    }

    function delete_image($id = 0, $image_path = '')
    {
        $image = $this->get_images(array('id' => $id, 'is_admin' => TRUE));
        if (is_object($image))
        {

            // xoa file vat ly
            // 1. main image
            if (file_exists($image_path . $image->image_name))
                unlink($image_path . $image->image_name);
            // 2. thumbnail image
            if (file_exists($image_path . 'thumbnails/' . $image->image_name))
                unlink($image_path . 'thumbnails/' . $image->image_name);

            // xoa trong db
            $this->db->where('id', $id);
            $this->db->delete('album_images');

            $this->db->query('UPDATE album_images set position = position - 1 where album_id = ' . $image->album_id . ' AND position > ' . $image->position);
        }
        return NULL;
    }

    function delete_all_images($id = 0, $image_path = '')
    {
        $images = $this->get_images(array('album_id' => $id));

//        echo '<pre>';
//        print_r ($images);
//        echo '</pre>';die;
        // xoa file vat ly

        foreach($images as $image)
        {
            // 1. main image
            if (file_exists($image_path . $image->image_name))
            unlink($image_path . $image->image_name);
            // 2. thumbnail image
            if (file_exists($image_path . 'thumbnails/' . $image->image_name))
                unlink($image_path . 'thumbnails/' . $image->image_name);
            // 3. small image
            if (file_exists($image_path . 'smalls/' . $image->image_name))
                unlink($image_path . 'smalls/' . $image->image_name);
        }

        // xoa trong db
        $this->db->where('album_id', $id);
        $this->db->delete('album_images');
    }
    

    public function upload_image($album_id = 0, $image_path = '')
    {
        $this->load->library('image_lib');
        $targetFolder = '/images/uploads'; // Relative to the root
        if (!empty($_FILES)) 
        {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];

            // Validate the file type
            $fileTypes = array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array($fileParts['extension'],$fileTypes)) 
            {
                move_uploaded_file($tempFile,$targetFile);

                $size = array();
                $size = getimagesize($targetFile);

                $data_upload = array('image_width' => $size[0], 'image_height' => $size[1]);

                $config['image_library'] = 'gd2';
                $config['source_image'] = './images/uploads/' . $_FILES['Filedata']['name'];
                $config['maintain_ratio'] = TRUE;

                $image_file_name        = $product_id . dechex((int)date('His'));
                $image_file_name        .= '.' . $fileParts['extension'];
                // 1. Create the main image
                // setup the appropriate width & height
                $config['new_image'] = $image_path . $image_file_name;
                $this->image_lib->initialize($config);

                $this->image_lib->resize();

                $this->image_lib->clear();

                // 2. Create the thumbnail image
                $config['width'] = SERVICE_ADV_THUMBNAILS_WIDTH;
                $config['height'] = SERVICE_ADV_THUMBNAILS_HEIGHT;
                $config['new_image'] = $image_path . 'thumbnails/' . $image_file_name;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                if (file_exists('./images/uploads/' . $_FILES['Filedata']['name']))
                        unlink('./images/uploads/' . $_FILES['Filedata']['name']);

                // Save to database
                $data = array(
                    'album_id'  => $album_id,
                    'image_name' => $image_file_name,
                    'title'     => 'Title',
                    'status'    => ACTIVE_ADV
                );
                $this->add_image($data);
                sleep(1);
            }
            else 
            {
                    echo 'Invalid file type.';
            }
        }
    }
    
    function update_link($link = '', $id = 0)
    {
        $this->db->where('id', $id);
        $this->db->update('album_images', array('url_path' => $link));
    }

    function update_title($title = '', $id = 0)
    {
        $this->db->where('id', $id);
        $this->db->update('album_images', array('title' => $title));
    }

    public function change_status($id = 0, $status = 0)
    {
        $this->db->update('album_images', array('status' => $status ), array('id' => $id));
    }
    
}
?>