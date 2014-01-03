<div class="grid_18 omega fright user_menus">
    <ul class="fright">
        <?php if (modules::run('auth/auth/is_logged_in')): ?>
            <li><a href="/dashboard"><?php echo __('IP_cpanel');?></a></li>
            <li><a href="/thoat"><?php echo __('IP_log_out'); ?></a></li>
        <?php else: ?>
            <li><a href="/dang-nhap" rel="nofollow"><?php echo __('IP_log_in'); ?></a></li>
        <?php endif; ?>
    </ul>
</div>
