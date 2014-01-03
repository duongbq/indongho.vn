<div  class="date_filter" style="overflow: hidden; display: none;" id="upload_email">
        <?php echo form_open_multipart('/news-letter/emails/upload');?>

        <table>
            <tr><td class="title">Chọn file: (<span>*</span>)</td></tr>
            <tr>
                <td><input type="file" name="userfile" size="20" /></td>
            </tr>
            <tr>
                <td style="padding-top: 5px;">
                    <?php echo form_submit(array('name' => 'btnSubmit', 'value' => 'Upload', 'class' => 'button')); ?>
                </td>
            </tr>
        </table>

        <?php echo form_close();?>
</div>
<br/>