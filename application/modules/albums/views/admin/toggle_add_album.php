<div style="overflow: hidden; display: none;" id="add_album">
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