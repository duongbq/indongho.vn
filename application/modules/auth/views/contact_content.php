<div style="width:90%;background-color:#f5f5f5;margin:auto;padding:20px;border:solid 1px #ddd;line-height:20px;font-family:tahoma;font-size:13px;border-bottom:solid 1px #002C3F;">
    <p style="padding:5px;line-height:20px;">Họ tên khách hàng: <strong><?php echo $name; ?></strong><br/>
    <p style="padding:5px;line-height:20px;">Điện thoại: <strong><?php echo $phone; ?></strong><br/>
    <p style="padding:5px;line-height:20px;">Nội dung: <?php echo str_replace("<br/>", "\n", $content); ?><br/>
</div>