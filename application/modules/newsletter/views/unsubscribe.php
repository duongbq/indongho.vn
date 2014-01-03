<html>
<head>
    <title>Unsubscribe</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="icon" href="/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/css/main.css?v=1" />
</head>
<body>
    <div style="width:100%;padding: 20px;">
        <div style="width:640px;margin:auto;padding:20px;background-color:#fff;-moz-box-shadow : 0 0 2px #444;-webkit-box-shadow : 0 0 2px #444;box-shadow : 0 0 2px #444;-moz-border-radius: 5px 5px 5px 5px;">
            <h1 style="background-color:#002C3F;padding:5px;font-family:tahoma,arial;font-size:14px;color:#fff;margin-bottom:10px;"><?php echo HEADER_EMAIL;?></h1>
            <div style="float:left;width: 100px;margin-top:20px;"><img src="/images/error.png"/></div>
            <div style="float:left;width: 540px;">
                <?php if($msg == 'ok'):?>
                <p style="padding:5px;font-family:tahoma,arial;font-size:14px;color:#222;line-height:20px;">Email của bạn đã được gỡ khỏi danh sách khách hàng của chúng tôi. Cám ơn bạn đã quan tâm và sử dụng dịch vụ!</p>
                <?php elseif ($msg == 'not_ok'):?>
                <p style="padding:5px;font-family:tahoma,arial;font-size:14px;color:#222;line-height:20px;">Email của bạn không tồn tại trong hệ thống</p>
                <?php endif; ?>
            <p style="padding:5px;font-family:tahoma,arial;font-size:14px;color:#222;line-height:20px;">Bạn hãy bấm vào nút <a href="/" class="button" title="Quay trở lại trang chủ">Về trang chủ</a> để quay trở lại!!!</p>
            </div>
            <br style="clear:both"/>
        </div>
    </div>
</body>
</html>