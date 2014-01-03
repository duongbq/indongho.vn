<div class="page_header">
    <h1 class="fleft">Thêm từ khóa</h1>
    <small class="fleft">"Thêm mới từ khóa"</small>
    <span class="fright">
        <a class="button back" href="/dashboard/keywords"><em>&nbsp;</em>Quay lại danh sách từ khóa</a>
    </span>
    <br class="clear"/>
</div>
<div class="form_content">
<?php echo form_open($submit_uri);?>
<table>
    <?php $this->load->view('common/message'); ?>
    <tr><td class="title">Từ khóa: (<span>*</span>)</td></tr>
    <tr>
        <td><?php echo form_input(array('name' => 'keyword', 'size' => '50', 'maxlength' => '256', 'style' => 'width:260px;', 'value' => isset($keyword) ? $keyword : set_value('keyword'))); ?></td>
    </tr>
    <tr><td class="title">Đường dẫn: (<span>*</span>)</td></tr>
    <tr>
        <td><?php echo form_input(array('name' => 'link', 'size' => '50', 'maxlength' => '500', 'style' => 'width:260px;', 'value' => isset($link) ? $link : set_value('link'))); ?></td>
    </tr>
    <tr><td class="title">Tiêu đề: </td></tr>
    <tr>
        <td><?php echo form_input(array('name' => 'title', 'size' => '50', 'maxlength' => '256', 'style' => 'width:260px;', 'value' => isset($title) ? $title : set_value('title'))); ?></td>
    </tr>
    <tr>
        <td>
            <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'button')); ?>
        </td>
    </tr>
</table>
<?php echo form_close();?>
</div>