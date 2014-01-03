<div class="featured_products">
    <div class="hp_title">
        <a href="#"><?php echo __('IP_feature_products');?></a>
    </div>
    <ul>
        <?php
            foreach ($products as $product):
                $image = is_null($product->image_name) ? 'no-image.png' : $product->image_name;
                $product_name = shorten_str($product->product_name, PRODUCT_NAME_MAXLENGTH_HOMEPAGE);
                $price = $product->price != 0 ? get_price_in_vnd($product->price) . ' ₫' : get_price_in_vnd($product->price);
                $uri = get_base_url() . url_title($product->category, 'dash', TRUE) . '-c' . $product->categories_id . '/' . get_uri_product($product->product_name, $product->id);
                $product_unit   = ($product->unit != NULL && $product->unit != '') ? '/'.$product->unit : '';
                ?>
                <li class="product_item">
                    <a href="<?php echo $uri; ?>"><img class="img" title="<?php echo $product->product_name; ?>" alt="<?php echo $product->product_name; ?>" src="/images/products/<?php echo $image; ?>"/></a>
                    <a class="title" href="<?php echo $uri; ?>"><?php echo $product_name; ?></a>
                    <span class="price">Giá : <strong><?php echo $price; ?></strong><?php echo $product_unit;?></span>
                </li>
            <?php endforeach; ?>
        
    </ul>
</div>