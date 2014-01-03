<div class="order_detail">
    <div>
        <h2>ĐƠN HÀNG CỦA QUÝ KHÁCH ĐÃ ĐƯỢC GỬI CHO ELMICH VIETNAM</h2> 
        <div style="margin-top: 5px;font-style: italic;">
            Chúng tôi sẽ liên hệ với quý khách trong thời gian sớm nhất.<br>
            Chi tiết đơn hàng đã được chúng tôi gửi đến email của bạn.
        </div>
    </div>
    <div class="content">
        <div style="text-align: center"><h1>Hoá đơn mua hàng trực tuyến</h1>
        <i>(Hoá đơn này được lập tự động và chưa được xác nhận bởi nhân viên bán hàng)</i>
        </div>
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table style="width: 99%;">
                            <tbody>
                                <tr>
                                    <th colspan="2" style="text-align: center; font-weight: bold; font-style: italic;">Đơn hàng</th>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding: 5px;">Số: </td>
                                    <td style="padding: 2px;"><?php echo $orders->id; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 2px;">Trạng thái: </td>
                                    <td style="padding: 2px;"><?php echo get_status_orders($orders->order_status); ?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 2px;">Ngày lập: </td>
                                    <td style="padding: 2px;"><?php echo date('d/m/Y (H:i:s)', strtotime($orders->sale_date)); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td colspan="2">
                        <table style="width: 99%;">
                            <tbody>
                                <tr>
                                    <th colspan="2" style="text-align: center; font-weight: bold; font-style: italic;">Liên khách hàng</th>
                                </tr>
                                <tr>
                                    <td style="width: 100px;padding: 2px">Vận đơn: </td>
                                    <td style="padding: 2px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding: 2px;">Vận chuyển: </td>
                                    <td style="padding: 2px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding: 2px;">Ngày chuyển: </td>
                                    <td style="padding: 2px;">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table" style="width: 98%;">
                            <tr>
                                <th colspan="2">Thanh toán</th>
                            </tr>
                            <tr>
                                <td style="width: 100px;">Tên:  </td>
                                <td><?php echo $orders->receiver; ?></td>
                            </tr>
                            <tr>
                                <td>Địa chỉ:  </td>
                                <td><?php echo $orders->address; ?></td>
                            </tr>
                            <tr>
                                <td>Quận/Huyện:  </td>
                                <td><?php if (isset($cities_array[$orders->district_id])) echo $cities_array[$orders->district_id]; ?></td>
                            </tr>
                            <tr>
                                <td>Tỉnh/TP:  </td>
                                <td><?php if (isset($cities_array[$orders->district_id])) echo $cities_array[$orders->city_id]; ?></td>
                            </tr>
                            <tr>
                                <td>Điện thoại:  </td>
                                <td><?php echo $orders->phone; ?></td>
                            </tr>
                            <tr>
                                <td>Email:  </td>
                                <td><?php echo $orders->email; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="2">
                        <table class="table" style="width: 99%;">
                            <tr>
                                <th colspan="2">Nhận hàng</th>
                            </tr>
                            <tr>
                                <td style="width: 100px;">Tên:  </td>
                                <td><?php echo $orders->receiver; ?></td>
                            </tr>
                            <tr>
                                <td>Địa chỉ:  </td>
                                <td><?php echo $orders->address; ?></td>
                            </tr>
                            <tr>
                                <td>Quận/Huyện:  </td>
                                <td><?php if (isset($cities_array[$orders->district_id])) echo $cities_array[$orders->district_id]; ?></td>
                            </tr>
                            <tr>
                                <td>Tỉnh/TP:  </td>
                                <td><?php if (isset($cities_array[$orders->district_id])) echo $cities_array[$orders->city_id]; ?></td>
                            </tr>
                            <tr>
                                <td>Điện thoại:  </td>
                                <td><?php echo $orders->phone; ?></td>
                            </tr>
                            <tr>
                                <td>Email:  </td>
                                <td><?php echo $orders->email; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <p>&nbsp;</p>
        <h3>Danh sách sản phẩm đặt mua : </h3>
        <table class="table" style="width: 100%;">
            <tbody>
                <tr>
                    <th>Mã số #</th>
                    <th>Tên #</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
                <?php foreach ($orders_details as $o): ?>
                    <tr>
                        <td><?php echo $o->product_id; ?></td>
                        <td><?php echo $o->product_name; ?></td>
                        <td><?php echo $o->quantity; ?></td>
                        <td><?php echo get_price_in_vnd($o->price); ?></td>
                        <td><span><?php echo get_price_in_vnd($o->price * $o->quantity); ?> VNĐ</span></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th>Tổng cộng:</th>
                    <td colspan="4"><?php echo get_price_in_vnd($orders->total); ?> VNĐ</td>
                </tr>
                <tr>
                    <th>Bằng chữ:</th>
                    <td colspan="4" nowrap="nowrap"><strong><?php echo DocTienBangChu($orders->total); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>