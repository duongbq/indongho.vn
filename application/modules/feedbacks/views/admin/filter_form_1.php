<div class="filter">
    <?php echo form_open('dashboard/feedbacks/' . $this->phpsession->get('feedback_lang')); ?>
    Ngôn ngữ: <?php if (isset($lang_combobox)) echo $lang_combobox; ?>
    Từ khóa: <?php echo form_input(array('name' => 'search', 'id' => 'search', 'maxlength' => '256', 'value' => $search)); ?>
    <input type="submit" name="submit" value="Tìm kiếm" class="button" />

    <?php echo form_close(); ?>
    <br class="clear"/>&nbsp;
</div>
