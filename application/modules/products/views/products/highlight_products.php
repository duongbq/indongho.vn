<div class="block_item">
    <h3 class="title"><?php echo isset($title) ? $title : __('IP_Products'); ?></h3>
    <div class="content">
        <ul class="featured_products">
            <?php
            foreach ($highlight_products as $product):
                $image = is_null($product->image_name) ? 'no-image.png' : $product->image_name;
                $product_name = shorten_str($product->product_name, PRODUCT_NAME_MAXLENGTH_HOMEPAGE);
                $price = $product->price != 0 ? get_price_in_vnd($product->price) . ' ₫' : get_price_in_vnd($product->price);
                $uri = get_base_url() . url_title($product->category, 'dash', TRUE) . '-c' . $product->categories_id . '/' . get_uri_product($product->product_name, $product->id);
                ?>
                <li class="product_item">
                    <a href="<?php echo $uri; ?>"><img class="img" title="<?php echo $product->product_name; ?>" alt="<?php echo $product->product_name; ?>" src="/images/products/thumbnails/<?php echo $image; ?>"/></a>
                    <a class="title"  href="<?php echo $uri; ?>"><?php echo $product_name; ?></a>
                    <span class="price">giá : <strong><?php echo $price; ?></strong></span>
                </li>
                <?php 
           endforeach; ?>
        </ul>
    </div>
</div>