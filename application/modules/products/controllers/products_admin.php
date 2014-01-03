<?php
class Products_Admin extends MX_Controller
{
    private $_last_message = '';
    function __construct()
    {
        parent::__construct();
        if(!modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE))) redirect('/');
        if(!$this->phpsession->get("product_lang")) $this->phpsession->save('product_lang', 'vi');
        $this->load->model('units/units_model');
    }

    function index()
    {
        return $this->list_products();
    }

    /**
     * Sắp xếp layout, chuẩn bị dữ liệu cho module products
     *
     * @param type $method
     * @param type $para1
     * @param type $para2
     */
    function dispatcher($method='dashboard', $para1=NULL, $para2=NULL)
    {
        $layout             = 'duongbq/admin_layout';
        $current_url        = '';

        switch ($method)
        {
            // PRODUCTS
            case 'list_products':
            case 'dashboard':
                $lang = switch_language($para1);
                $this->phpsession->save('product_lang', $lang);
                $main_content           = $this->list_products(array('lang' => $lang, 'page' => $para2));
                $current_url            = '/dashboard/products/' . $lang;
                break;
            case 'add_product':
                $main_content           = $this->add_product();
                break;
            case 'edit_product':
                $main_content           = $this->edit_product(array('product_id' => $para1));
                break;
            case 'delete_product':
                $main_content           = $this->delete_product(array('product_id' => $para1));
                break;
            case 'up_product':
                $main_content           = $this->up_product(array('product_id' => $para1));
                break;
        }

        $view_data                  = array();
        $view_data['url']           = isset($current_url) ? $current_url : '';
        $view_data['admin_menu']    = modules::run('menus/menus/get_dashboard_menus');
        $view_data['main_content']  = $main_content;
        // META data
        $view_data['title']         = $this->_title;
        $this->load->view($layout, $view_data);
    }

    /**
     * Liệt kê danh sách các sản phẩm của chủ gian hàng hoặc danh sách tất cả
     * sản phẩm nếu người đăng nhập là quản trị
     *
     * @return type
     */
    function list_products($options = array())
    {
        $options                = array_merge($options, $this->_prepare_search($options));
        $options['is_admin']    = TRUE;
        if($options['cat_id'] != DEFAULT_COMBO_VALUE)
        {
            $cats = $this->categories_model->get_categories_array_follow_parent_id(array('parent_id' => $options['cat_id'], 'lang' => $options['lang']));
            $options['cats_id'] = isset($cats[$options['cat_id']]) ? $cats[$options['cat_id']] : $cats[0];
            unset($options['cat_id']);
        }
        $total_row              = $this->products_model->get_products_count($options);
        $total_pages            = (int)($total_row / ADMIN_PRODUCT_PER_PAGE);
        if ($total_pages * ADMIN_PRODUCT_PER_PAGE < $total_row) $total_pages++;
        if ((int)$options['page'] > $total_pages) $options['page'] = $total_pages;

        $options['offset']  = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int)$options['page'] - 1) * ADMIN_PRODUCT_PER_PAGE;
        $options['limit']   = ADMIN_PRODUCT_PER_PAGE;

        $config = prepare_pagination(
            array(
                'total_rows'    => $total_row,
                'per_page'      => $options['limit'],
                'offset'        => $options['offset'],
                'js_function'   => 'change_page_admin'
            )
        );
        $this->pagination->initialize($config);

        $view_data  = array();
        $view_data['page_links']    = $this->pagination->create_ajax_links();
        $view_data['products']      = $this->products_model->get_products($options);
        $view_data['total_rows']    = $total_row;
        $view_data['total_pages']   = $total_pages;
        $view_data['page']          = $options['page'];
        $view_data['product_name']  = isset($options['product_name']) ? $options['product_name'] : FALSE;
        $view_data['categories_array'] = $this->categories_model->get_categories_array();
        $view_data['filter']        = $options['filter'];
        $view_data['lang']          = $options['lang'] != 'vi' ? '/' . $options['lang']  : '';
        //heading
        $this->_title       = 'Quản lý sản phẩm' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/products/product_list', $view_data, TRUE);
    }


    /*
     * Thêm mới sản phẩm
     */
    function add_product()
    {
        $this->form_validation->set_rules('product_name', 'Tên sản phẩm', 'trim|required|xss_clean|max_length[256]');
        if ($this->form_validation->run())
        {
            $data = array(
                'product_name'  => $this->input->post('product_name'),
                'status'        => ACTIVE_PRODUCT,
                'created_date'  => date('Y-m-d H:i:s'),
                'updated_date'  => date('Y-m-d H:i:s'),
                'lang'          => $this->phpsession->get("product_lang")
                );
            $product_id = $this->products_model->add_product($data);
            redirect('dashboard/products/edit/'. $product_id);
        }
        else
        {
            $options['error'] = validation_errors();
            $view_data = array();
            $view_data['options'] = $options;
            $view_data['header']        = 'Thêm sản phẩm';
            $this->_title       = 'Thêm sản phẩm' . DEFAULT_TITLE_SUFFIX;
            return $this->load->view('admin/products/add_product_form', $view_data, TRUE);
        }
        return FALSE;
    }

    /**
     * Thực hiện việc sửa nội dung sản phẩm.
     *
     */
    function edit_product($options = array())
    {
        $view_data  = array();
        // Nếu là postback thì lưu dữ liệu và quay trở lại trang danh sách
        if ($this->is_postback())
        {
            if (!$this->_do_edit_product())
                $options['error'] = $this->_last_message;
        }
        // Hiển thị form sửa sản phẩm
        $view_data                  = $this->_get_edit_product_form_data($options);
        if (isset($options['error'])) $view_data['options'] = $options;
        $view_data['uri']           = '/dashboard/products/edit';
        $view_data['header']        = 'Sửa thông tin sản phẩm';
        $view_data['button_name']   = 'Sửa sản phẩm';
        $view_data['images']        = $this->get_products_images();
        $view_data['scripts']       = $this->_get_tiny_mce_scripts();
        //heading
        $this->_title               = 'Sửa sản phẩm' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('admin/products/edit_product_form', $view_data, TRUE);
    }

    /**
     * Lấy dữ liệu cho form đăng sản phẩm mới
     *
     * @author Tuấn Anh
     * @date   2011-05-02
     * @return type
     */
    private function _get_edit_product_form_data($options = array())
    {
        // Không cho phép gọi trực tiếp
        $product_id                     = $options['product_id'];
        $view_data                      = array();

        // Get from DB
        if(!$this->is_postback())
        {
            $products                       = $this->products_model->get_products(array('id' => $product_id, 'is_admin' => TRUE));
            if(!is_object($products)) show_404();
            $view_data['product_name']      = $products->product_name;
            $view_data['summary']           = $products->summary;
            $price_unit                     = get_unit_from_price($products->price);
            $view_data['price']             = str_replace('.00', '', $price_unit['price']);
            $view_data['unit']              = $this->utility_model->get_product_units_combo(array('combo_name' => 'unit', 'unit' => $price_unit['unit']));
            $view_data['product_unit']      = $this->units_model->get_units_combo(array('units' => $products->unit_id ));
            $view_data['description']       = $products->description;
            $view_data['top_sell_product']  = $this->utility_model->get_special_product_combo(array('combo_name' => 'top_seller', 'top_seller'=> $products->top_seller));
            $view_data['categories']        = modules::run('products/categories/get_categories_combo', array('categories' => $products->categories_id, 'lang' => $products->lang));
            $view_data['product_tags']      = $products->tags;
            $view_data['meta_title']        = $products->meta_title;
            $view_data['meta_keywords']     = $products->meta_keywords;
            $view_data['meta_description']  = $products->meta_description;
            $view_data['lang_combobox']     = $this->utility_model->get_lang_combo(array('lang' => $products->lang, 'extra' => 'onchange="javascript:get_categories_by_lang();"'));

        }
        // Get from submit
        else
        {
            $view_data['product_name']      = $this->input->post('product_name', TRUE);
            $view_data['summary']           = '';
            $view_data['description']       = '';
            $view_data['price']             = $this->input->post('price', TRUE);
            $view_data['unit']              = $this->utility_model->get_product_units_combo(array('combo_name' => 'unit', 'unit'=> $this->input->post('unit')));
            $view_data['product_unit']      = $this->units_model->get_units_combo(array( 'units' => $this->input->post('units', TRUE) ) );
            $view_data['top_sell_product']  = $this->utility_model->get_special_product_combo(array('combo_name' => 'top_seller', 'top_seller'=> $this->input->post('top_seller')));
            $view_data['categories']        = modules::run('products/categories/get_categories_combo', array('categories' => $this->input->post('categories'), 'lang' => $this->input->post('lang')));
            $view_data['product_tags']      = $this->input->post('product_tags', TRUE);
            $view_data['meta_title']        = $this->input->post('meta_title', TRUE);
            $view_data['meta_keywords']     = $this->input->post('meta_keywords', TRUE);
            $view_data['meta_description']  = $this->input->post('meta_description', TRUE);
            $view_data['lang_combobox']     = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();"'));
        }
        $view_data['product_id']            = $product_id;
        $this->phpsession->save('product_id', $product_id);
        return $view_data;
    }

    /**
     * Thực hiện việc thêm sản phẩm vào trong DB
     * @return type
     */
    private function _do_edit_product()
    {
        if($this->input->post('btnSubmit') === 'Sửa sản phẩm')
        {
            $this->form_validation->set_rules('product_name', 'Tên sản phẩm', 'trim|required|max_length[150]|xss_clean');
            $this->form_validation->set_rules('categories', 'Danh mục sản phẩm', 'required|is_not_default_combo');
            $this->form_validation->set_rules('price', 'Giá tiền', 'trim|required|max_length[11]|xss_clean|is_numeric');
            $this->form_validation->set_rules('description', 'Mô tả chi tiết', 'trim|required|min_length[10]|xss_clean');
            if ($this->form_validation->run($this))
            {
                $content = str_replace('&lt;', '<', $this->input->post('description'));
                $content = str_replace('&gt;', '>', $content);
                $product_data       = array(
                    'id'            => $this->input->post('product_id'),
                    'product_name'  => strip_tags($this->input->post('product_name', TRUE)),
                    'description'   => $content,
                    'price'         => $this->input->post('price') * $this->input->post('unit'),
                    'summary'       => $this->input->post('summary'),
                    'top_seller'    => $this->input->post('top_seller'),
                    'categories_id' => $this->input->post('categories'),
                    'meta_title'    => $this->input->post('meta_title', TRUE),
                    'meta_keywords' => $this->input->post('meta_keywords', TRUE),
                    'meta_description'=> $this->input->post('meta_description', TRUE),
                    'tags'          => $this->input->post('product_tags', TRUE),
                    'lang'          => $this->input->post('lang'),
                    'unit_id'       => $this->input->post('units')
                );
                $this->products_model->update_product($product_data);
                if($this->input->get('back_url') != '')
                    redirect($this->input->get('back_url'));
                else
                    redirect('/dashboard/products/' . $this->phpsession->get('product_lang'));
            }
            $this->_last_message = validation_errors();
            return FALSE;
        }
        else if($this->input->post('btnSubmit') == 'Upload')
        {
            $this->upload_images();
            $this->_last_message = $this->products_images_model->get_last_message();
        }
    }

    /**
     * Lấy ảnh tương ứng với từng sản phẩm
     */
    function get_products_images()
    {
        $options['product_id'] = $this->phpsession->get('product_id');
        $images = $this->products_images_model->get_images($options);
        $view_data = array();
        $view_data['images'] = $images;
        if($this->input->post('is-ajax'))
            echo $this->load->view('admin/products/products_images', $view_data, TRUE);
        else
            return $this->load->view('admin/products/products_images', $view_data, TRUE);
    }

    /*
     * Thực hiện upload ảnh khách sạn = uploadify
     */
    public function ajax_upload_products_image()
    {
        if (!empty($_FILES))
        {
            $image_path = './images/products/';
            $product_id = $this->phpsession->get('product_id');
            $products   = $this->products_model->get_products(array('id' => $product_id, 'is_admin' => TRUE)); 
            $product_name = url_title($products->product_name, 'dash', TRUE);
            $this->products_images_model->upload_image($product_id, $product_name, $image_path);
        }
    }
    
    function upload_images()
    {
            $image_path = './images/products/';
            $product_id = $this->phpsession->get('product_id');
            $products   = $this->products_model->get_products(array('id' => $product_id, 'is_admin' => TRUE)); 
            $product_name = url_title($products->product_name, 'dash', TRUE);
            $this->products_images_model->upload_image($product_id, $product_name, $image_path);
    }

    public function sort_products_image()
    {
        $arr = $this->input->post('id');
        $i = 1;
        foreach ($arr as $recordidval)
        {
            $array = array('position' => $i);
            $this->db->where('id', $recordidval);
            $this->db->where('products_id', $this->phpsession->get('product_id'));
            $this->db->update('product_images', $array);
            $i = $i + 1;
        }
    }

    public function delete_products_image()
    {
        $image_id = $this->input->post('id');
        $image_path = './images/products/';
        $this->products_images_model->delete_image($image_id, $image_path);
        echo $this->get_products_images();
    }

    /**
     * Xóa sản phẩm
     */
    function delete_product($options = array())
    {
        $product_id = $options['product_id'];
        // xóa ảnh
        $this->products_images_model->delete_all_images($product_id, './images/products/');

        //xóa sản phẩm
        $this->products_model->delete_product($product_id);
        redirect('/dashboard/products/' . $this->phpsession->get('product_lang'));
    }

    /**
     * Làm mới sản phẩm, và đưa lên đầu
     *
     */
    public function up_product($options = array())
    {
        // Chỉ thực hiện nếu lời gọi này được gọi từ trang list
        $product_id = $options['product_id'];
        $this->products_model->up_product($product_id);
        if($this->input->get('back_url') != '')
            redirect($this->input->get('back_url'));
        else
            redirect('/dashboard/products/' . $this->phpsession->get('product_lang'));
    }

    

    function process_status()
    {
        $id = $this->input->post('id');
        $product = $this->products_model->get_products(array('id' =>$id, 'is_admin' => TRUE));
        $status = $product->status == ACTIVE_PRODUCT ? INACTIVE_PRODUCT : ACTIVE_PRODUCT;
        $this->products_model->change_status($id, $status);
    }


    private function _prepare_search($options = array())
    {
        $view_data = array();
        // nếu submit
        if($this->is_postback())
        {
            $this->phpsession->save('product_name_search', $this->db->escape_str($this->input->post('product_name')));

            $view_data['search'] = $this->phpsession->get('product_name_search');
            $this->phpsession->save('categories_search_id', $this->input->post('categories_id'));
            $view_data['categories_combo'] = $this->categories_model->get_categories_combo(array('combo_name' => 'categories_id', 'categories_id' =>$this->input->post('categories_id'), 'lang' => $options['lang']));
        }
        else
        {
            $view_data['search'] = $this->phpsession->get('product_name_search');
            if(!($this->phpsession->get('categories_search_id'))) $this->phpsession->save('categories_search_id', DEFAULT_COMBO_VALUE);
            $view_data['categories_combo'] = $this->categories_model->get_categories_combo(array('combo_name' => 'categories_id', 'categories_id' => $this->phpsession->get('categories_search_id'), 'lang' => $options['lang']));

        }
        $view_data['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();"'));
        $options['keyword']                 = $this->phpsession->get('product_name_search');
        $options['cat_id']                  = $this->phpsession->get('categories_search_id');
        $options['filter']                  = $this->load->view('admin/products/search_product_form', $view_data, TRUE);
        return $options;
    }

    private function _get_tiny_mce_scripts()
    {
        $scripts                     = '<script type="text/javascript" src="/duongbq/scripts/tiny_mce/tiny_mce.js?v=20111006"></script>';
        $scripts                    .= '<script language="javascript" type="text/javascript" src="/duongbq/scripts/tiny_mce/plugins/imagemanager/js/mcimagemanager.js?v=20111006"></script>';
        $scripts                    .= '<script type="text/javascript">enable_advanced_wysiwyg("wysiwyg");</script>';
        return $scripts;
    }
}
?>
