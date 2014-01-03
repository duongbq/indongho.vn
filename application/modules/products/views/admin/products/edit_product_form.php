
<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thay đổi thông tin về sản phẩm"</small>
    <span class="fright">
        <a class="button back" href="/dashboard/products/<?php echo $this->phpsession->get('product_lang');?>"><em>&nbsp;</em>Quay lại danh sách sản phẩm</a>
    </span>
    <br class="clear"/>
</div>

<?php
    $back_url = $this->input->get('back_url') != '' ? '?back_url=' . $this->input->get('back_url') : '';
    echo form_open_multipart('/dashboard/products/edit/' . $product_id . $back_url);
    echo form_hidden('product_id', $product_id);
    echo form_hidden('form', 'product_cat');
?>
<div id="sort_success">Vị trí ảnh đã được cập nhật</div>
<div class="form_content">
    <ul class="tabs">
            <li><a href="#tab1">Ảnh sản phẩm</a></li>
            <li><a href="#tab2">Nội dung</a></li>
            <li><a href="#tab3">Meta data</a></li>
    </ul>
    <div class="tab_container">
        
        <div id="tab1" class="tab_content">
<!--            <br class="clear-both"/>
                <input name="userfile" type="file" />
                <input type="submit" name="btnSubmit" value="Upload" />-->
            <div style="margin-top: 10px;">
                <input id="file_upload" name="file_upload" type="file" />
            </div>
            <input id="session_upload" name="session_upload" type="hidden" value="<?php echo session_id(); ?>" />
            <input id="process_url" name="process_url" type="hidden" value="/upload_products_images" />
            <br class="clear-both"/>
            <div id="products_images">
                <ul>
                    <?php if(isset($images)) echo $images;?>
                </ul>
            </div>
        </div>
        
        <div id="tab2" class="tab_content">
            <table>
                <?php $this->load->view('duongbq/message'); ?>
                <tr><td class="title">Ngôn ngữ: (<span>*</span>)</td></tr>
                <tr><td><?php if(isset($lang_combobox)) echo $lang_combobox;?></td></tr>
                <tr><td class="title">Tên sản phẩm: (<span>*</span>)</td></tr>
                <tr><td><?php echo form_input(array('name' => 'product_name', 'size' => '30', 'maxlength' => '256', 'value' => $product_name)); ?></td></tr>
                <tr><td class="title">Danh mục: (<span>*</span>)</td></tr>
                <tr><td id="category"><?php echo $categories; ?></td></tr>
                <tr><td class="title">Sản phẩm bán chạy: (<span>*</span>)</td></tr>
                <tr><td><?php if(isset($top_sell_product)) echo $top_sell_product;?></td></tr>
                <tr><td class="title">Giá tiền: (<span>*</span>)</td></tr>
                <tr><td>
                    <?php echo form_input(array('name' => 'price', 'size' => '30', 'maxlength' => '10', 'class'=>'number', 'value' => $price)); ?>
                    <?php echo $unit;?> / 
                    <?php echo $product_unit;?>
                </td></tr>
                <tr><td class="title">Chi tiết sản phẩm: (<span>*</span>)</td></tr>
                <tr><td><?php echo form_textarea(array('id' => 'content', 'name' => 'description', 'value' =>  ($description != '') ? $description : set_value('description'), 'class' => 'wysiwyg')); ?></td></tr>
            </table>
        </div>

        
        <div id="tab3" class="tab_content">
            <table>
            <tr><td class="title">Meta title: </td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'meta_title', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $meta_title)); ?></td>
            </tr>

            <tr><td class="title" style="vertical-align: top">Meta keywords:</td></tr>
            <tr>
                <td>
                    <?php echo form_textarea(array('name' => 'meta_keywords','size' => '50', 'maxlength' => '256', 'style' => 'width:560px; height: 80px;', 'value' => $meta_keywords)); ?>
                </td>
            </tr>

            <tr><td class="title" style="vertical-align: top">Meta description:</td></tr>
            <tr>
                <td>
                    <?php echo form_textarea(array('name' => 'meta_description','size' => '50', 'style' => 'width:560px; height: 80px;', 'value' => $meta_description)); ?>
                </td>
            </tr>

            <tr><td class="title">Tags:</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'product_tags', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $product_tags)); ?></td>
            </tr>
            <tr><td class="hint">Mỗi tag cách nhau bởi dấu phấy.</td></tr>
        </table>
    </div>
</div>
    <br class="clear">
    <div style="margin-top: 10px;"></div>
    <input type="submit" name="btnSubmit" value="<?php if(isset($button_name)) echo $button_name;?>" class="button" />
    <br class="clear">&nbsp;
</div>
<?php echo form_close(); ?>
