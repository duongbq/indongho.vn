<?php
$uri = get_base_url() . url_title(trim($new->category), 'dash', TRUE) . '/' . url_title(trim($new->title), 'dash', TRUE) . '-n' . $new->cat_id . '-' . $new->id;
$thumbnail = ($new->thumbnail != '') ? $new->thumbnail : '/images/noimage.jpg';
?>

<li>
    <div class="image">
        <a href="<?php echo $uri; ?>"><img src="<?php echo $thumbnail; ?>"/></a>
    </div>
    <div class="meta">
        <a href="<?php echo $uri; ?>"><strong><?php echo $new->title; ?></strong></a>
        <p><?php echo $new->summary; ?><p>
        <a href="<?php echo $uri; ?>" class="read_more"><?php echo __('IP_detail');?> ...</a>
    </div>
</li>