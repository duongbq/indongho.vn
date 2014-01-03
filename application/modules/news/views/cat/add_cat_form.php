<?php echo form_open($submit_uri); if (isset($cat_id)) echo form_hidden('cat_id', $cat_id);?>

<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm/sửa danh mục tin tức"</small>
    <span class="fright"><a href="/dashboard/news/categories/<?php echo $this->phpsession->get('news_cat_lang');?>" class="button back" style="padding:5px;" title="Quay lại trang quản lý danh mục tin tức"><em></em><span>Quay lại trang danh mục tin tức</span></a></span>
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
            <tr><td class="title">Ngôn ngữ: </td></tr>
            <tr>
                <td><?php if (isset($lang_combobox)) echo $lang_combobox; ?></td>
            </tr>
            <tr><td class="title">Tên loại: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'category', 'size' => '50', 'maxlength' => '256', 'style' => 'width:200px;', 'value' => isset ($category) ? $category : set_value('category'))); ?></td>
            </tr>

            <tr><td class="title">Thuộc loại: (<span>*</span>)</td></tr>
            <tr>
                <?php echo form_hidden('is_add_edit_category', TRUE);?>
                <?php echo form_hidden('form', 'news_cat');?>
                <td id="category"><?php if (isset($categories_combobox)) echo $categories_combobox; ?></td>
            </tr>
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
                    <?php echo form_textarea(array('name' => 'meta_keywords','size' => '50', 'maxlength' => '256', 'style' => 'width:560px; height: 80px;', 'value' => $meta_keywords)); ?>
                </td>
            </tr>

            <tr><td class="title" style="vertical-align: top">Meta description:</td></tr>
            <tr>
                <td>
                    <?php echo form_textarea(array('name' => 'meta_description','size' => '50', 'style' => 'width:560px; height: 80px;', 'value' => $meta_description)); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
    <br class="clear"/>
    <div style="margin-top: 10px;"></div>
    <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'button')); ?>
    <br class="clear"/>&nbsp;
</div>
<?php echo form_close(); ?>