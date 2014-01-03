<div class="page_header" id="form">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm sản phẩm mới"</small>
    <span class="fright">
        <a class="button back" href="/dashboard/products/<?php echo $this->phpsession->get('product_lang');?>"><em>&nbsp;</em>Quay lại danh sách sản phẩm</a>
    </span>
    <br class="clear"/>
</div>
<div class="form_content" id="form_add">
<?php echo form_open('/dashboard/products/add');?>

<table>
    <?php $this->load->view('duongbq/message'); ?>
    <tr><td class="title">Tên sản phẩm: (<span>*</span>)</td></tr>
    <tr>
        <td><?php echo form_input(array('name' => 'product_name', 'size' => '50', 'maxlength' => '256', 'style' => 'width:260px;', 'value' => set_value('product_name'))); ?></td>
    </tr>
    <tr>
        <td style="margin-bottom: 10px;">
            <?php echo form_submit(array('name' => 'btnSubmit', 'value' => 'Thêm', 'class' => 'button')); ?>
        </td>
    </tr>
</table>

<?php echo form_close();?>
</div>
