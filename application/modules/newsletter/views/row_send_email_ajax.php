<tr>
    <td class="left" style="white-space: nowrap"><?php echo $name; ?></td>
    <td class="left" style="white-space: nowrap"><?php echo $alias; ?></td>
    <td class="left"><?php echo mailto($email, $email); ?></td>
    <td class="left"><?php echo $phone; ?></td>
    <td class="left"><?php echo $position; ?></td>
    <td class="left"><?php echo $call; ?></td>
    <td class="center">
        <?php 
            $img_status = $status == 'sent' ? base_url() . '/duongbq/images/done.png' : base_url() . '/duongbq/images/done.png';
        ?>
        <img src="<?php echo $img_status;?>" alt=""/>
    </td>
</tr>