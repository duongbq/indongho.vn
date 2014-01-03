<div class="form_detail" style="margin-top: 5px;">
    <h1 class="title"><?php echo __('IP_log_in') ?></h1>
    <?php echo $this->load->view('duongbq/message'); ?>
    <div class="clear"></div>
    <?php echo form_open($submit_uri); ?>
    <div class="content_detail form">
        <table class="table">
            <tbody>
                <tr>
                    <td class="right bold"><?php echo __("IP_user_name"); ?>: (<span>*</span>)</td>
                    <td><?php echo form_input(array('name' => 'username', 'size' => '40', 'maxlength' => '30', 'value' => set_value('username'))); ?></td>
                </tr>
                <tr>
                    <td class="right bold"><?php echo __("IP_password"); ?>: (<span>*</span>)</td>
                    <td><?php echo form_password(array('name' => 'password', 'size' => '40', 'maxlength' => '50', 'value' => set_value('password'))); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="<?php echo __("IP_log_in"); ?>" class="input_button blue_gradient"/></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php echo form_close(); ?>
</div>