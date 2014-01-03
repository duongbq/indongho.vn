<div class="form_detail" style="margin-top: 5px;">
<h1 class="title"><?php echo __('IP_contact_title') ?></h1>
<?php echo $this->load->view('duongbq/message'); ?>
<div class="clear"></div>
<div class="content_detail form">
    <?php echo form_open($submit_uri); ?>
        <table style="float: left;padding-bottom: 10px;" class="table">
            <tbody>
                <tr>
                    <td class="right bold"><?php echo __("IP_fullname"); ?> : </td>
                    <td><input type="text" style="width: 300px;" maxlength="30" value="" name="name"> <span>*</span></td>
                </tr>
                <tr>
                    <td class="right bold"><?php echo __("IP_email"); ?> : </td>
                    <td><input type="text" maxlength="50" style="width: 300px;" value="" name="email"> <span>*</span></td>
                </tr>
                <tr>
                    <td class="right bold"><?php echo __("IP_phone"); ?> : </td>
                    <td><input type="text" maxlength="50" style="width: 300px;" value="" name="phone"> <span>*</span></td>
                </tr>
                <tr>
                    <td style="vertical-align: top" class="right bold"><?php echo __("IP_content"); ?> : </td>
                    <td><textarea style="height: 150px; width: 400px;" rows="10" cols="40" name="content"></textarea> </td>
                </tr>
                <tr>
                    <td class="right bold"><?php echo __("IP_capcha"); ?> : </td>
                    <td><input type="text" maxlength="10" size="35" value="" name="security_code"> <span>*</span>
                        <br><img src="/security_code" style="margin-left: 5px;margin-top: 5px;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="<?php echo __('IP_send_contact');?>" class="input_button blue_gradient">
                    </td>
                </tr>
            </tbody>
        </table>
    <?php echo form_close(); ?>
</div>
</div>