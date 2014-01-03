<div class="page_header">
    <h1 class="fleft">Đơn vị sản phẩm</h1>
    <small class="fleft">"Quản lý đơn vị"</small>
    <span class="fright"><a class="button add" href= "#" onclick="toggle_form('edit_unit_form');add_unit();"><em>&nbsp;</em>Thêm đơn vị</a></span>
    <br class="clear"/>
</div>
<div class="form_content">
        <?php
        if(isset($back_url)) echo form_hidden('back_url', $back_url);
        $this->load->view('edit_units_form');
        ?>
    <input type="hidden" id="back_url" name="current_url" value="<?php echo $this->uri->segment(3) . '/' . $this->uri->segment(4);?>"/>
    <div id="sort_units" class="support_sort" style="margin-bottom: 10px;">
        <ul>
            <li class="header">
                <div class="fleft">Đơn vị tính</div>
                <br class="clear"/>
            </li>
            <?php
            foreach ($units as $i => $unit) {
                $title          = ( $unit->name != NULL ) ? '<a id="unit_' . $unit->id . '" class="img_title" style="display: inline;">' . $unit->name . '</a>' : '';
                echo <<< eob
                <li id="sort_{$unit->id}">
                    {$title}
                    <div class="fright" >
                        <a class="edit" title ="Sửa đơn vị" href="javascript:void(0);" onclick="edit_unit({$unit->id});"><em></em></a>
                        <a class="del" title ="Xóa đơn vị" href="javascript:void(0);" onclick="delete_unit({$unit->id});"><em></em></a>
                    </div>
                </li>
eob;
            }
            ?>
        </ul>
    </div>

</div>