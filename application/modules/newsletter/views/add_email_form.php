<div class="page_header">
    <div class="fleft"><h1>Nhập email khách hàng</h1></div>
    <span class="fright">
        <a href="/news-letter/emails" class="button back" style="padding:5px;" title="Quay lại trang quản lý"><em></em><span>Quay lại trang quản lý</span></a>
    </span>
    <br style="clear:both;">
</div>
<div class="form_content">
    <!--form open    -->
    <?php $this->load->view('duongbq/message'); ?>
    <?php echo form_open($submit_uri); ?>
    <table style="width:100%;margin-top: 10px;">
        <tr><td class="title">Họ và tên (<span>*</span>)</td></tr>
        <tr>
            <td>
                <?php echo form_input(array('name' => 'name', 'value' => $name, 'size' => '30', 'maxlength' => 256));?>
            </td>
        </tr>
        <tr><td class="title">Tên thường gọi (<span>*</span>)</td></tr>
        <tr>
            <td>
                <?php echo form_input(array('name' => 'alias', 'value' => $alias, 'size' => '30', 'maxlength' => 100));?>
            </td>
        </tr>
        
        <tr><td class="title">Email (<span>*</span>)</td></tr>
        <tr>
            <td>
            <?php echo form_input(array('name' => 'email', 'value' => $email, 'size' => '30', 'maxlength' => 256));?>
            </td>
        </tr>

        <tr><td class="title">Điện thoại </td></tr>
        <tr><td>
            <?php echo form_input(array('name' => 'phone', 'value' => $phone, 'size' => '30', 'maxlength' => 15)); ?>
        </td>
        </tr>

        <tr><td class="title">Chức vụ </td></tr>
        <tr><td><?php echo form_input(array('name' => 'position', 'value' => $position, 'size' => '30', 'maxlength' => 256)); ?></td>
        </tr>
        
        <tr><td class="title">Cách xưng hô </td></tr>
        <tr><td><?php echo form_input(array('name' => 'call', 'value' => $call, 'size' => '30', 'maxlength' => 256)); ?></td>
        </tr>
        
        <tr><td class="title">Thuộc nhóm (<span>*</span>)</td></tr>
        <tr><td><?php if(isset($group_combo)) echo $group_combo;?></td>
        </tr>
        
        <tr>
            <td style="padding-top: 5px;">
                <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name , 'class' => 'button'));?>
            </td>
        </tr>
        
    </table>

    <div class="clear" style="margin-bottom: 10px;"/></div>

    <?php echo form_close();?>
</div>
