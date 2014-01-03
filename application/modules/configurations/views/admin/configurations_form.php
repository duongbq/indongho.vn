<div class="page_header">
    <h1 class="fleft">Cấu hình hệ thống</h1>
    <span class="fright"><a class="button save" href= "/dashboard/system_config/save-cache"><em>&nbsp;</em>Lưu cache</a></span>
    <br class="clear"/>
</div>
<?php echo form_open('dashboard/system_config');?>
<div class="form_content">
    <?php $this->load->view('duongbq/message'); ?>
    <ul class="tabs">
            <li><a href="#tab1">Email</a></li>
            <li><a href="#tab2">Sản phẩm</a></li>
            <li><a href="#tab3">Tin tức</a></li>
            <li><a href="#tab5">Tracker</a></li>
            <li><a href="#tab6">Meta data</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <table>
            <tr><td class="title">Email nhận liên hệ của khách hàng: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'contact_email', 'value' => $contact_email)); ?></td>
            </tr>
            </table>
        </div>
        <div id="tab2" class="tab_content">
            <table>
            <tr><td class="title">Số sản phẩm hiển thị / trang: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'products_per_page', 'value' => $products_per_page)); ?></td>
            </tr>
            <tr><td class="title">Số sản phẩm hiển thị bên trái : (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'products_side_per_page', 'value' => $products_side_per_page)); ?></td>
            </tr>
            </table>
        </div>
        <div id="tab3" class="tab_content">
            <table>
            <tr><td class="title">Số tin tức hiển thị / trang: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'news_per_page', 'value' => $news_per_page)); ?></td>
            </tr>
            <tr><td class="title">Số tin tức hiển thị bên phải: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'news_side_per_page', 'value' => $news_side_per_page)); ?></td>
            </tr>
            </table>
        </div>
        <div id="tab4" class="tab_content">
            <table>
            <tr><td class="title">Số ảnh hiển thị / trang: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'image_per_page', 'value' => $image_per_page)); ?></td>
            </tr>
            </table>
        </div>
        <div id="tab5" class="tab_content">
            <table>
            <tr><td class="title">Google tracker code: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_textarea(array('name' => 'google_tracker', 'style' => 'width:560px; height: 80px;', 'value' => $google_tracker)); ?></td>
            </tr>
            <tr><td class="title">Webmaster tracker code: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_textarea(array('name' => 'webmaster_tracker', 'style' => 'width:560px; height: 80px;', 'value' => $webmaster_tracker)); ?></td>
            </tr>
            </table>
        </div>

        <div id="tab6" class="tab_content">
            <table>
                <tr><td class="title">Meta title: </td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'meta_title', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $meta_title)); ?></td>
                </tr>

                <tr><td class="title" style="vertical-align: top">Meta keywords:</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('name' => 'meta_keywords','size' => '50', 'maxlength' => '256', 'style' => 'width:560px; height: 80px;', 'value' => $meta_keywords)); ?>
                    </td>
                </tr>

                <tr><td class="title" style="vertical-align: top">Meta description:</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('name' => 'meta_description','size' => '50', 'style' => 'width:560px; height: 80px;', 'value' => $meta_description)); ?>
                    </td>
                </tr>
            </table>
        </div>
        
        <br class="clear"/>
        <div style="margin-top: 10px;"></div>
        <?php echo form_submit(array('name' => 'btnSubmit', 'value' => 'Lưu lại', 'class' => 'button')); ?>
        <br class="clear"/>&nbsp;
    </div>
</div>
<?php echo form_close(); ?>