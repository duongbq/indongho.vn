<!--List-->
<div  class="data_table bold">
<table class="list" style="width: 100%;">
<tr>
    <th class="center" style="width:3%;">STT</th>
    <th class="center" style="width:25%;">Họ tên</th>
    <th class="center" style="width:2%;">Tên</th>
    <th class="left" style="width:25%;">Email</th>
    <th class="left" style="width:5%;">Điện thoại</th>
    <th class="left" style="width:10%;">Chức vụ</th>
    <th class="left" style="width:10%;">Cách xưng hô</th>
    <th style="width:8%;" class="center">Nhóm</th>
    <th style="width:12%;" class="center">Tùy chọn</th>
</tr>
<?php if(isset($emails)):?>
<?php
foreach ($emails as $index => $value):
    $i = $index + 1;
    $style = ($index % 2 == 0) ? 'even' : 'odd';
?>
    <tr class="<?php echo $style ?>">
        <td class="center"><?php echo $i; ?></td>
        <td class="left" style="white-space: nowrap"><?php echo $value->name; ?></td>
        <td class="left" style="white-space: nowrap"><?php echo $value->alias; ?></td>
        <td class="left"><?php echo mailto($value->email, $value->email); ?></td>
        <td class="left"><?php echo $value->phone; ?></td>
        <td class="left"><?php echo $value->position; ?></td>
        <td class="left"><?php echo $value->call; ?></td>
        <td class="left" style="white-space: nowrap"><?php if(isset($group_array[$value->group_id])) echo $group_array[$value->group_id]; ?></td>
        <td class="center" style="white-space: nowrap">
            <a class="edit" title="Sửa nội dung email này" href="/news-letter/emails/edit/<?php echo $value->id;?>"><em></em></a>
            <a class="del" title="Xóa email này" href="/news-letter/emails/delete/<?php echo $value->id;?>" onclick="return confirm('Bạn có chắc chắn muốn xóa email này không?')"><em></em></a>
        </td>
    </tr>
<?php endforeach; ?>
<?php endif;?>
</table>
<div class="pagination"><?php if (isset($pagination))echo $pagination; ?></div>
</div>
    
<!--List-->  
