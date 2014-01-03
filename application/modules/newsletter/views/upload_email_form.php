<div class="page_header">
    <div class="fleft"><h1>Upload email</h1></div>
    <span class="fright">
        <a href="/news-letter/emails" class="button back" style="padding:5px;" title="Quay lại trang quản lý"><em></em><span>Quay lại trang quản lý</span></a>
    </span>
    <br style="clear:both;">
</div>
<div class="form_content">
    <!--form open    -->
    <?php $this->load->view('duongbq/message'); ?>
    <?php echo form_open_multipart('/news-letter/emails/upload');?>
    <table style="width:100%;margin-top: 10px;">
        <tr><td class="title">Chọn file: (<span>*</span>)</td></tr>
        <tr>
            <td><input type="file" name="userfile" size="20" /></td>
        </tr>
        <tr>
            <td style="padding-top: 5px;">
                <?php echo form_submit(array('name' => 'btnSubmit', 'value' => 'Upload' , 'class' => 'button'));?>
            </td>
        </tr>
    </table>

    <div class="clear" style="margin-bottom: 10px;"/></div>
    <?php echo form_close();?>
</div>
