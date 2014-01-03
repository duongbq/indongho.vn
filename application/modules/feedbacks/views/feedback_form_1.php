<?php echo form_open(get_url_by_lang($lang, 'send_testimonial')); ?>
<h2 class="title2"><?php echo __("IP_testimonial");?></h2>
<div class="content_block">
    <div class="content_v">
        <div class="form_content">
                <?php $this->load->view('duongbq/message'); ?>
            <table>
                <tr><td class="title"><?php echo __("IP_fullname");?>: (<span>*</span>)</td></tr>
                <tr><td><?php echo form_input(array('name' => 'name', 'size' => '35', 'maxlength' => '30', 'value' => set_value('name'))); ?></td></tr>
                <tr><td class="title"><?php echo __("IP_your_testimonial");?>: (<span>*</span>)</td></tr>
                <tr><td><?php echo form_textarea(array('name' => 'content','cols' => '59', 'rows'=>'10', 'value' => set_value('content'))); ?></td></tr>
                <tr><td class="title"><?php echo __("IP_captcha");?>: (<span>*</span>)</td></tr>
                <tr><td><?php echo form_input(array('name' => 'security_code', 'size' => '35', 'maxlength' => '10')); ?><br/><img src="/security_code"/></td></tr>
                <tr><td>
                    <input type="submit" name="btnSend" value="<?php echo __("IP_send_testimonial");?>" class="button" />
                </td></tr>
            </table>
        </div>
    </div>
</div>
<?php echo form_close(); ?>