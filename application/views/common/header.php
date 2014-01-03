<?php echo doctype('xhtml1-trans'); ?>
<html xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <title><?php if (isset($title)) echo $title; else echo DEFAULT_TITLE; ?></title>
        <?php 
            $config = get_cache('configurations');
            echo $config['webmaster_tracker'];
        ?>
        
        <meta name="keywords" content="<?php if (isset($keywords)) echo $keywords; else echo DEFAULT_KEYWORDS; ?>" />
        <meta name="description" content="<?php if (isset($description)) echo $description; else echo DEFAULT_DESCRIPTION; ?>" />
        <meta name="title" content="<?php if (isset($title)) echo $title; else echo DEFAULT_TITLE; ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="icon" href="/images/favicon.png" type="image/x-icon">
        <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="/duongbq/css/reset.css" />
        <link rel="stylesheet" type="text/css" href="/css/grid.css" />
        <link rel="stylesheet" type="text/css" href="/css/site.css" />
        <link rel="stylesheet" type="text/css" href="/css/social_button_32x32.css" />
        <?php if (isset($css) && ($css != '')) echo $css; ?>
        {IMPORT_CSS}
    </head>
    <body>