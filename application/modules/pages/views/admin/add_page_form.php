<?php echo form_open($submit_uri); if (isset($id)) echo form_hidden('page_id', $id); ?>
<?php
$title          = isset($title) ? $title : '';
$created_date   = isset($created_date) ? $created_date : '';
$submit_uri     = isset($submit_uri) ? $submit_uri : '';
?>
<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm/sửa trang tĩnh"</small>
    <span class="fright"><a class="button back" href="/dashboard/pages" title="Quay lại trang quản lý page"><em>&nbsp;</em>Quay lại trang quản lý</a></span>
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
            <tr><td class="title">Tên trang: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'title', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $title)); ?></td>
            </tr>
            <tr><td class="title">Đường dẫn: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'uri', 'size' => '50', 'style' => 'width:560px;', 'value' => $uri)); ?></td>
            </tr>
            <tr><td class="title"  style="vertical-align: top">Tóm tắt nội dung: (<span>*</span>)</td></tr>
            <tr>
                <td>
                    <?php echo form_textarea(array('id' => 'summary', 'name' => 'summary', 'cols' => '90', 'rows' => '3', 'style' => 'width:560px;', 'value' => $summary, 'class' => 'wysiwyg')); ?>
                </td>
            </tr>
            <tr><td class="title" style="vertical-align: top">Nội dung: (<span>*</span>)</td></tr>
            <tr>
                <td>
                    <?php echo form_textarea(array('id' => 'content', 'name' => 'content', 'value' => ($content != '') ? $content : set_value('content'), 'class' => 'wysiwyg')); ?>
                </td>
            </tr>
            <tr><td class="title">Ngày đăng: (<span>*</span>)</td></tr>
            <tr>
                <td>
                    <?php echo form_input(array('id' => 'news_created_date', 'name' => 'created_date', 'size' => '50', 'maxlength' => '10', 'value' => $created_date)); ?>
                    <span style="color:#999;">(định dạng: dd-mm-yyyy)</span>
                </td>
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

                <tr><td class="title">Tags: (mỗi tag cách nhau bởi dấu phấy)</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'tags', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $tags)); ?></td>
                </tr>
            </table>
        </div>
        
        <br class="clear"/>
        <div style="margin-top: 10px;"></div>
        <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'button')); ?>
        <br class="clear"/>&nbsp;
    </div>
</div>
<?php echo form_close(); ?>