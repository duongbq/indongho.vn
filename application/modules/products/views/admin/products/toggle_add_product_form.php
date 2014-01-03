<div>
<fieldset style="overflow: hidden; display: none;" id="add_product">
        <?php echo form_open('/dashboard/products/add');?>

        <table>
            <tr><td class="title">Tên sản phẩm: (<span>*</span>)</td></tr>
            <tr>
                <td><?php echo form_input(array('name' => 'product_name', 'size' => '50', 'maxlength' => '256', 'style' => 'width:260px;', 'value' => set_value('product_name'))); ?></td>
            </tr>
            <tr>
                <td>
                    <?php echo form_submit(array('name' => 'btnSubmit', 'value' => 'Thêm', 'class' => 'button')); ?>
                </td>
            </tr>
        </table>

        <?php echo form_close();?>
</fieldset>
</div>