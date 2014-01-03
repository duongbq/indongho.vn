<div class="page_header">
    <h1 class="fleft">Album ảnh</h1>
    <small class="fleft">"Quản lý album ảnh"</small>
    <span class="fright"><a class="button add" href= "#" onclick="show_add_album_form();"><em>&nbsp;</em>Thêm album</a></span>
    <br class="clear"/>
</div>
<div class="form_content">
        <?php
            $this->load->view('admin/toggle_add_album');
         ?>
    <br/>
    <div id="sort_album" class="support_sort">
            <ul>
                <li class="header">
                    <div class="fleft">TÊN ALBUM</div>
                    <div class="fright">CHỨC NĂNG</div>
                    <br class="clear"/>
                </li>
            <?php
            foreach ($albums as $album) {
                $album_id       = $album->id;
                $images         = '/images/albums/thumbnails/' . $album->image_name;
                $functions      = '<a class="edit" href="/dashboard/albums/edit/' . $album_id . '" title="Sửa thông tin album"><em>&nbsp;</em></a>';
                $functions      .= '<a class="del" onclick="return confirm(\'Bạn có chắc chắn muốn xóa album này không?\');" href="/dashboard/albums/delete/' . $album_id . '" title="Xóa album"><em>&nbsp;</em></a>';
                echo <<< eob
                <li id="id_{$album_id}">
                    <img src="{$images}" alt="no image"/>
                        {$album->name}
                    <div class="fright" >{$functions}</div>
                </li>
eob;
            }
            ?>
        </ul>
    </div>

</div>