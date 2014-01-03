<?php if(count($products)>0):?>
<div class="related_products">
    <strong>Sản phẩm cùng loại</strong>
    <?php $id_related = count($products) > 4 ? ' id="related_products"' : '';?>
    <ul<?php echo $id_related;?>>
    <?php foreach($products as $product):?>
    <?php
    $image = is_null($product->image_name) ? 'no-image.png' : $product->image_name;
    $product_name = shorten_str($product->product_name, PRODUCT_NAME_MAXLENGTH);
    $uri = get_base_url() . url_title($product->category, 'dash', TRUE) . '-c' . $product->categories_id . '/' . get_uri_product($product->product_name, $product->id);
    ?>
    <li class="product_item">
        <a href="<?php echo $uri; ?>">
            <img class="img" src="/images/products/<?php echo $image; ?>" title="<?php echo $product->product_name; ?>" alt="<?php echo $product->product_name; ?>"/>
            <h4><?php echo $product_name;?></h4>
        </a>
    </li>
    <?php endforeach;?>
    </ul>
</div>
<?php endif;?>
