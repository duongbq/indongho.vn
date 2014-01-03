<?php
class Orders extends MX_Controller
{
    private $_last_message = '';
    function __construct()
    {
        parent::__construct();
        $this->load->helper('orders');
        $this->load->model('orders_model');
    }

    /**
     * Chuẩn bị layout, các phần dữ liệu cần thiết cho module này
     *
     * @param type $method
     * @param type $para1
     * @param type $para2
     */
    function dispatcher($method='', $para1=NULL, $para2=NULL, $para3=NULL)
    {
        $main_content           = NULL;
        $layout                 = 'layout/content_layout';
        $view_data              = array();
        $extra_cond             = array();
        $lang                   = $this->_lang;
        $breadcrumbs            = '';
        
        switch ($method)
        {
            case 'shopping_cart' :
                $main_content       = $this->shopping_cart();
                $breadcrumbs        = modules::run('breadcrumbs/breadcrumbs_with_param', array(array('uri' => get_base_url() . 'gio-hang', 'name' => 'Giỏ hàng'),
                                                                                                array('uri' => get_base_url(), 'name' => __('IP_home_page'))
                                                                                                ));
                $extra_cond['hide_slide']       = TRUE;
                break;
            case 'show_invoice' :
                $main_content       = $this->show_invoice(array('order_id' => $para1));
                $breadcrumbs        = modules::run('breadcrumbs/breadcrumbs_with_param', array(array('uri' => '#', 'name' => 'Hóa đơn của bạn'),
                                                                                                array('uri' => get_base_url(), 'name' => __('IP_home_page'))
                                                                                                ));
                $extra_cond['hide_slide']       = TRUE;
                break;
            case 'thank_you' :
                $main_content       = $this->thank_you();
                $breadcrumbs        = modules::run('breadcrumbs/breadcrumbs_with_param', array(array('uri' => '#', 'name' => 'Cảm ơn quý khách'),
                                                                                                array('uri' => get_base_url(), 'name' => __('IP_home_page'))
                                                                                               ));
                $extra_cond['hide_slide']       = TRUE;
        }

        $view_data                      = modules::run('pages/pages/get_genaral_content', array('lang' => $lang)+ $extra_cond);
        $view_data['url']               = isset($current_url) ? $current_url : '';
        $view_data['breadcrumbs']       = $breadcrumbs;
        $view_data['left_side']         = modules::run('products/categories/get_left_categories', array('lang' => $lang));
        $view_data['main_content']      = $main_content;
        
        $view_data['title']             = $this->_title;
        $view_data['keywords']          = $this->_keywords;
        $view_data['description']       = $this->_description;

        $this->load->view($layout, $view_data);
    }

    function add_to_cart($product_id=0)
    {
//        $this->cart->destroy();die;
        $product = $this->products_model->get_products(array('id' => $product_id));
        $flag = FALSE;
        $carts = $this->cart->contents();
        // kiểm tra xem trong giỏ hàng đã có sản phẩm này chưa
        // nếu có rồi thì tăng số lượng lên 1
        foreach($carts as $cart)
        {
            if($cart['id'] == $product_id)
            {
                $rowid      = $cart['rowid'];
                $quantity   = $cart['qty'];
                $flag       = TRUE;
                break;
            }
        }
        if(!$flag)
        {
            $data = array(
                'id'        => $product_id,
                'qty'       => 1,
                'price'     => $product->price,
                'name'      => $product->product_name,
                'cat_name'  => $product->category,
                'cat_id'    => $product->categories_id,
                'images'    => $product->image_name
            );
            $this->cart->insert($data);
        }
        else
        {
            $data = array(
              'rowid' => $rowid,
               'qty'   => $quantity + 1
            );
            $this->cart->update($data);
        }
            redirect('/gio-hang', 'refresh');
    }
    
    public function remove_product_in_cart()
    {
        $id = $this->input->post('id');
        $data = array(
          'rowid' => $id,
           'qty'   => 0
        );
        $this->cart->update($data);
    }
    
    public function update_product_in_cart()
    {
        $id         = $this->input->post('id');
        $quantity   = $this->input->post('quantity');
        $data = array(
          'rowid' => $id,
           'qty'   => $quantity,
        );
        $this->cart->update($data);
    }
    
