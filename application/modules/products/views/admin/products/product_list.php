<?php
$this->load->view('admin/products/product_nav');
echo form_hidden('back_url', '/dashboard/products/');
?>
<div class="form_content">
     <?php 
        if(isset ($filter)) echo $filter;
        $this->load->view('admin/products/toggle_add_product_form');
     ?>
    
    <table class="list" style="width: 100%;">
        <tr>
            <th style="width:50%;" class="left" colspan="2">SẢN PHẨM</th>
            <th style="width:20%;" class="left">DANH MỤC</th>
            <th style="width:10%;">GIÁ TIỀN</th>
            <th style="width:1%">ĐƠN VỊ</th>
            <th style="width:10%;" class="center">NGÀY</th>
            <th style="width:5%;">XEM</th>
            <th style="width:5%;">HIỂN THỊ</th>
            <th style="width:15%;">CHỨC NĂNG</th>
        </tr>
        <?php
        foreach ($products as $index => $product):
            $product_id     = $product->id;
            $product_name   = $product->product_name;
            $warning        = strlen($product->image_name)==0 ? '<img src="/duongbq/images/warning.png"' : '';
            $uri            = $lang . '/' . url_title($product->category, 'dash', TRUE) . '-c' . $product->categories_id .'/'  . get_uri_product($product->product_name, $product->id);
            $price          = $product->price != 0 ? get_price_in_vnd($product->price) . 'đ' : get_price_in_vnd($product->price);
            $date           = get_vndate_string($product->updated_date);
            $style          = ($index % 2 == 0) ? 'even' : 'odd';
            $image          = '/images/products/smalls/' . ((strlen($product->image_name)==0) ? 'no-product.png' : $product->image_name);
            $image          = '<img src="' . $image . '" alt="' . $product->product_name . '" />';
            $check          = $product->status == ACTIVE_PRODUCT ? 'checked' : '';
            $product_unit   = ($product->unit != NULL && $product->unit != '') ? $product->unit : '';
            $functions      = '<a class="edit" href="/dashboard/products/edit/' . $product_id . '" title="Sửa thông tin sản phẩm"><em>&nbsp;</em></a>';
            $functions      .= '<a class="del" onclick="return confirm(\'Bạn có chắc chắn muốn xóa sản phẩm này không?\');" href="/dashboard/products/delete/' . $product_id . '" title="Xóa sản phẩm"><em>&nbsp;</em></a>';
            $functions      .= '<a class="up" href="/dashboard/products/up/' . $product_id . '" title="Cập nhật (up) sản phẩm lên đầu trang"/><em>&nbsp;</em></a>';

        ?>
        <tr class="<?php echo $style ?>">
            <td style="width:1%;"><?php echo $image; ?></td>
            <td class="bold left">
                <a href="<?php echo $uri; ?>"><?php echo $product_name;?></a> <span title="Sản phẩm chưa có hình ảnh sẽ không được hiển thị ra ngoài trang chủ"><?php echo $warning;?></span>
            </td>

            <td class="left" style="white-space:nowrap;">
                <?php if(isset($categories_array[$product->categories_id])) echo $categories_array[$product->categories_id];?>
            </td>
            <td class="left"><span class="red"><?php echo $price; ?></span></td>
            <td class="left"><?php echo $product_unit; ?></span></td>
            <td class="center"><?php echo $date; ?></td>
            <td class="center"><?php echo $product->viewed; ?></td>
            <td class="center"><input type="checkbox" <?php echo $check;?> onclick="change_product_status(<?php echo $product->id;?>)"></td>
            <td class="right"><?php echo $functions; ?></td>
        </tr>

    <?php endforeach; ?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng: ' . $total_rows . ' tin</span>)'; ?>
        <tr class="list-footer">
            <th colspan="9"><?php echo $left_page_links; ?></th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>

<?php if(isset($page_links) && $page_links!=='') echo '<div class="pagination" style="margin-left:20px;">' . $page_links . '</div>'; ?>