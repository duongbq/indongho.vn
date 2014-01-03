<?php
$uri = get_base_url() . url_title($product->category, 'dash', TRUE) . '-c' . $product->categories_id . '/' . get_uri_product($product->product_name, $product->id);
$price          = $product->price != 0 ? get_price_in_vnd($product->price) . 'đ' : get_price_in_vnd($product->price);
?>
<div class="product_detail">
<div id="product_img">
    <?php
        $thumbnails = '';
        foreach ($images as $image):
            $image_name = $image->image_name;
            if ($image->position == 1):
                ?>
                    <a rel="example_group" href="<?php echo base_url(); ?>images/products/<?php echo $image_name; ?>">
                        <img src="/images/products/<?php echo $image_name; ?>"/>
                    </a>
                <?php
            else:
                $thumbnails .= '<li><a rel="example_group" href="' . base_url() . 'images/products/' . $image_name . '">';
                $thumbnails .= '<img alt="' . $product->product_name . '" src="' . base_url() . 'images/products/thumbnails/' . $image_name . '"/>';
                $thumbnails .= '</a></li>';
            endif;
        endforeach;
        ?>
</div>
<ul class="description">
    <li><h1 class="title"><?php echo $product->product_name;?> </h1></li>
    <li>
            <table class="properties" style="width: 100%;">
                <tbody><tr>
                        <td>Mã sản phẩm <span>:</span></td>
                        <td class="blue">MS<?php echo $product->id;?></td>
                    </tr>
                    <tr>
                        <td>Giá <span>:</span></td>
                        <?php $product_unit = ($product->unit != NULL && $product->unit != '') ? '/' . $product->unit : ''?>
                        <td class="red"><?php echo $price;?><?php echo $product_unit;?></td>
                    </tr>
                    <tr>
                        <td>Nhóm sản phẩm <span>:</span></td>
                        <td class="blue"><?php echo $product->category;?></td>
                    </tr>
                    <tr>
                        <td>Lượt xem <span>:</span></td>
                        <td class="blue"><?php echo $product->viewed;?> lượt</td>
                    </tr>
                </tbody>
            </table>
    </li>
    <li>
        <ul class="product_images">
            <?php echo $thumbnails; ?>
        </ul> 
    </li>
</ul>
<div class="clear"></div>
<div class="content">
    <div class="product_info content_detail">
        <?php echo $product->description;?>
    </div>
</div>
<div class="clear"></div>
<?php
if (isset($products_related))
    echo $products_related;
?>
</div>