<?php
echo form_open('', array('id' => 'cat_form'), array('cat_id' => 0, 'IS_FROM_LIST' => TRUE));
echo form_close();
echo form_hidden('back_url', '/dashboard/products/categories/');
?>
<div class="page_header">
    <h1 class="fleft">Danh mục sản phẩm</h1>
    <small class="fleft">"Thêm danh mục sản phẩm"</small>
    <span class="fright"><a class="button add" href= "/dashboard/products/categories/add"><em>&nbsp;</em>Thêm danh mục</a></span>
    <br class="clear"/>
</div>

<div style="margin-top: 10px;width: 100%;">
    <div class="form_content">
    <?php 
        $this->load->view('admin/categories/filter_form'); 
    ?>
        <div id="sort_cat" class="sortable">
            <?php 
                $this->load->view('duongbq/message');
                if(isset($list_categories)) echo $list_categories;
            ?>
        </div>
    <br class="clear"/>&nbsp;
    </div>
</div>