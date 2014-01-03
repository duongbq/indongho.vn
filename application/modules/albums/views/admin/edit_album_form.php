
<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thay đổi thông tin về album"</small>
    <span class="fright">
        <a class="button back" href="/dashboard/albums"><em>&nbsp;</em>Quay lại album ảnh</a>
    </span>
    <br class="clear"/>
</div>

<?php
    echo form_open('dashboard/albums/edit/' . $album_id);
    echo form_hidden('album_id', $album_id);
?>
<div id="sort_success">Vị trí ảnh đã được cập nhật</div>
<div class="form_content">
        <table style="width: 100%;">
                <?php $this->load->view('duongbq/message'); ?>
                <tr><td class="title">Tên album: (<span>*</span>)</td></tr>
                <tr><td><?php echo form_input(array('name' => 'album_name', 'size' => '30', 'maxlength' => '256', 'value' => $album_name)); ?></td></tr>
                <tr>
                    <td>
                        <br/>
                        <div>
                            <input id="file_upload" name="file_upload" type="file" />
                        </div>
                        <input id="session_upload" name="session_upload" type="hidden" value="<?php echo session_id(); ?>" />
                        <input id="process_url" name="process_url" type="hidden" value="/upload_album_images" />
                        <br class="clear-both"/>
                        <div id="albums_images" class="support_sort" style="margin-bottom: 10px;">
                            <ul>
                                <?php if (isset($images)) echo $images; ?>
                            </ul>
                        </div>                    
                    </td>
                </tr>
           
            </table>
    <div class="clear-both"></div>
    <div style="margin-top: 10px;"></div>
    <input class="button" type="submit" value="<?php if(isset($button_name)) echo $button_name;?>" name="btnEdit">
    <br class="clear">
</div>
<?php echo form_close(); ?>