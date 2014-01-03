<form enctype="multipart/form-data" accept-charset="utf-8" method="post" action="<?php echo '/dashboard/upload_adv';?>">
    <br/>
    Upload ảnh
    <input name="userfile" type="file" />
    <input type="submit" name="btnSubmit" value="Upload">
    <input id="session_upload" name="session_upload" type="hidden" value="<?php echo session_id(); ?>" />
    <input id="process_url" name="process_url" type="hidden" value="/upload_advertisement_images" />
</form>