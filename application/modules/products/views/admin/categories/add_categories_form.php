<!--<div style="width:100%;">-->
<?php
echo form_open($submit_uri);
if(isset($cat_id))echo form_hidden('cat_id', $cat_id);
if(isset($parent_id))echo form_hidden('parent_id', $parent_id);?>

<div class="page_header">
    <h1 class="fleft">Thêm/sửa danh mục</h1>
    <small class="fleft">"Thêm hoặc sửa danh mục trong danh sách"</small>
    <span class="fright"><?php $this->load->view('admin/categories/back-cat-nav'); ?></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('duongbq/message'); ?>
    <ul class="tabs">
            <li><a href="#tab1">Nội dung</a></li>
            <li><a href="#tab2">Meta data</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <table>
                <tr><td class="title">Ngôn ngữ: (<span>*</span>)</td></tr>
                <tr><td><?php if(isset($lang_combobox)) echo $lang_combobox; ?></td></tr>
                <tr><td class="title">Tên danh mục: (<span>*</span>)</td></tr>
                <tr><td><?php echo form_input(array('name' => 'cat_name', 'size' => '35', 'maxlength' => '45', 'value' => isset ($cat_name) ? $cat_name : set_value('cat_name'))); ?></td></tr>
                <tr><td class="title">Css:</td></tr>
                <tr><td><?php echo form_input(array('name' => 'css', 'size' => '35', 'value' => isset ($css) ? $css : set_value('css'))); ?></td></tr>
                <tr><td class="title">Thuộc loại: (<span>*</span>)</td></tr>
                <tr>
                    <?php echo form_hidden('is_add_edit_category', TRUE);?>
                    <?php echo form_hidden('form', 'product_cat');?>
                    <td id="category">
                    <?php if(isset($cat_combo)) echo $cat_combo;?>
                </td></tr>
            </table>
        </div>
        <div id="tab2" class="tab_content">
            <table>
                <tr><td class="title">Meta title: </td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'meta_title', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $meta_title)); ?></td>
                </tr>

                <tr><td class="title" style="vertical-align: top">Meta keywords:</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('name' => 'meta_keywords', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px; height: 80px;', 'value' => $meta_keywords)); ?>
                    </td>
                </tr>

                <tr><td class="title" style="vertical-align: top">Meta description:</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('name' => 'meta_description', 'size' => '50', 'style' => 'width:560px; height: 80px;', 'value' => $meta_description)); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br class="clear"/>
    <div style="padding-top: 10px;"></div>
    <input type="submit" name="submit" value="<?php echo $button_name;?>" class="button" />
    <br class="clear"/>&nbsp;
</div>
