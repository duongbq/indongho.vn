<div class="page_header" id="form">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm album mới"</small>
    <span class="fright">
        <a class="button back" href="/dashboard/albums"><em>&nbsp;</em>Quay lại danh sách album</a>
    </span>
    <br class="clear"/>
</div>
<div class="form_content" id="form_add">
<?php echo form_open('/dashboard/albums/add');?>

<table>
    <?php $this->load->view('duongbq/message'); ?>
    <tr><td class="title">Tên album: (<span>*</span>)</td></tr>
    <tr>
        <td><?php echo form_input(array('name' => 'album_name', 'size' => '50', 'maxlength' => '256', 'style' => 'width:260px;', 'value' => set_value('album_name'))); ?></td>
    </tr>
    <tr>
        <td>
            <?php echo form_submit(array('name' => 'btnSubmit', 'value' => 'Thêm', 'class' => 'button')); ?>
        </td>
    </tr>
</table>

<?php echo form_close();?>
</div>
