<?php echo $this->load->view('duongbq/admin_header', NULL, TRUE); ?>

<div class="header">
    <div class="container">
        <?php if(isset($admin_menu))echo $admin_menu;?>
    </div>
    <br class="clear"/>
</div>

<div class="container">
    <div class="content_container">
        <?php
            if(isset($url)) echo form_hidden('url', $url);
            if (isset($main_content)) echo $main_content; else echo '&nbsp;';
        ?>
    </div>
    <br class="clear"/>
</div>

<?php echo $this->load->view('duongbq/admin_footer', NULL, TRUE); ?>