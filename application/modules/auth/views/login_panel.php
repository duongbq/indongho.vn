<div style="float:right;">
<?php if (modules::run('auth/auth/is_logged_in')): ?>
<ul class="nav">
    <li><a href="/dashboard"><?php echo $this->phpsession->get('fullname');?></a></li>
    <li><a href="/thoat"><?php echo __('IP_log_out');?></a></li>
</ul>
<?php else: ?>
<ul class="nav">
    <li><a href="/dang-nhap"><?php echo __('IP_log_in');?></a></li>
</ul>
<?php endif; ?>
</div>