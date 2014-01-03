<div style="display: none;" id="add_keyword">
    <?php echo form_open('/dashboard/keywords/add');?>
    <table>
        <tr><td class="title">Từ khóa: (<span>*</span>)</td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'keyword', 'size' => '50', 'maxlength' => '256', 'style' => 'width:260px;', 'value' => set_value('keyword'))); ?></td>
        </tr>
        <tr><td class="title">Đường dẫn: (<span>*</span>)</td></tr>
         <tr>
            <td><?php echo form_input(array('name' => 'link', 'size' => '50', 'maxlength' => '500', 'style' => 'width:260px;', 'value' => set_value('link'))); ?></td>
        </tr>
        <tr><td class="title">Tiêu đề: </td></tr>
        <tr>
            <td><?php echo form_input(array('name' => 'title', 'size' => '50', 'maxlength' => '256', 'style' => 'width:260px;', 'value' => set_value('title'))); ?></td>
        </tr>
        <tr>
            <td>
                <?php echo form_submit(array('name' => 'btnSubmit', 'value' => 'Thêm', 'class' => 'button')); ?>
            </td>
        </tr>
    </table>
    <?php echo form_close();?>
</div>