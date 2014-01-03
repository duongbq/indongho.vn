<div class="side_item">
    <h2><?php echo isset($title) ? $title : __('IP_Products'); ?></h2>
    <div class="content">
        <ul class="feature_products">
            <?php
            foreach ($most_viewed_products as $index => $product) :

                $image          = is_null($product->image_name) ? 'no-image.png' : $product->image_name;
                $price          = get_full_price_in_vnd($product->price) . ' ₫';
                $product_name   = $product->product_name;
                $uri            = get_base_url() . url_title($product->category, 'dash', TRUE) . '-c' . $product->categories_id . '/' . get_uri_product($product->product_name, $product->id);
                ?>
                <li>
                    <a href="<?php echo $uri; ?>" title="<?php echo $product_name;?>">
                        <img src="<?php echo '/images/products/thumbnails/' . $image; ?>" title="<?php echo $product_name;?>" alt="<?php echo $product_name;?>"/>
                        <p>
                            <?php echo shorten_str($product->product_name, PRODUCT_NAME_MAXLENGTH);; ?>
                            <span><?php echo __('IP_price');?> : <strong><?php echo $price;?></strong></span>
                        </p>
                    </a>
                </li>
                <?php
            endforeach;
            ?>
        </ul>
    </div>
</div>