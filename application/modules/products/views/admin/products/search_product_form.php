<div class="filter">
    <form method="post" action ="/dashboard/products/<?php echo $this->phpsession->get('product_lang');?>">
        Ngôn ngữ: <?php if (isset($lang_combobox)) echo $lang_combobox; ?>
        
        Tìm kiếm:<input name="product_name" value="<?php echo str_replace('\\', '', $search); ?>" />
        
        <?php if(isset($categories_combo)) echo $categories_combo; ?>
        
        <input type="Submit" name ="btnSearch" value="Tìm kiếm" class="button"/>
        
    </form>
</div>