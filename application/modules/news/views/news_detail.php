<div class="content">
    <?php
    if (isset($news) && count($news) > 0) {
        $date = get_vndate_string($news->created_date);
        $url = get_base_url() . url_title(trim($news->title), 'dash', TRUE) . '-' . $news->id;
        ?>
        <div class="news_detail">
            <h1 class="title"><?php echo $news->title; ?></h1>
            <div class="clear"></div>
            <div class="content_detail">
                <div class="news_date">
                    <?php echo __('IP_posted_date'); ?> : <strong><?php echo $date; ?></strong> | <strong><?php echo $news->viewed; ?></strong> <?php echo __('IP_viewed'); ?> 
                    <div style="float: right;">
                        <span class='st_facebook'></span>
                        <span class='st_twitter'></span>
                        <span class='st_plusone'></span>
                        <span class='st_fblike'></span>
                        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
                        <script type="text/javascript">stLight.options({publisher: "ur-640f3884-1525-bb55-10b-9688c93fdf4a"}); </script>
                    </div>
                </div>
                <?php echo $news->content; ?>
            </div>
            <?php
            if (isset($lastest_news))
                echo $lastest_news;

            echo '<div style="clear:both;"></div>';

            if (isset($older_news))
                echo $older_news;
            ?>
        </div>
        <div style="clear:both;"></div>
        <?php
    }
    ?>
</div>


