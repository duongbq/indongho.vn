<?php
$lang = switch_language($this->uri->segment(1));
$news_link = get_url_by_lang($lang, 'news');
?>
<div class="news">
    <div class="hp_title">
        <a href="#"><?php echo __('IP_Lastest_news');?></a>
    </div>
    <ul>
        <?php
            if (isset($news) && count($news) > 0) :
                foreach ($news as $item) {
                    $thumbnail      = ($item->thumbnail != '') ? $item->thumbnail : '/images/noimage.jpg';
                    $uri            = get_base_url() . url_title(trim($item->category), 'dash', TRUE) . '/' . url_title(trim($item->title), 'dash', TRUE) . '-n' . $item->cat_id . '-' . $item->id;
                    $created_date   = date('d/m/Y',strtotime($item->created_date));
                    ?>
                    <li>
                        <div class="image">
                            <a href="<?php echo $uri; ?>"><img title="<?php echo $item->title; ?>" alt="<?php echo $item->title; ?>" src="<?php echo $thumbnail;?>" /></a>
                        </div>
                        <div class="meta">
                            <a href="<?php echo $uri; ?>"><strong><?php echo $item->title; ?></strong></a>
                            <p><?php echo $item->summary; ?><p>
                            <a href="<?php echo $uri; ?>" class="read_more"><?php echo __('IP_detail');?> ...</a>
                        </div>
                    </li>
                    <?php
                }
            endif;
            ?>
        
    </ul>
</div>