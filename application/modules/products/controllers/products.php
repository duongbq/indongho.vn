<?php
class Products extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->output->link_js('/scripts/jquery.jcarousel.min.js');
        //$this->output->enable_profiler(TRUE);
    }

    /**
     * Chuẩn bị layout, các phần dữ liệu cần thiết cho module này
     *
     * @param type $method
     * @param type $para1
     * @param type $para2
     */
    function dispatcher($method='list_products', $para1=NULL, $para2=NULL, $para3=NULL)
    {
        $main_content           = NULL;
        $side_content           = NULL;
        $layout                 = 'layout/content_layout';
        $view_data              = array();
        $extra_cond             = array();
        $lang                   = $this->_lang;
        $breadcrumbs            = '';
        
        switch ($method)
        {
            case 'list_products' :
                $main_content       = $this->get_products(array('lang'=> $lang, 'page' => $para2, 'is_list_product' => TRUE));
                $breadcrumbs        = modules::run('breadcrumbs/breadcrumbs_with_param', array(array('uri' => get_url_by_lang($lang,'products'), 'name' => __('IP_Products')),
                                                                                                array('uri' => get_base_url(), 'name' => __('IP_home_page'))
                                                                                                ));
                if($this->input->get('keyword') == '')
                    $current_url = '/san-pham';
                else
                    $current_url = '/tim-kiem@?keyword='.str_replace (' ', '+', $this->input->get('keyword'));
                break;
                $extra_cond['hide_slide']       = TRUE;
                break;
            case 'list_products_by_cat' :
                $main_content       = $this->get_products(array('lang'=> $lang, 'cat_id' => $para2, 'page' => $para3));
                $extra_cond['product_cat_id']   = $para2;
                $extra_cond['hide_slide']       = TRUE;
                $breadcrumbs        = modules::run('breadcrumbs/breadcrumbs_product_categories', array('cat_id' => $para2));
                if($lang != 'vi')
                    $current_url        = get_base_url(). $this->uri->segment(2);
                else
                    $current_url        = '/' . $this->uri->segment(1);
                break;
            case 'view_detail' :
                $this->output->link_css('/css/fancybox/jquery.fancybox-1.3.4.css');
                $this->output->link_js('/duongbq/scripts/fancybox/jquery.fancybox-1.3.4.pack.js');
                $this->output->javascripts('show_fancy_box();');
                $product = $this->products_model->get_products(array('lang'=> $lang, 'id' => $para3));
                if (!is_object($product) or empty($product))
                {
                    show_404('');
                    return;
                }
                else
                {
                    $viewed = $product->viewed;
                    $this->products_model->update_view($product->id);
                }
                
                $extra_cond['product_cat_id']   = $product->categories_id;
                $extra_cond['hide_slide']       = TRUE;
                $side_content           = '';
                
                $main_content           = $this->get_product_detail(array('id' => $para3, 'product' => $product, 'viewed' => $viewed ));
                $breadcrumbs            = modules::run('breadcrumbs/breadcrumbs_product_categories', array('cat_id' => $product->categories_id));
                break;
        }
        $view_data                      = modules::run('pages/pages/get_genaral_content', array('lang' => $lang, 'current_menu' => '/san-pham') + $extra_cond);
        $view_data['url']               = isset($current_url) ? $current_url : '';
        $view_data['breadcrumbs']       = $breadcrumbs;
        
        $view_data['main_content']      = $main_content;
        
        $view_data['title']             = $this->_title;
        $view_data['keywords']          = $this->_keywords;
        $view_data['description']       = $this->_description;

        $this->load->view($layout, $view_data);
    }

    /**
     *
     * @param type $category
     * @param type $page
     */
    function get_products($options = array())
    {
        $options['keyword'] = $this->input->get('keyword');
        if(!isset($options['cat_id'])) $options['cat_id'] = DEFAULT_COMBO_VALUE;
        $cat_id = $options['cat_id'];
        if($options['cat_id'] != DEFAULT_COMBO_VALUE)
        {
            $cats = $this->categories_model->get_categories_array_follow_parent_id(array('parent_id' => $options['cat_id'], 'lang' => $options['lang']));
            $options['cats_id'] = isset($cats[$options['cat_id']]) ? $cats[$options['cat_id']] : $cats[0];
            unset($options['cat_id']);
        }
        $config = get_cache('configurations');
        $page_param     = $config['products_per_page'] != 0 ? $config['products_per_page'] : PRODUCT_PER_PAGE; 
        $total_row      = $this->products_model->get_products_count($options);
        $total_pages    = (int) ($total_row / $page_param);
        $view_data      = array();
        
        if ($total_pages * $page_param < $total_row)
            $total_pages++;
        if ((int) $options['page'] > $total_pages)
            $options['page'] = $total_pages;

        $options['offset']  = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int) $options['page'] - 1) * $page_param;
        $options['limit']   = $page_param;

        $config = prepare_pagination(
            array(
                'total_rows' => $total_row,
                'per_page' => $options['limit'],
                'offset' => $options['offset'],
                'js_function' => 'change_page'
            )
        );
        
        $this->pagination->initialize($config);
        
        $products                   = $this->products_model->get_products($options);
        $meta_data                  = $this->_get_meta_data($options + array('cat_id' => $cat_id));
        $view_data['options']       = $options;
        $view_data['pagination']    = $this->pagination->create_ajax_links();
        $view_data['products']      = $products;
        $view_data['title']         = ($cat_id != -1) ? $meta_data['h1'] : __('IP_Products');
        $view_data['lang']          = $this->_lang;
        
        $this->_title               = $meta_data['title'] . DEFAULT_TITLE_SUFFIX;
        $this->_keywords            = $meta_data['keywords'];
        $this->_description         = $meta_data['description'];

        return $this->load->view('products/products/products', $view_data, TRUE);
    }


    private function _get_meta_data($options = array())
    {
        $output = array();
        if(!isset($options['is_list_product']))
        {
            $categories = $this->categories_model->get_categories(array('id' => $options['cat_id']));
            if(count($categories) == 0) return show_404();
            if(count($categories) > 0 && $categories[0]->meta_title == '')
            {
                $title          = $categories[0]->category;
                $keywords       = $categories[0]->category;
                $description    = $categories[0]->category;
                $h1             = $categories[0]->category;
            }
            else
            {
                $title          = $categories[0]->meta_title;
                $keywords       = $categories[0]->meta_keywords;
                $description    = $categories[0]->meta_description;
                $h1             = $categories[0]->category;
            }
        }
        else
        {
            $title              = __('IP_Products');
            $keywords           = __('IP_DEFAULT_KEYWORDS');
            $description        = __('IP_DEFAULT_DESCRIPTION');
            $h1                 = __('IP_Products');
        }
        
        
        
        $output['title']        = $title;
        $output['keywords']     = $keywords;
        $output['description']  = $description;
        $output['h1']           = $h1;
        return $output;
    }

    /*
     * @author duongbq
     * @date 3-8-2011
     */

    public function get_product_detail($options = array())
    {
        $this->load->model('pages/pages_model');
        $view       = $options['viewed'];
        $product    = $options['product'];
        $view_data  = array();
        // header
        $meta_data          = $this->_get_details_header($product);
        $this->_title       = $meta_data['title'] . DEFAULT_TITLE_SUFFIX;
        $this->_keywords    = $meta_data['keywords'];
        $this->_description = $meta_data['description'];

        $condition['product_id']    = $product->id;
        $options['product_id']      = $product->id;
        $view_data['viewed']        = $view;
        $view_data['options']       = $options;
        $view_data['product']       = $product;
        $view_data['images']        = $this->products_images_model->get_images($condition);
        $view_data['products_related']= $this->get_products_same_cat($options);
        if($product->tags != '')
            $view_data['tags']      = genarate_tags ($product->tags, 'san-pham');
        return $this->load->view('products/products/product_detail', $view_data, TRUE);
    }

    private function _get_details_header($product = array())
    {
        $output = array();
        if($product->meta_title != '' && $product->meta_title != NULL)
            $output['title']      = $product->meta_title;
        else 
            $output['title']      = $product->product_name . ' | ' . $product->category;
        if($product->meta_keywords != '' && $product->meta_keywords != NULL)
            $output['keywords']   = $product->meta_keywords;
        else
            $output['keywords']   = $output['title'];
//        if($product->cat_meta_keywords != '')
//            $output['keywords'] .= ' | ' . $product->cat_meta_keywords;
        if($product->meta_description != '' && $product->meta_description != NULL)
            $output['description']   = $product->meta_description;
        else
            $output['description']   = str_replace('"', '', strip_tags(my_trim(remove_new_line($product->description))));
        return $output;
    }

    // các sản phẩm cùng liên quan
    function get_products_same_cat($param = array())
    {
        $this->output->javascripts("run_slide_products_related('#related_products');");
        $options                            = array();
        $options['limit']                   = LIMIT_RELATED_PRODUCT;
        $options['cat_id']                  = $param['product']->categories_id;
        $options['except_id']               = $param['id'];
        $relate_product_data                = array();
        $relate_product_data['title']       = __('IP_related_products');
        $relate_product_data['lang']        = $this->_lang;
        $relate_product_data['products']    = $this->products_model->get_products($options);
        return $this->load->view('products/products/related_products', $relate_product_data, TRUE);
    }
    
    function get_products_same_cat_ajax() {
        
        $param = array();
        if(
                $this->input->post('pid')
                && $this->input->post('is_ajax')
        ) {
            $pid        = $this->input->post('pid');
            $product    = $this->products_model->get_products(array('id' => $pid));
            $page_param = $this->input->post('page') ? $this->input->post('page') : 1;
            
            if( !empty($product) ) {
                
                $param['product']   = $product;
                $param['except_id'] = $product->id;
                $param['cat_id']    = $product->categories_id;
                
                $param['page']      = $page_param;
                $param['limit']     = LIMIT_RELATED_PRODUCT;
                $param['offset']    = $param['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ( ($param['page'] - 1) * LIMIT_RELATED_PRODUCT );
                $param['products']  = $this->products_model->get_products( $param );
                //echo $this->db->last_query(); exit();
                echo $this->load->view('products/products/related_product_ajax', $param, TRUE);
            }            
        }
        exit();
    }
    

    // các sản phẩm mới nhất
    function get_lastest_products()
    {
        $options                = array();
        $options['limit']       = LIMIT_LASTEST_PRODUCT;
        $options['lang']        = $this->_lang;
        $lastest_product_data   = array();
        $lastest_product_data['title']      = __('IP_lastest_products');
        $lastest_product_data['products']   = $this->products_model->get_products($options);
        $lastest_product_data['lang']       = $this->_lang;
        return $this->load->view('products/products/lastest_products', $lastest_product_data, TRUE);
    }

    // các sản phẩm được xem nhiều nhất
    function get_most_viewed_products($param = array())
    {
        $options                = array();
        $options['limit']       = LIMIT_THE_MOST_VIEWED_PRODUCT;
        $options['lang']        = $this->_lang;
        $options['order']       = 'viewed desc';
        $most_viewed_product_data['title']                  = __('IP_feature_products');
        $most_viewed_product_data['most_viewed_products']   = $this->products_model->get_products($options);
        $most_viewed_product_data['lang']                   = $this->_lang;
        return $this->load->view('products/products/most_viewed_product', $most_viewed_product_data, TRUE);
    }
    
    function get_most_bought_products($options = array())
    {
        $options                    = array();
        $options['limit']           = LIMIT_THE_MOST_BOUGHT_PRODUCT;
        $options['lang']            = $this->_lang;
        $options['top_seller']      = TRUE;
        $most_bought_products_data  = array();
        $most_bought_products_data['products']   = $this->products_model->get_products($options);
        return $this->load->view('products/products/most_bought_products', $most_bought_products_data, TRUE);
    }
    
    function get_highlight_products($options = array())
    {
        $options['limit']           = LIMIT_THE_MOST_BOUGHT_PRODUCT;
        $options['lang']            = $this->_lang;
        $options['top_seller']      = TRUE;
        $highlight_product_data  = array();
        $highlight_product_data['highlight_products']   = $this->products_model->get_products($options);
        return $this->load->view('products/products/highlight_products', $highlight_product_data, TRUE);
    }
}

?>
