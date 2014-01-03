<div class="services">
    <?php foreach($advs as $adv):?>
        <?php
            $url_path = $partner->url_path == "#Click vào đây để thay đổi đường dẫn ảnh" ? '#' : $partner->url_path;
            $title = ($adv->title == NULL || $adv->title == 'Title') ? '' : $adv->title;
        ?>
    <div class="grid_4">
        <a href="<?php echo $url_path;?>">
            <img src="<?php echo base_url();?>images/advs/<?php echo $adv->image_name;?>" border="0" alt="<?php echo $title;?>" title="<?php echo $title;?>" />
        </a>
    </div>
    <?php endforeach;?>
</div>