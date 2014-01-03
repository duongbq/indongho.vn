<h1 class="block_title"><?php echo $album_name;?></h1>
<ul class="album_detail">
    <?php foreach ($images as $image):?>
        <li>
            <a rel="example_group" href="/images/albums/<?php echo $image->image_name;?>">
                <img alt="" src="/images/albums/thumbnails/<?php echo $image->image_name;?>">
            </a>
        </li>
    <?php endforeach;?>
</ul>