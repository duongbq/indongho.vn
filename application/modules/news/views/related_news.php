<?php
if (isset($news) && count($news) > 0)
{
    echo '<div class="related_post">';
    if(isset($title)) echo '<h3>' . $title . '</h3>';
    echo '<ul>';
    foreach($news as $index => $new)
    {
        $news_uri   = get_base_url() . url_title(trim($new->category), 'dash', TRUE). '/' . url_title(trim($new->title), 'dash', TRUE) . '-n' . $new->cat_id . '-' . $new->id;
        $date       = (date('d.m.Y', strtotime($new->created_date)));

        echo '<li><a href=" ' . $news_uri . '">' . $new->title . '<span> ('. $date . ')</span></a></li>';
    }
    echo '</ul></div>';
}
?>