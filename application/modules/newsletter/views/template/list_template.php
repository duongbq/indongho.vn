<div class="page_header">
        <div class="fleft"><h1>Thư mẫu</h1></div>
        <div class="fright" style="margin-top: 6px; margin-right: 5px">
            <a href="/news-letter/templates/add" class="button add" style="padding:5px;" title="Thêm thư mẫu"><em></em><span>Thêm thư mẫu</span></a>    
        </div>
        <br style="clear:both;">
</div>
<div class="form_content">
<?php $this->load->view('duongbq/message'); ?>
    <div  class="data_table bold">
        <table class="list" style="width: 100%;">
        <tr>
            <th class="center" style="width:1%;">STT</th>
            <th style="width:25%;">Tên thư mẫu</th>
            <th class="left" style="width:5%;">Hình ảnh</th>
            <th class="left" style="width:3%;">Khách hàng</th>
            <th style="width:1%;" class="center">Tùy chọn</th>
        </tr>
        <?php if(isset($templates)):?>
        <?php
        foreach ($templates as $index => $value):
            $i = $index + 1;
            $style = ($index % 2 == 0) ? 'even' : 'odd';
        ?>
            <tr class="<?php echo $style ?>">
                <td class="center"><?php echo $i; ?></td>
                <td class="left"><?php echo $value->template_name; ?></td>
                <td class="left">
                    <?php if($value->template_thumbnail != '' && $value->template_thumbnail != NULL):?>
                    <a rel="example_group" href="<?php echo base_url(); ?>images/templates/<?php echo $value->template_thumbnail;?>">
                        <img width="130" height="150" src="/images/templates/<?php echo $value->template_thumbnail;?>">
                    </a>
                    <?php endif;?>
                </td>
                <td class="left" style="white-space: nowrap">
                    <?php if(isset($users_array[$value->user_id])) echo $users_array[$value->user_id]; ?>
                </td>
                <td class="right" style="white-space: nowrap">
                    <a class="edit" title="Sửa template này" href="/news-letter/templates/edit/<?php echo $value->id;?>"><em></em></a>
                    <a class="del" title="Xóa tempalte này" href="/news-letter/templates/delete/<?php echo $value->id;?>" onclick="return confirm('Bạn có chắc chắn muốn xóa thư mẫu này không?')"><em></em></a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php endif;?>
        </table>
        <div class="pagination"><?php if (isset($pagination))echo $pagination; ?></div>
    </div>
</div>