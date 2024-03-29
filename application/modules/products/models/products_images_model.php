<?php
class Products_Images_Model extends CI_Model
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
        $images = $this->get_images(array('product_id' => $data['products_id'], 'last_row' => TRUE));
        $data['position'] = (isset($images->position)) ? $images->position + 1 : 1;   // Chưa tồn tại ảnh trong product thì gán ảnh mới = 1
        $this->db->insert('product_images', $data);

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
        if (isset($options['product_id']))
            $this->db->where('products_id', $options['product_id']);
        if (isset($options['position']))
            $this->db->where('position', $options['position']);
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
        $query = $this->db->get('product_images');

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
            // 3. small image
            if (file_exists($image_path . 'smalls/' . $image->image_name))
                unlink($image_path . 'smalls/' . $image->image_name);

            // xoa trong db
            $this->db->where('id', $id);
            $this->db->delete('product_images');

            $this->db->query('UPDATE product_images set position = position - 1 where products_id = ' . $image->products_id . ' AND position > ' . $image->position);
        }
        return NULL;
    }

    function delete_all_images($id = 0, $image_path = '')
    {
        $images = $this->get_images(array('product_id' => $id));

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
        $this->db->where('products_id', $id);
        $this->db->delete('product_images');
    }
    

    public function upload_image1($product_id = 0, $image_path = '')
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
                    // 1. Create the main image
                    // setup the appropriate width & height
                    $config['width'] = 640;
                    $config['height'] = 480;
                    if ($data_upload['image_width'] < $data_upload['image_height']) {
                        $config['width'] = 800;
                        $config['height'] = 600;
                    }
                    $config['new_image'] = $image_path . $image_file_name;
                    $this->image_lib->initialize($config);

                    $this->image_lib->resize();

                    $this->image_lib->clear();

                    // 2. Create the thumbnail image
                    $thumb_size = 130;
                    $thumb_width = 189;
                    $thumb_height = 142;
                    $config['width'] = $thumb_width;
                    $config['height'] = $thumb_height;
//                    $_width = $data_upload['image_width'];
//                    $_height= $data_upload['image_height'];
//                    if ($_width > $_height)
//                    {
//                        // wide image
//                        $config['width'] = intval(($_width / $_height) * $thumb_width);
//                        if ($config['width'] % 2 != 0)
//                        {
//                            $config['width']++;
//                        }
//                        $config['height'] = $thumb_height;
//                        $img_type = 'landscape';
//                    }
//                    else if ($_width < $_height)
//                    {
//                        // portrait image
//                        $config['width'] = $thumb_width;
//                        $config['height'] = intval(($_height / $_width) * $thumb_height);
//                        if ($config['height'] % 2 != 0)
//                        {
//                            $config['height']++;
//                        }
//                        $img_type = 'portrait';
//                    }
//                    else
//                    {
//                        // square image
//                        $config['width'] = $thumb_size;
//                        $config['height'] = $thumb_size;
//                        $img_type = 'square';
//                    }
                    $config['source_image'] = './images/uploads/' . $_FILES['Filedata']['name'];
                    $config['new_image'] = $image_path . 'thumbnails/' . $image_file_name;
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();


//                    $conf_new = array(
//                    'image_library' => 'gd2',
//                    'source_image' => $config['new_image'],
//                    'create_thumb' => FALSE,
//                    'maintain_ratio' => FALSE,
//                    'width' => $thumb_width,
//                    'height' => $thumb_height
//                    );
//
//                    if ($img_type == 'landscape')
//                    {
//                        $conf_new['x_axis'] = ($config['width'] - $thumb_width) / 2 ;
//                        $conf_new['y_axis'] = 0;
//                    }
//                    else if($img_type == 'portrait')
//                    {
//                        $conf_new['x_axis'] = 0;
//                        $conf_new['y_axis'] = 0;
//                    }
//                    else
//                    {
//                        $conf_new['x_axis'] = 0;
//                        $conf_new['y_axis'] = 0;
//                    }
//
//                    $this->image_lib->initialize($conf_new);
//
//                    if ( ! $this->image_lib->crop())
//                    {
//                        echo $this->image_lib->display_errors();
//                    }
//
//                    $this->image_lib->clear();

                    // 3. Create the small image
                    $config['width'] = 40;
                    $config['height'] = 30;
                    $config['source_image'] = $config['new_image'];
                    $config['new_image'] = $image_path . 'smalls/' . $image_file_name;
                    $this->image_lib->initialize($config);

                    $this->image_lib->resize();

                    $this->image_lib->clear();

                    if (file_exists('./images/uploads/' . $_FILES['Filedata']['name']))
                            unlink('./images/uploads/' . $_FILES['Filedata']['name']);

                    // Save to database
                    $data = array(
                        'products_id'  => $product_id,
                        'image_name' => $image_file_name
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
    public function upload_image($product_id = 0, $product_name='', $image_path = '')
    {
        $config['upload_path'] = './images/uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '1024';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        $files = array();
        foreach ($_FILES as $key => $value) 
        {
            if ($this->upload->do_upload($key)) 
            {
                $files[] = $this->upload->data();
            }
            else
            {
                $error = $this->upload->display_errors();
                $this->_last_message = $error;
            }
        }
        $this->load->library('image_lib');

        foreach ($files as $a => $data_upload) 
        {
            $image_file_name = $product_name .'-' . dechex((int) date('His'));
            $image_file_name .= $data_upload['file_ext'];
//            // Start processing the uploaded image
            $config['image_library'] = 'gd2';
            $config['source_image'] = './images/uploads/' . $data_upload['file_name'];
            $config['maintain_ratio'] = TRUE;

            // 1. Create the main image
            //
            // setup the appropriate width & height
            $config['width'] = 800;
            $config['height'] = 600;
            if ($data_upload['image_width'] < $data_upload['image_height']) {
                $config['width'] = 800;
                $config['height'] = 600;
            }
            $config['new_image'] = $image_path . $image_file_name;
            $this->image_lib->initialize($config);

            $this->image_lib->resize();

            $this->image_lib->clear();

//            $config['source_image'] = $image_path . $image_file_name;
//            $config['wm_type'] = 'text';
//            $config['wm_text'] = 'w w w . n o i t h a t g o . p r o . v n';
//            $config['wm_font_size'] = '14';
//            $config['wm_font_color'] = 'ffffff';
//            $config['wm_vrt_alignment'] = 'middle';
//            $config['wm_hor_alignment'] = 'center';
//            $this->image_lib->initialize($config);
//            $this->image_lib->watermark();
//            $this->image_lib->clear();

            // 2. Create the thumbnail image
            $thumb_width = 130;
            $thumb_height = 130;
            $config['width'] = $thumb_width;
            $config['height'] = $thumb_height;
            
            $config['source_image'] = './images/uploads/' . $data_upload['file_name'];
            $config['new_image'] = $image_path . 'thumbnails/' . $image_file_name;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();

            // 3. Create the small image
            $config['width'] = 40;
            $config['height'] = 30;
            $config['source_image'] = $config['new_image'];
            $config['new_image'] = $image_path . 'smalls/' . $image_file_name;
            $this->image_lib->initialize($config);

            $this->image_lib->resize();

            $this->image_lib->clear();

            if (file_exists('./images/uploads/' . $data_upload['file_name']))
                unlink('./images/uploads/' . $data_upload['file_name']);

            // Save to database
            $data = array(
                'products_id' => $product_id,
                'image_name' => $image_file_name
            );
            $this->add_image($data);
        }
        
        sleep(1);
    }
}
?>