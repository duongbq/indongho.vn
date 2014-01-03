<div class="page_header">
    <div class="fleft"><h1>Thêm mới thư mẫu</h1></div>
    <span class="fright">
        <a href="/news-letter/templates" class="button back" style="padding:5px;" title="Quay lại trang quản lý"><em></em><span>Quay lại trang danh sách thư mẫu</span></a>
    </span>
    <br style="clear:both;">
</div>
<div class="form_content">
    <!--form open    -->
    <?php $this->load->view('duongbq/message'); ?>
    <?php echo form_open_multipart($submit_uri); ?>
    <table style="width:100%;margin-top: 10px;">
        <tr><td class="title">Tên thư mẫu (<span>*</span>)</td></tr>
        <tr>
            <td>
                <?php echo form_input(array('name' => 'name', 'value' => $name, 'size' => '30', 'maxlength' => 50));?>
            </td>
        </tr>
        <tr><td class="title">Hình minh họa </td></tr>
        <tr>
            <td><input type="file" name="userfile" size="33" /></td>
        </tr>
        <?php if($thumbnail != '' && $thumbnail != NULL):?>
            <tr>
                <td><img width="130" height="150" src="/images/templates/<?php echo $thumbnail;?>"></td>
            </tr>
        <?php endif;?>
        <tr><td class="title">Nội dung: (<span>*</span>)</td></tr>
        <tr>
            <td>
                <?php echo form_textarea(array('id' => 'content', 'name' => 'content', 'value' =>  ($content != '') ? $content : set_value('content'), 'class' => 'wysiwyg')); ?>
            </td>
        </tr>
        <?php if(modules::run('auth/auth/has_permission', array('operation' => OPERATION_ADMIN))):?>
        <tr><td class="title">Khách hàng: (<span>*</span>)</td></tr>
        <tr>
            <td>
                <?php if(isset($user_combo)) echo $user_combo;?>
            </td>
        </tr>
        <?php endif;?>
        <tr>
            <td style="padding-top: 5px;">
                <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name , 'class' => 'button'));?>
            </td>
        </tr>
        
    </table>

    <div class="clear" style="margin-bottom: 10px;"/></div>

    <?php echo form_close();?>
</div>
