<div class="page_header">
    <h1 class="fleft">Danh sách từ khóa</h1>
    <small class="fleft">"Danh sách tất cả các từ khóa auto SEO text link"</small>
    <span class="fright"><a class="button add" href= "#" onclick="toggle_form('add_keyword');"><em>&nbsp;</em>Thêm từ khóa</a></span>
    <br class="clear"/>
</div>
<div class="form_content">
<?php $this->load->view('toggle_add_form');?>
<table class="list" style="width: 100%;">
        <tr>
            <th style="width:40%;" class="left">TỪ KHÓA</th>
            <th style="width:45%;" class="left">ĐƯỜNG DẪN</th>
            <th style="width:5%;">CHỨC NĂNG</th>
        </tr>
        <?php
        foreach ($keywords as $index => $keyword):
            $keyword_id     = $keyword->id;
            $style          = ($index % 2 == 0) ? 'even' : 'odd';
            $functions      = '<a class="edit" href="/dashboard/keywords/edit/' . $keyword_id . '" title="Sửa thông tin từ khóa"><em>&nbsp;</em></a>';
            $functions      .= '<a class="del" onclick="return confirm(\'Bạn có chắc chắn muốn xóa sản phẩm này không?\');" href="/dashboard/keywords/delete/' . $keyword_id . '" title="Xóa từ khóa"><em>&nbsp;</em></a>';

        ?>
        <tr class="<?php echo $style ?>">
            <td class="bold">
                <?php echo $keyword->keyword;?>
            </td>
            <td class="left"><?php echo $keyword->link; ?></td>
            <td class="right"><?php echo $functions; ?></td>
        </tr>

    <?php endforeach; ?>
    </table>
    <br class="clear"/>&nbsp;
</div>