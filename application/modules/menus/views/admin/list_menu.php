<?php
echo form_open('', array('id' => 'menu_form'), array('menu_id' => 0, 'IS_FROM_LIST' => TRUE));
if(isset($back_url)) echo form_hidden('back_url', $back_url);
echo form_close();
if($this->phpsession->get('menu_type') == FRONT_END_MENU)
    echo form_hidden('back_url', '/dashboard/menu/');
else
    echo form_hidden('back_url', '/dashboard/menu-admin/');
?>
<div class="page_header">
    <h1 class="fleft"><?php echo $page_title; ?></h1>
    <small class="fleft">"Thay đổi menu trang web của bạn"</small>
    <!--<span class="fright"><a class="button save" href= "/dashboard/menu/save-cache"><em>&nbsp;</em>Lưu cache</a></span>-->
    <span class="fright"><a class="button add" href= "/dashboard/menu/add"><em>&nbsp;</em>Thêm menu</a></span>
    <br class="clear"/>
</div>
<div class="form_content">
    <?php $this->load->view('admin/change_language_bar'); ?>
    <div id="sort_menu" class="sortable">
    <?php
        $this->load->view('duongbq/message');
        if(isset($list_menus)) echo $list_menus;
    ?>
    </div>
    <br class="clear"/>&nbsp;
</div>