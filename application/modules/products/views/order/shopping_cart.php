<div class="content form">
    <table id="cart_summary" style="width: 100%;" class="table t_gray">
        <?php if ($this->cart->total_items() != 0): ?>
            <thead>
                <tr>
                    <td style="width: 5%">Ảnh</td>
                    <td>Sản phẩm</td>
                    <td>Đơn giá</td>
                    <td>Số lượng</td>
                    <td>Thành tiền</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $carts = $this->cart->contents();
                foreach ($carts as $cart):
                    $uri = get_base_url() . url_title($cart['cat_name'], 'dash', TRUE) . '-c' . $cart['cat_id'] . '/' . get_uri_product($cart['name'], $cart['id']);
                    ?>
                    <tr>
                        <td style="vertical-align: center;">
                            <a style="float: left;" href="<?php echo $uri; ?>"><img src="/images/products/smalls/<?php echo $cart['images']; ?>"/></a>
                        </td>
                        <td>
                            <a class="product_link" href="<?php echo $uri; ?>"><?php echo $cart['name']; ?></a>
                        </td>
                        <td>
                            <span class="price"><?php echo get_price_in_vnd($cart['price']) . ' ₫'; ?></span>
                        </td>
                        <td>
                            <input type="text" name="<?php echo $cart['rowid']; ?>" maxlength="2" size="2" value="<?php echo $cart['qty']; ?>" onchange="update_quantity('<? echo $cart['rowid']; ?>');">
                            <a rel="nofollow" href="javascript:void(0);" onclick="remove_product_in_cart('<?php echo $cart['rowid']; ?>');" title="Xóa sản phẩm này khỏi giỏ hàng">
                                <img src="/images/delete-cart.gif" alt="Delete" class="icon">
                            </a>
                        </td>
                        <td>
                            <span class="price"><?php echo get_price_in_vnd($cart['subtotal']) . ' ₫'; ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        Tổng cộng:
                    </td>
                    <td class="total_price"><?php echo get_price_in_vnd($this->cart->total()) . ' ₫'; ?> </td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;" class="total_price"><?php echo DocTienBangChu($this->cart->total()); ?> </td>
                </tr>
            </tfoot>
        <?php else: ?>
            <tr><td colspan="6" style="text-align: center;">Giỏ hàng trống</td></tr>
        <?php endif; ?>
    </table>
    <?php if ($this->cart->total_items() != 0): ?>
        <div class="bottom_button" style="width: 100%; float: left;">
            <a href="/san-pham" class="button green_hover">Tiếp tục mua hàng</a>
        </div>
    <?php endif; ?>
    <br class="clear-both"/>
    <br class="clear-both"/>
    <br class="clear-both"/>
</div>
<?php if ($this->cart->total_items() != 0): ?>
    <?php $this->load->view('duongbq/message'); ?>
    <div class="content form" style="margin-top: 15px; float:left;">
        <h3 class="title" style="margin-bottom: 10px;" >Thông tin người mua hàng và nhận hàng</h3>
        <?php echo form_open('/gio-hang'); ?>
        <table class="table">
            <tbody>
                <tr>
                    <td><?php echo __("IP_fullname"); ?> : </td>
                    <td><?php echo form_input(array('name' => 'fullname', 'maxlength' => '30', 'style' => "width: 300px;", 'value' => $fullname)); ?> <span>*</span></td>
                </tr>
                <tr>
                    <td><?php echo __("IP_phone"); ?> : </td>
                    <td><?php echo form_input(array('name' => 'phone', 'style' => "width: 300px;", 'maxlength' => '50', 'value' => $phone)); ?> <span>*</span></td>
                </tr>
                <tr>
                    <td><?php echo __("IP_email"); ?> : </td>
                    <td><?php echo form_input(array('name' => 'email', 'style' => "width: 300px;", 'maxlength' => '50', 'value' => $email)); ?> <span>*</span></td>
                </tr>
                <tr>
                    <td><?php echo __("IP_address"); ?> : </td>
                    <td>
                        <?php if (isset($city)) echo $city ?> &nbsp; <span id="district"><?php if (isset($district)) echo $district ?></span>
                        <br/><br/>
                        <?php echo form_input(array('name' => 'address', 'style' => "width: 300px;", 'maxlength' => '50', 'value' => $address)); ?> <span>*</span>
                    </td>
                </tr>
                <tr>
                    <td>Thông tin khác : </td>
                    <td><?php echo form_textarea(array('name' => 'content', 'style' => "height: 150px; width: 400px;", 'value' => set_value('content'))); ?></td>
                </tr>
                <tr>
                    <td>Mã an toàn : </td>
                    <td><?php echo form_input(array('name' => 'security_code', 'size' => '35', 'maxlength' => '10')); ?> <span>*</span>
                        <br/><img style="margin-left: 5px;margin-top: 5px;" src="/security_code"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input style="" type="submit" class="input_button" value="Đặt hàng"/>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php echo form_close(); ?>
    </div>
<?php endif; ?>

