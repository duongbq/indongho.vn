<?php
foreach($images as $index => $row)
{
    $images_url     = is_null($row->image_name) ? 'no-image.png' : $row->image_name;
    $id             = $row->id;
    echo <<< eob
            <div class="t-wrapper" id="id_{$id}">
            <div class="t-square">
                <span>
                    <a class="delete_me close" href="javascript:void(0);" onclick="delete_products_images($id)"><em>&nbsp;</em></a>
                </span>
                <div class="t-img">
                    <em style="background-size:130px; background-image: url('/images/products/thumbnails/{$images_url}');"></em>
                </div>
            </div>
        </div>
eob;
}
echo '<br style="clear:both;"/>';
?>