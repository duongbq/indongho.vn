<div class="filter">
    <?php echo form_open('dashboard/news/' . $this->phpsession->get('news_lang')); ?>
    Ngôn ngữ: <?php if (isset($lang_combobox)) echo $lang_combobox; ?>
    Từ khóa: <?php echo form_input(array('name' => 'search', 'id' => 'search', 'maxlength' => '256', 'value' => $search)); ?>
    
    Phân loại: <?php if (isset($categories_combobox)) echo $categories_combobox; ?>
    
    <input type="submit" name="submit" value="Tìm kiếm" class="button" />
    
    <?php echo form_close(); ?>
</div>
