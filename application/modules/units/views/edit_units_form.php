<form id="edit_unit_form" style="display: none;" enctype="multipart/form-data" accept-charset="utf-8" method="post" action="<?php echo '/dashboard/units/add';?>">
    <br/>
    <div id="message"></div>
    Tên đơn vị : <br>
    <input type="text" id="unit_name" name="unit_name" />
    <input type="hidden" id="is_edit" name="is_edit" value="0"/>
    <input type="hidden" id="unit_id" name="unit_id" />
    <input type="submit" id="btnSubmit" onclick="return submit_unit();" name="btnSubmit" value="Thêm"/>
</form>