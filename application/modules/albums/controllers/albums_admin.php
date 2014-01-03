<?php 
class Albums_Admin extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
//        $this->output->enable_profiler(TRUE);
        if(!modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE))) redirect('/');
    }

    function dispatcher($method='', $para1=NULL, $para2=NULL)
    {
        
        $current_menu       = array();
        $menu_params        = array('current_menu' => '/' . $this->uri->uri_string());
        $layout             = 'duongbq/admin_layout';

        switch ($method)
        {
            case 'list_albums':
                $main_content       = $this->list_albums();
                break;
            case 'add_album':
                $main_content       = $this->add_album();
                break;
            case 'edit_album':
                $main_content       = $this->edit_album(array('album_id'=>$para1));
                break;
        }

        $view_data                  = array();
        $view_data['url']           = isset($current_url) ? $current_url : '';
        $view_data['admin_menu']    = modules::run('menus/menus/get_dashboard_menus', $menu_params);
        $view_data['main_content']  = $main_content;
        // META data
        $view_data['title']         = $this->_title;
        $this->load->view($layout, $view_data);
    }

    function list_albums()
    {
        $view_data = array();
        $view_data['albums'] = $this->albums_model->get_albums();
        $this->_title       = 'Quản lý album' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/list_albums', $view_data, TRUE);
    }

    function add_album()
    {
        $this->form_validation->set_rules('album_name', 'Tên album', 'trim|required|xss_clean|max_length[256]');
        if ($this->form_validation->run())
        {
            $data = array(
                'name'          => $this->input->post('album_name'),
                'created_date'  => date('Y-m-d H:i:s'),
                );
            $album = $this->albums_model->get_albums(array('last_row' => TRUE));
            $data['position'] = (isset($album->position)) ? $album->position + 1 : 1;
            $album_id = $this->albums_model->add_album($data);
            redirect('dashboard/albums/edit/'. $album_id);
        }
        else
        {
            $options['error'] = validation_errors();
            $view_data = array();
            $view_data['options'] = $options;
            $this->_title       = 'Thêm album' . DEFAULT_TITLE_SUFFIX;
            return $this->load->view('admin/add_album_form', $view_data, TRUE);
        }
        return FALSE;
    }

    /**
     * Thực hiện việc sửa nội dung sản phẩm.
     *
     */
    function edit_album($options = array())
    {
        $view_data  = array();
        // Nếu là postback thì lưu dữ liệu và quay trở lại trang danh sách
        if ($this->is_postback())
        {
            if (!$this->_do_edit_album())
                $options['error'] = validation_errors();
        }
        // Hiển thị form sửa sản phẩm
        $view_data                  = $this->_get_edit_album_form_data($options);
        if (isset($options['error'])) $view_data['options'] = $options;
        $view_data['uri']           = '/dashboard/albums/edit';
        $view_data['header']        = 'Sửa thông tin album';
        $view_data['button_name']   = 'Sửa album';
        $view_data['images']        = $this->get_album_images();
        //heading
        $this->_title               = 'Sửa album' . DEFAULT_TITLE_SUFFIX;
        $this->_keywords            = $this->_title . ' ' . $this->_keywords;
        $content                    = $this->_description;
        $this->_description         = my_trim(remove_new_line($content));
        return $this->load->view('admin/edit_album_form', $view_data, TRUE);
    }

    /**
     * Lấy dữ liệu cho form đăng sản phẩm mới
     *
     * @author Tuấn Anh
     * @date   2011-05-02
     * @return type
     */
    private function _get_edit_album_form_data($options = array())
    {
        // Không cho phép gọi trực tiếp
        $album_id                     = $options['album_id'];
        $view_data                      = array();

        // Get from DB
        if(!$this->is_postback())
        {
            $albums                   = $this->albums_model->get_albums(array('id' => $album_id));
            if(!is_object($albums)) show_404();
            $view_data['album_name']    = $albums->name;

        }
        // Get from submit
        else
        {
            $view_data['album_name']  = $this->input->post('album_name', TRUE);
        }
        $view_data['album_id']        = $album_id;
        $this->phpsession->save('album_id', $album_id);
        return $view_data;
    }

    /**
     * Thực hiện việc thêm sản phẩm vào trong DB
     * @return type
     */
    private function _do_edit_album()
    {
        $this->form_validation->set_rules('album_name', 'Tên album', 'trim|required|max_length[150]|xss_clean|callback_album_name_max_length');
        if ($this->form_validation->run($this))
        {
            $album_data         = array(
                'id'            => $this->input->post('album_id'),
                'name'          => strip_tags($this->input->post('album_name', TRUE)),
            );
            $this->albums_model->update_album($album_data);
            redirect('/dashboard/albums');
        }
        return FALSE;
    }

    /**
     * Lấy ảnh tương ứng với từng sản phẩm
     */
    function get_album_images()
    {
        $options['album_id'] = $this->phpsession->get('album_id');
        $options['is_admin'] = TRUE;
        $images = $this->albums_images_model->get_images($options);
        $view_data = array();
        $view_data['images'] = $images;
        if($this->input->post('is-ajax'))
            echo $this->load->view('admin/album_images', $view_data, TRUE);
        else
            return $this->load->view('admin/album_images', $view_data, TRUE);
    }

    public function ajax_upload_album_images()
    {
        if (!empty($_FILES))
        {
            // không có dòng này sẽ không upload được
            echo 'Ket noi thanh cong.';
            $image_path = './images/albums/';
            $album_id   = $this->phpsession->get('album_id');
            $this->albums_images_model->upload_image($album_id, $image_path);
        }
    }

    public function sort_album_images()
    {
        $arr = $this->input->post('id');
        $i = 1;
        foreach ($arr as $recordidval)
        {
            $array = array('position' => $i);
            $this->db->where('id', $recordidval);
            $this->db->where('album_id', $this->phpsession->get('album_id'));
            $this->db->update('album_images', $array);
            $i = $i + 1;
        }
    }

    public function delete_album_images()
    {
        $image_id = $this->input->post('id');
        $image_path = './images/albums/';
        $this->albums_images_model->delete_image($image_id, $image_path);
        echo $this->get_album_images();
    }

    /**
     * Xóa sản phẩm
     */
    function delete_album($id = 0)
    {
        $album_id = $id;
        if($album_id != 1)
        {
            $this->albums_images_model->delete_all_images($album_id, './images/albums/');
            $this->albums_model->delete_album($album_id);
        }
        redirect('/dashboard/albums');
    }


    public function sort_album()
    {
        $arr = $this->input->post('id');
        $i = 1;
        foreach ($arr as $recordidval)
        {
            $array = array('position' => $i);
            $this->db->where('id', $recordidval);
            $this->db->update('albums', $array);
            $i = $i + 1;
        }
    }
    
    function change_album_images_status()
    {
        $id = $this->input->post('id');
        $images = $this->albums_images_model->get_images(array('id' =>$id, 'is_admin' => TRUE));
        $status = $images->status == ACTIVE_ADV ? INACTIVE_ADV : ACTIVE_ADV;
        $this->albums_images_model->change_status($id, $status);
    }
    
    function edit_link()
    {
        $link   = $this->input->post('value');
        $id     = $this->input->post('id');
        $this->albums_images_model->update_link($link, $id);
        echo $link;
    }
    
    function edit_title()
    {
        $title   = $this->input->post('value');
        $id     = $this->input->post('id');
        $this->albums_images_model->update_title($title, $id);
        echo $title;
    }
}
?>
