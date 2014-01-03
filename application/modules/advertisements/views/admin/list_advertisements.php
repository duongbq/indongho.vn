<div class="page_header">
    <h1 class="fleft">Quảng cáo</h1>
    <small class="fleft">"Quản lý quảng cáo"</small>
    <br class="clear"/>
</div>
<div class="form_content">
        <?php
        if(isset($back_url)) echo form_hidden('back_url', $back_url);
        $this->load->view('admin/toggle_add_advertisement');
        $this->load->view('duongbq/message');
        ?>
    <input type="hidden" id="back_url" name="current_url" value="<?php echo $this->uri->segment(3) . '/' . $this->uri->segment(4);?>"/>
    <div id="sort_advertisement" class="support_sort" style="margin-bottom: 10px;">
            <ul>
                <li class="header">
                    <div class="fleft">HÌNH ẢNH</div>
                    <div class="fright">HIỂN THỊ</div>
                    <br class="clear"/>
                </li>
            <?php
            foreach ($advs as $i => $adv) {
                $check          = $adv->status == ACTIVE_ADV ? 'checked' : '';
                $checkbox       = '<input type="checkbox"' . $check . ' onclick="change_adv_status(' . $adv->id . ')">';
                $images         = base_url().'images/advs/thumbnails/' . $adv->image_name;
                $title          = $adv->title != NULL ? '<a id="' . $adv->id . '" class="img_title" style="display: inline;">' . $adv->title . '</a>|' : '';
                echo <<< eob
                <li id="id_{$adv->id}">
                    <img src="{$images}" alt="no image"/>
                    {$title}
                    <a id="{$adv->id}" class="img_link" style="display: inline;">{$adv->url_path}</a>
                    <div class="fright" >
                    {$checkbox}
                    <a class="del" title ="Xóa quảng cáo này" href="javascript:void(0);" onclick="delete_adv({$adv->id});"><em></em></a>
                    </div>
                </li>
eob;
            }
            ?>
        </ul>
    </div>

</div>