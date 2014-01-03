<?php
    $this->load->view('admin/pages-nav');
    echo form_open('', array('id' => 'page_form'), array('page_id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <?php $this->load->view('duongbq/message'); ?>
    <table class="list" style="width: 100%;">
        <tr>
            <th class="left">TÊN TRANG</th>
            <th class="left">ĐƯỜNG DẪN</th>
            <th class="center">NGÀY TẠO</th>
            <th class="center">HIỂN THỊ</th>
            <th class="right">CHỨC NĂNG</th>
        </tr>

        <?php
        foreach($pages as $index => $page):
        $row_uri        = $page->uri;
        $created_date   = get_vndate_string($page->created_date);
        $style = $index % 2 == 0 ? 'even' : 'odd';
        $check          = $page->status == ACTIVE_PAGE ? 'checked' : '';
        ?>
        <tr class="<?php echo $style ?>">
            <td><a href="<?php echo $row_uri; ?>"><?php echo $page->title?></a></td>
            <td><?php echo $page->uri;?></td>
            <td class="center"><?php echo $created_date?></td>
            <td class="center"><input type="checkbox" <?php echo $check;?> onclick="change_page_status(<?php echo $page->id;?>)"></td>
            <td class="right" style="white-space:nowrap;" class="action">
                <a class="edit" href="javascript:void(0);" onclick="submit_page(<?php echo $page->id ?>, 'edit');"><em>&nbsp;</em></a>
        <a class="del" href="javascript:void(0);" onclick="submit_page(<?php echo $page->id ?>, 'delete');"><em>&nbsp;</em></a>
    </td>
        <?php endforeach;?>
        <?php $left_page_links = 'Trang ' . $e_page . ' / ' . $total_pages . ' (<span>Tổng: ' . $total_rows . '</span>)'; ?>
        <tr class="list-footer">
            <th colspan="7" class="left"><?php echo $left_page_links; ?></th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>

<?php if(isset($page_links) && $page_links!=='') echo '<div class="pagination">' . $page_links . '</div>'; ?>