<div class="page_header">
        <div class="fleft"><h1>Thông tin thư gửi</h1></div>
        <br style="clear:both;">
</div>
<div class="form_content">
    <div>
    <table class="list" style="width: 100%;">
    <tr>
        <td>Tiêu đề</td>
        <td><?php echo $title;?></td>
    </tr>
    <tr>
        <td>Nội dung</td>
        <td>
            <?php echo $content;?>
        </td>
    </tr>
    <tr>
        <td><input type="hidden" name="email_id" value="<?php echo $email_id;?>"/></td>
        <td>
            <input type="button" value="Gửi thư" onclick="prepare_send_email();"/>
            &nbsp;
            <span id="msg" style="color: red;">&nbsp;</span>
        </td>
    </tr>
    </table>
    </div>
</div>
<br/>
<div class="page_header">
        <div class="fleft"><h1>Danh sách các email</h1></div>
        <br style="clear:both;">
</div>
<div  class="data_table bold">
    <table id="table_email" class="list" style="width: 100%;">
        <tr>
            <th class="left" style="width:25%;">Họ tên</th>
            <th class="left" style="width:2%;">Tên</th>
            <th class="left" style="width:25%;">Email</th>
            <th class="left" style="width:5%;">Điện thoại</th>
            <th class="left" style="width:10%;">Chức vụ</th>
            <th class="left" style="width:10%;">Cách xưng hô</th>
            <th style="width:12%;" class="center">Trạng thái</th>
        </tr>
    </table>
</div>