<html>
    <body>
        <?php 
            $main_content = str_replace('{call}', $call, $content);
            $main_content = str_replace('{name}', $name, $main_content);
            $main_content = str_replace('{alias}', $alias, $main_content);
            $main_content = str_replace('{email}', $email, $main_content);
            $main_content = str_replace('{phone}', $phone, $main_content);
            $main_content = str_replace('{unsubscribe}', $unsubscribe, $main_content);
            echo $main_content;
        ?>
    </body>
</html>
