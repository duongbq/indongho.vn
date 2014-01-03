<div class="customers">
    <fieldset>
        <legend><?php echo __('IP_Customers'); ?></legend>
        <div style="width: 985px; overflow: hidden;float: left;">
            <ul id="slide_list" class="slide_list">
                <?php
                foreach ($albums as $album):
                    $uri = '/khach-hang';
                    ?>
                    <li>
                        <a href="<?php echo $uri; ?>"><img src="/images/albums/<?php echo $album->image_name; ?>"/></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </fieldset>
</div>