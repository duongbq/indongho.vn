<?php
foreach($images as $index => $row)
{
    $id             = $row->id;
    $check = $row->status == ACTIVE_ADV ? 'checked' : '';
    $checkbox = '<input type="checkbox"' . $check . ' onclick="change_album_images_status(' . $row->id . ')">';
    $images = base_url() . 'images/albums/thumbnails/' . $row->image_name;
    $title = $row->title != NULL ? '<a id="' . $row->id . '" class="album_img_title" style="display: inline;">' . $row->title . '</a>|' : '';
    echo <<< eob
        <li id="id_{$row->id}">
            <img src="{$images}" alt="no image"/>
            {$title}
            <a id="{$row->id}" class="album_img_link" style="display: inline;">{$row->url_path}</a>
            <div class="fright" >
            {$checkbox}
            <a class="del" title ="Xóa quảng cáo này" href="javascript:void(0);" onclick="delete_album_images({$row->id});"><em></em></a>
            </div>
        </li>
eob;
}
?>