    function shopping_cart($options = array())
    {
        if($this->is_postback())
        {
             if (!$this->_do_add_order())
                $options['error'] = $this->_last_message;
             else
                $options['succeed'] = $this->_last_message;
        }
        
        $view_data = array();
        $view_data = $this->get_add_order_form();
        if(isset($options['error']) || isset($options['succeed'])) $view_data['options'] = $options;
        $this->_title = 'Giỏ hàng của bạn  ' . DEFAULT_TITLE_SUFFIX;
        
        return $this->load->view('products/order/shopping_cart', $view_data, TRUE);
    }

    private function get_add_order_form()
    {
        $view_data = array();
//        $payments = $this->payments_model->get_payments();
        if(!$this->is_postback() && $this->phpsession->get('is_logged_in'))
        {
            $view_data['fullname']      = $this->phpsession->get('fullname');
            $view_data['phone']         = $this->phpsession->get('phone');
            $view_data['email']         = $this->phpsession->get('email');
            $view_data['address']       = $this->phpsession->get('address');
        }
        else
        {
            $view_data['fullname']      = $this->input->post('fullname', TRUE);
            $view_data['phone']         = $this->input->post('phone', TRUE);
            $view_data['email']         = $this->input->post('email', TRUE);
            $view_data['address']       = $this->input->post('address', TRUE);
        } 
        $view_data['city']          = $this->city_model->get_city_combo(array('city' => $this->input->post('city'), 'parent_id' => 0, 'extra' => 'onchange="javascript:get_district(this);"'));
        $view_data['district']      = $this->city_model->get_district_combo(array('district' => $this->input->post('district'), 'parent_id' => $this->input->post('city')));
        $view_data['content']       = $this->input->post('content', TRUE);
        return $view_data;

    }
    private function _do_add_order($options = array())
    {
        $this->form_validation->set_rules('fullname', 'Họ và tên', 'trim|required|max_length[50]|xss_clean');
        $this->form_validation->set_rules('city', 'Thành phố', 'required|is_not_default_combo');
        $this->form_validation->set_rules('district', 'Quận Huyện', 'required|is_not_default_combo');
        $this->form_validation->set_rules('phone', 'Điện thoại', 'trim|required|xss_clean|is_numeric');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('address', 'Địa chỉ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('security_code', __("IP_capcha"), 'trim|required|matches_value[' . $this->phpsession->get('captcha') . ']|xss_clean');

        if ($this->form_validation->run($this))
        {
            $order_data       = array(
                'sale_date' => date('Y-m-d H:i:s'),
                'payment'   => $this->input->post('payment'),
                'total'     => $this->cart->total(),
                'order_status'    => NEW_ORDER,
                'receiver'  => $this->input->post('fullname', TRUE),
                'address'   => $this->input->post('address', TRUE),
                'phone'     => $this->input->post('phone', TRUE),
                'email'     => $this->input->post('email', TRUE),
                'other'     => $this->input->post('content', TRUE),
                'city_id'   => $this->input->post('city', TRUE),
                'district_id' => $this->input->post('district', TRUE),

            );
            if($this->phpsession->get('is_logged_in'))
                $order_data['user_id'] = $this->phpsession->get('user_id');
            
            $order_id = $this->orders_model->add_order($order_data);

            $carts = $this->cart->contents();
            foreach($carts as $cart)
            {
                $order_details_data = array(
                    'order_id'      => $order_id,
                    'product_id'    => $cart['id'],
                    'quantity'      => $cart['qty'],
                    'price'      => $cart['price'],
                );
                $this->orders_model->add_order_details($order_details_data);
            }

            // gửi mail cho khách hàng
            $this->_send_email_invoice($order_data, $order_id);
            $this->cart->destroy();
            $this->_last_message = '<p>
                ĐƠN HÀNG CỦA QUÝ KHÁCH ĐÃ ĐƯỢC GỬI CHO MR SẠCH <br>
                Chúng tôi sẽ liên hệ với quý khách trong thời gian sớm nhất <br>
                Chi tiết đơn hàng đã được chúng tôi gửi đến email của bạn.
                </p>';
            redirect('/cam-on');
            return TRUE;
        }
        $this->_last_message = validation_errors();
        return FALSE;
    }

    private function _send_email_invoice($data = array(), $order_id = 0)
    {
        $carts = $this->cart->contents();
        $this->load->library('email');
        $data['order_id']       = $order_id;
        $cities_array           = $this->city_model->get_cities_array();
        $config                 = modules::run('configurations/get_configuration', array('array' => TRUE));
        $email_content          = str_replace('{domain_name}', TITLE_EMAIL, $config['order_email_content']);
        $email_content          = str_replace('{receiver}', $data['receiver'], $email_content);
        $email_content          = str_replace('{order_id}', $data['order_id'], $email_content);
        $email_content          = str_replace('{time}', date('H:i:s', strtotime($data['sale_date'])), $email_content);
        $email_content          = str_replace('{date}', date('d/m/Y', strtotime($data['sale_date'])), $email_content);
        $email_content          = str_replace('{address}', $data['address'], $email_content);
        $email_content          = str_replace('{district}', $cities_array[$data['district_id']], $email_content);
        $email_content          = str_replace('{city}', $cities_array[$data['city_id']], $email_content);
        $email_content          = str_replace('{phone}', $data['phone'], $email_content);
        $all_product = '';
        foreach ($carts as $cart)
        {
            $all_product .= '<tr>
                <td style="border:solid 1px #CCCCCC;padding:5px" align="right">MS'. $cart['id'] .'</td>
                <td style="border:solid 1px #CCCCCC;padding:5px" >' . $cart['name'] . '</td>
                <td style="border:solid 1px #CCCCCC;padding:5px" align="right">' . $cart['qty'] .'</td>
                <td style="border:solid 1px #CCCCCC;padding:5px" align="right">' . get_price_in_vnd($cart['price']) .'</td>
                <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>' . get_price_in_vnd($cart['price'] * $cart['qty']) . 'VNĐ</b></td>
            </tr>';
        }
        $product_table = '<table style="border:solid 1px #CCCCCC" width="100%" cellspacing="0" >
            <tbody>
                <tr style="background-color:#f1f1f1">
                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>Mã số</b></td>
                    <td style="border:solid 1px #CCCCCC;padding:5px"><b>Tên</b></td>
                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>Số lượng</b></td>
                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>Đơn giá</b></td>
                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>Thành tiền</b></td>
                </tr>' . $all_product . '
                <tr>
                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right" colspan="4"><b>Tổng tiền hàng:</b></td>
                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b><font color="#000088">' . get_price_in_vnd($data['total']) .'VNĐ</font></b>
                        <br>Chưa bao gồm chi phí vận chuyển</td>
                </tr>
            </tbody>
        </table>';
        $email_content          = str_replace('{all_product}', $product_table, $email_content);
        $data['email_content']  = $email_content;
        $title                  = TITLE_EMAIL . ' Đơn đặt hàng số ' . $order_id;
        $message                = $this->load->view('/order/invoice_email_form', $data, TRUE);

        
        $order_email    = ($config['order_email'] != '' && $config['order_email'] != NULL) ? $config['order_email'] : CONTACT_EMAIL;
        
        $this->email->from(EMAIL_NO_REPLY, TITLE_EMAIL);
        $this->email->subject($title);
        $this->email->message($message);
        $this->email->to(array($data['email'], $order_email));
        $this->email->send();
    }

    public function show_invoice($options = array())
    {
        $orders_details                 = $this->orders_model->get_orders_details($options);
        $orders                         = $this->orders_model->get_orders($options);
        if(!is_object($orders)) show_404();
        if($this->phpsession->get('user_id') != $orders->user_id && !modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE))) redirect('/');
        $view_data                      = array();
        $view_data['orders']            = $orders;
        $view_data['orders_details']    = $orders_details;
        $view_data['cities_array']      = $this->city_model->get_cities_array();
        $this->_title = 'Hóa đơn của bạn  ' . DEFAULT_TITLE_SUFFIX;
        return $this->load->view('/order/invoice', $view_data, TRUE);
    }
    
    public function get_district()
    {
        $options['parent_id']   = $this->input->post('parent_id');
        echo $this->city_model->get_district_combo($options);
    }
    
    function thank_you()
    {
        return $this->load->view('/order/thank_you', NULL, TRUE);
    }
}

?>
