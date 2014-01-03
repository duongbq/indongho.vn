<div class="slideshow">
    <ul>
        <?php
        foreach ($advs as $adv):
            $url_path = $adv->url_path == "#Click vào đây để thay đổi đường dẫn ảnh" ? "#" : $adv->url_path;
            $title = ($adv->title == NULL || $adv->title == 'Title') ? '' : $adv->title;
            ?>
            <li class="slide">
                <a href="<?php echo $url_path; ?>">
                    <img src="/images/advs/<?php echo $adv->image_name; ?>" border="0" alt="<?php echo $title; ?>" title="<?php echo $title;?>" />
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>