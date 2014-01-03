<div class="page_header">
        <div class="fleft"><h1>Lịch sử gửi email</h1></div>
        <br style="clear:both;">
</div>
<div class="form_content">
    <div  class="data_table bold">
    <table class="list" style="width: 100%;">
    <tr>
        <th class="center" style="width:1%;">Ngày</th>
        <th class="left" style="width:25%;">Tiêu đề email</th>
        <th class="center" style="width:1%;">Nhóm</th>
        <th style="width:1%;" class="center">Tùy chọn</th>
    </tr>
    <?php if(isset($histories)):?>
        <?php
        foreach ($histories as $index => $value):
            $i = $index + 1;
            $style = ($index % 2 == 0) ? 'even' : 'odd';
        ?>
            <tr class="<?php echo $style ?>">
                <td class="left" style="white-space: nowrap"><?php echo date('d-m-Y H:i:s', strtotime($value->created_date)); ?></td>
                <td class="left"><?php echo $value->email_title; ?></td>
                <td class="left" style="white-space: nowrap"><?php if(isset($group_array[$value->group_id])) echo $group_array[$value->group_id]; ?></td>
                <td class="center" style="white-space: nowrap">
                    <a class="edit" title="Xem chi tiết" href="/news-letter/history/detail/<?php echo $value->id;?>"><em></em></a>
                    <a class="del" title="Xóa lịch sử gửi email này" href="/news-letter/history/delete/<?php echo $value->id;?>" onclick="return confirm('Bạn có chắc chắn muốn xóa lịch sử gửi email này không?')"><em></em></a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php endif;?>
    </table>
    <div class="pagination"><?php if (isset($pagination))echo $pagination; ?></div>
    </div>
</div>