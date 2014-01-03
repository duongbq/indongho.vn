<div class="left_customers">
    <ul>
        <?php
        foreach ($advs as $adv):
            $url_path = $adv->url_path == "#Click vào đây để thay đổi đường dẫn ảnh" ? "#" : $adv->url_path;
            ?>
            <li>
                <a href="<?php echo $url_path; ?>"><img src="/images/advs/<?php echo $adv->image_name; ?>"/></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
