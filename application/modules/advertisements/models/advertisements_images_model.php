<?php
class Advertisements_Images_Model extends CI_Model
{
    private $_last_message = '';
    public function __construct()
    {
        parent::__construct();
    }

    function get_last_message()
    {
        return $this->_last_message;
    }
    
    public function add_image($data = array())
    {
        $images = $this->get_images(array('type' => $data['type'], 'last_row' => TRUE));
        $data['position'] = (isset($images->position)) ? $images->position + 1 : 1;
        $data['title'] = 'Title';
        $this->db->insert('advs', $data);

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
        if (isset($options['position']))
            $this->db->where('position', $options['position']);
        if (isset($options['type']))
            $this->db->where('type', $options['type']);

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
        $query = $this->db->get('advs');

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
        $image = $this->get_images(array('id' => $id));
        if (is_object($image))
        {

            // xoa file vat ly
            // 1. main image
            if (file_exists($image_path . $image->image_name))
                unlink($image_path . $image->image_name);
            // 2. thumbnail image
            if (file_exists($image_path . 'thumbnails/' . $image->image_name))
                unlink($image_path . 'thumbnails/' . $image->image_name);
        }
        return NULL;
    }

    public function upload_image1($image_path = '', $adv_type = 0)
    {
        $this->load->library('image_lib');
        $targetFolder = '/images/uploads'; // Relative to the root
        if (!empty($_FILES)) 
        {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];

            // Validate the file type
            $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
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
                if($adv_type == SLIDE)
                {
                    // 1. Create the main image
                    $config['new_image'] = $image_path . $image_file_name;
                    $this->image_lib->initialize($config);

                    $this->image_lib->resize();

                    $this->image_lib->clear();

                    // 2. Create the thumbnails image
                    $config['width'] = SLIDE_ADV_THUMBNAILS_WIDTH;
                    $config['height'] = SLIDE_ADV_THUMBNAILS_HEIGHT;
                    $config['new_image'] = $image_path . 'thumbnails/' . $image_file_name;
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }
                else if($adv_type  == SERVICE)
                {
                    // 1. Create the main image
                    //
                    // setup the appropriate width & height
                    $config['width'] = SERVICE_ADV_ORIGINAL_WIDTH;
                    $config['height'] = SERVICE_ADV_ORIGINAL_HEIGHT;
                    $config['new_image'] = $image_path . $image_file_name;
                    $this->image_lib->initialize($config);

                    $this->image_lib->resize();

                    $this->image_lib->clear();

                    // 2. Create the thumbnails image
                    $config['width'] = SERVICE_ADV_THUMBNAILS_WIDTH;
                    $config['height'] = SERVICE_ADV_THUMBNAILS_HEIGHT;
                    $config['new_image'] = $image_path . 'thumbnails/' . $image_file_name;
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }

                else if($adv_type  == PARTNER)
                {
                    // 1. Create the main image
                    //
                    // setup the appropriate width & height
                    $config['width'] = PARTNER_ADV_ORIGINAL_WIDTH;
                    $config['height'] = PARTNER_ADV_ORIGINAL_HEIGHT;
                    $config['new_image'] = $image_path . $image_file_name;
                    $this->image_lib->initialize($config);

                    $this->image_lib->resize();

                    $this->image_lib->clear();

                    // 2. Create the thumbnails image
                    $config['width']     = PARTNER_ADV_THUMBNAILS_WIDTH;
                    $config['height']    = PARTNER_ADV_THUMBNAILS_HEIGHT;
                    $config['new_image'] = $image_path . 'thumbnails/' . $image_file_name;
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }

                if (file_exists('./images/uploads/' . $_FILES['Filedata']['name']))
                        unlink('./images/uploads/' . $_FILES['Filedata']['name']);

                // Save to database
                $data = array(
                    'image_name'    => $image_file_name,
                    'status'        => ACTIVE_ADV,
                    'type'          => $adv_type,
                    'lang'          => $this->phpsession->get('current_adv_lang')
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
    public function upload_image($image_path = '', $adv_type = 0)
    {
        $config['upload_path'] = './images/uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '1024';
        $config['encrypt_name'] = TRUE;
        $image_file_name        = dechex((int)date('His'));

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload() )
        {
            $error = $this->upload->display_errors();
            $this->_last_message = $error;
            return NULL;
        }
        else 
        {
            $image = $this->upload->data();

            $image_file_name .= $image['file_ext'];
            $this->load->library('image_lib');
            
              // Start processing the uploaded image
            $config['image_library'] = 'gd2';
            $config['source_image'] = './images/uploads/' . $image['file_name'];
            $config['maintain_ratio'] = TRUE;
            
            if($adv_type == SLIDE)
            {
                // 1. Create the main image
                $config['new_image'] = $image_path . $image_file_name;
                $this->image_lib->initialize($config);

                $this->image_lib->resize();

                $this->image_lib->clear();

                // 2. Create the thumbnails image
                $config['width'] = SLIDE_ADV_THUMBNAILS_WIDTH;
                $config['height'] = SLIDE_ADV_THUMBNAILS_HEIGHT;
                $config['new_image'] = $image_path . 'thumbnails/' . $image_file_name;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
            }
            else if($adv_type == PARTNER)
            {
                // 1. Create the main image
                $config['new_image'] = $image_path . $image_file_name;
                $this->image_lib->initialize($config);

                $this->image_lib->resize();

                $this->image_lib->clear();

                // 2. Create the thumbnails image
                $config['width'] = PARTNER_ADV_THUMBNAILS_WIDTH;
                $config['height'] = PARTNER_ADV_THUMBNAILS_HEIGHT;
                $config['new_image'] = $image_path . 'thumbnails/' . $image_file_name;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
            }

            if (file_exists('./images/uploads/' . $image['file_name']))
                    unlink('./images/uploads/' . $image['file_name']);

            // Save to database
            $data = array(
                'image_name'    => $image_file_name,
                'status'        => ACTIVE_ADV,
                'type'          => $adv_type,
                'lang'          => $this->phpsession->get('current_adv_lang')
            );
            $this->add_image($data);
            if($adv_type == PARTNER)
                redirect('/dashboard/advertisements/partners');
            else
                redirect('/dashboard/advertisements/slide');

        }
    }
}
?>