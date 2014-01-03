<?php
    $this->load->view('admin/news-nav');
    echo form_open('', array('id' => 'news_form'), array('news_id' => 0, 'from_list' => TRUE));
    echo isset ($uri) ? form_hidden('uri', $uri) : NULL;
    echo form_hidden('back_url', '/dashboard/news/');
    echo form_close();
?>
<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%;margin-bottom: 10px;">
        <tr>
            <th class="left" style="width: 70%">TIÊU ĐỀ TIN</th>
            <th class="left" style="width: 15%">LĨNH VỰC</th>
            <th class="center" style="width: 5%">NGÀY</th>
            <th class="center" style="width: 5%">XEM</th>
            <th class="center" style="width: 5%">CHỨC NĂNG</th>
        </tr>

        <?php
        foreach($news as $index => $new):
        $row_uri        = $lang . '/' . url_title(trim($new->category), 'dash', TRUE). '/' . url_title(trim($new->title), 'dash', TRUE) . '-n' . $new->cat_id . '-' . $new->id;
        $created_date   = get_vndate_string($new->created_date);
        $style = $index % 2 == 0 ? 'even' : 'odd';
        ?>
        <tr class="<?php echo $style ?>">
            <td><a href="<?php echo $row_uri; ?>"><?php echo $new->title?></a></td>
            <td style="white-space:nowrap;"><?php echo $new->category ?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $created_date?></td>
            <td class="center" style="white-space:nowrap;"><?php echo $new->viewed ?></td>
            <td class="center" style="white-space:nowrap;" class="action">
        <a class="edit" href="javascript:void(0);" onclick="submit_news(<?php echo $new->id ?>, 'edit');"><em>&nbsp;</em></a>
        <a class="del" href="javascript:void(0);" onclick="submit_news(<?php echo $new->id ?>, 'delete');"><em>&nbsp;</em></a>
    </td>
        <?php endforeach;?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng: ' . $total_rows . ' tin</span>)'; ?>
        <tr class="list-footer">
            <th colspan="7" class="left"><?php echo $left_page_links; ?></th>
        </tr>
    </table>
</div>

<?php if(isset($page_links) && $page_links!=='') echo '<div class="pagination" style="margin-left:20px;">' . $page_links . '</div>'; ?>