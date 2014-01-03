<?php if (count($products) > 0): ?>
<div class="products">
    <h1 class="title" style="margin-left: 10px;"><?php echo $title; ?></h1>
    <ul>
        <?php
            foreach ($products as $product):
                $this->load->view('products/products/product_item', array('product' => $product));
            endforeach;
            ?>
    </ul>
    <?php echo isset($pagination) ? '<div class="pagination">' . $pagination . '</div>' : '';?>
</div>
<?php endif; ?>