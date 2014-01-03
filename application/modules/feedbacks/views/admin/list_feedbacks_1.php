<?php
    echo form_open('', array('id' => 'feedback_form'), array('feedback_id' => 0, 'from_list' => TRUE));
    echo form_close();
    echo form_hidden('back_url', '/dashboard/feedbacks/');
?>
<div class="page_header">
    <h1 class="fleft">Ý kiến khách hàng</h1>
    <small class="fleft">"Quản lý ý kiến phản hồi của khách hàng"</small>
    <span class="fright"><a class="button add" href= "/dashboard/feedbacks/add"><em>&nbsp;</em>Thêm ý kiến phản hồi</a></span>
    <br class="clear"/>
</div>
<br class="clear"/>&nbsp;
<div class="form_content">
    <?php $this->load->view('admin/filter_form'); ?>
    <table class="list" style="width: 100%;">
        <tr>
            <th class="left">TÊN KHÁCH HÀNG</th>
            <th class="left">Ý KIẾN PHẢN HỒI</th>
            <th class="center">NGÀY GỬI</th>
            <th class="center">HIỂN THỊ</th>
            <th class="right">CHỨC NĂNG</th>
        </tr>

        <?php
        foreach($feedbacks as $index => $feedback):
        $created_date   = get_vndate_string($feedback->created_date);
        $style = $index % 2 == 0 ? 'even' : 'odd';
        $check          = $feedback->status == ACTIVE_PAGE ? 'checked' : '';
        ?>
        <tr class="<?php echo $style ?>">
            <td><?php echo $feedback->customer?></td>
            <td><?php echo $feedback->content;?></td>
            <td class="center"><?php echo $created_date?></td>
            <td class="center"><input type="checkbox" <?php echo $check;?> onclick="change_feedback_status(<?php echo $feedback->id;?>)"></td>
            <td class="right" style="white-space:nowrap;" class="action">
        <a class="edit" href="javascript:void(0);" onclick="submit_feedback(<?php echo $feedback->id ?>, 'edit');"><em></em></a>
        <a class="del" href="javascript:void(0);" onclick="submit_feedback(<?php echo $feedback->id ?>, 'delete');"><em></em></a>
    </td>
        <?php endforeach;?>
        <?php $left_page_links = 'Trang ' . $page . ' / ' . $total_pages . ' (<span>Tổng: ' . $total_rows . '</span>)'; ?>
        <tr class="list-footer">
            <th colspan="4"><?php echo $left_page_links; ?></th>
            <th colspan="4" class="right"><?php if(isset($page_links) && $page_links!=='') echo 'Chuyển trang: '.$page_links; else echo '&nbsp;'; ?></th>
        </tr>
    </table>
    <br class="clear"/>&nbsp;
</div>