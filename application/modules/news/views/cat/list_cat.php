<?php
    $this->load->view('cat/cat-nav');
    echo form_open('', array('id' => 'cat_form'), array('cat_id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', '/dashboard/news/categories/');
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('cat/filter_form'); ?>
    <table class="list" style="width: 100%">
        <?php $this->load->view('duongbq/message'); ?>
        <tr>
            <th class="left">DANH MỤC</th>
            <th class="left">ĐƯỜNG DẪN</th>
            <th class="center">CHỨC NĂNG</th>
        </tr>
        <?php foreach($categories as $index => $cat):
            if($cat->parent_id == 0) $style = 'odd';
            else $style = 'even';
            $uri            = $lang . '/' . url_title($cat->category, 'dash', TRUE) . '-n' .$cat->id;
            ?>
        <tr class="<?php echo $style;?>">
            <td class="left"><a href="<?php echo $uri;?>"><?php echo $cat->category; ?></a></td>
            <td><?php echo $uri;?></td>
            <td class="center">
                <a class="edit" title="Sửa danh mục tin tức này" href="javascript:void(0);" onclick="submit_news_cat(<?php echo $cat->id; ?>, 'edit');"><em>&nbsp;</em></a>
                <a class="del" title="Xóa danh mục tin tức này" href="javascript:void(0);" onclick="submit_news_cat(<?php echo $cat->id; ?>, 'delete');"><em>&nbsp;</em></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br class="clear"/>&nbsp;
</div>