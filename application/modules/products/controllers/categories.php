<?php
class Categories extends MX_Controller
{
    function __construct()
    {
//        $this->output->enable_profiler(TRUE);
        parent::__construct();
    }

    function get_left_categories($options = array())
    {   
        $cond = array();
        
        if(isset($options['lang']))             $cond['lang']   = $options['lang'];
        if(isset($options['product_cat_id']))   $cond['cat_id'] = $options['product_cat_id'];
        
        $cond['categories']  = $this->categories_model->get_categories($cond);
        $cond['parent_id']   = 0;
        $categories_menu   = '<ul>';
        $categories_menu   .= $this->_visit_cat($cond);
        $categories_menu   .= '</ul>';
        $view_data = array();
        $view_data['categories_menu'] = str_replace('<ul class="sub_categories"></ul>', '', $categories_menu);

        return $this->load->view('products/categories/categories_menus', $view_data, TRUE);
    }


    private function _visit_cat($params = array())
    {
        $output                 = '';
        $sub_cats               = $this->_get_sub_cats($params);
        foreach($sub_cats as $cat)
        {
            if ($cat->id == $params['cat_id']) $selected = ' selected'; else $selected = '';
            $output             .= '<li class="'.$cat->css.$selected.'"><a href="'. get_base_url() . url_title($cat->category, 'dash', TRUE) . '-c' . $cat->id .  '">' . $cat->category . '</a>';
            $params['parent_id']= $cat->id;
            $output             .= '<ul class="sub_categories">';
            $output             .= $this->_visit_cat($params);
            $output             .= '</ul></li>';
        }

        return $output;
    }

    private function _get_sub_cats($params = array())
    {
        $cats      = $params['categories'];
        $sub_cats  = array();

        foreach($cats as $index => $menu)
        {
            if ($menu->parent_id == $params['parent_id'])
                $sub_cats[$index] = $menu;
        }
        return $sub_cats;
    }

    /**
     * Trả lại combo box bao gồm các danh mục sản phẩm
     *
     * @author Tuấn Anh
     * @date   2011-05-02
     * @param type $options
     */
    function get_categories_combo($options = array())
    {
        return $this->categories_model->get_categories_combo($options);
    }
}
?>
