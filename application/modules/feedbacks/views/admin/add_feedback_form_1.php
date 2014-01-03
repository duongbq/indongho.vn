<?php echo form_open($submit_uri); if (isset($id)) echo form_hidden('feedback_id', $id); ?>

<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm/sửa ý kiến phản hồi"</small>
    <span class="fright"><a class="button back" href="/dashboard/feedbacks/<?php echo $this->phpsession->get('feedback_lang')?>" title="Quay lại trang quản lý ý kiến phản hồi"><em>&nbsp;</em>Quay lại trang quản lý</a></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('duongbq/message'); ?>
        <table>
        <tr><td class="title">Ngôn ngữ: (<span>*</span>)</td></tr>
        <tr>
            <td><?php if (isset($lang_combobox)) echo $lang_combobox; ?></td>
        </tr>
        <tr><td class="title">Tên khách hàng: (<span>*</span>)</td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'customer', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $customer)); ?></td>
        </tr>
        <tr><td class="title" style="vertical-align: top">Ý kiến phản hồi: (<span>*</span>)</td></tr>
        <tr>
            <td>
                <?php echo form_textarea(array('name' => 'content', 'value' => ($content != '') ? $content : set_value('content'))); ?>
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
        <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'button')); ?>
        <?php echo form_reset(array('name' => 'btnReset', 'value' => 'Làm lại', 'class' => 'button')); ?>
        <br class="clear"/>&nbsp;
</div>
<?php echo form_close(); ?>