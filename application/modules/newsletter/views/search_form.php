<div class="date_filter">
<?php
$search = isset ($search) ? str_replace('\\', '', $search) : '';
?>

<?php
                echo form_open('/news-letter/emails');
                if(isset($group_combo)) echo $group_combo.'&nbsp;';
                echo form_input(array('name' => 'search', 'size' => 30, 'value' => $search)).'&nbsp;';
                echo form_submit(array('name'=>'btnSubmit', 'value'=>'Tìm kiếm', 'class'=>'button'));
                echo form_close();
                ?>
</div>