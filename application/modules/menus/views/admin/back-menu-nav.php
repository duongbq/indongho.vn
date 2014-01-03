<span class="fright">
    <?php if($this->phpsession->get('menu_type') == FRONT_END_MENU):?>
    <a class="button back" href="/dashboard/menu/<?php echo isset($lang) && $lang != '' ? $lang :$this->phpsession->get('current_menus_lang'); ?>"><em>&nbsp;</em>Quay lại trang Menu</a>
    <?php endif;?>
    <?php if($this->phpsession->get('menu_type') == BACK_END_MENU):?>
    <a class="button back" href="/dashboard/menu-admin/<?php echo isset($lang) && $lang != '' ? $lang :$this->phpsession->get('current_menus_lang'); ?>" ><em>&nbsp;</em>Quay lại trang Menu</a>
    <?php endif;?>
</span>