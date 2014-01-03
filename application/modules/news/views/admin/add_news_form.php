<?php echo form_open($submit_uri); if (isset($id)) echo form_hidden('news_id', $id); ?>

<?php
$title          = isset($title) ? $title : '';
$thumb          = isset($thumb) ? $thumb : '';
$summary        = isset($summary) ? $summary : '';
//$content        = isset($content) ? $content : '';
//echo $content;die;
$created_date   = isset($created_date) ? $created_date : '';
$submit_uri     = isset($submit_uri) ? $submit_uri : '';
echo form_hidden('form', 'news_cat');
?>
<div class="page_header">
    <h1 class="fleft"><?php if(isset($header)) echo $header;?></h1>
    <small class="fleft">"Thêm/sửa tin tức"</small>
    <span class="fright"><a class="button back" href="/dashboard/news/<?php echo $this->phpsession->get('news_lang');?>" title="Quay lại trang danh sách tin tức"><em>&nbsp;</em>Quay lại trang tin tức</a></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <?php $this->load->view('duongbq/message'); ?>

    <ul class="tabs">
            <li><a href="#tab1">Nội dung</a></li>
            <li><a href="#tab2">Meta data</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <table>
                <tr><td class="title">Ngôn ngữ: </td></tr>
                <tr>
                    <td><?php if (isset($lang_combobox)) echo $lang_combobox; ?></td>
                </tr>
                <tr><td class="title">Tiêu đề tin: (<span>*</span>)</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'title', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $title)); ?></td>
                </tr>
                <tr><td class="title">Phân loại tin: (<span>*</span>)</td></tr>
                <tr>
                    <td id="category"><?php if (isset($categories_combobox)) echo $categories_combobox; ?></td>
                </tr>

                <tr><td class="title">Chọn hình minh họa: (<span>*</span>)</td></tr>
                <tr>
                    <td><input id="url_abs" name="thumb" value="<?php echo $thumb;?>" readonly size="30px" onchange="GetFilenameFromPath();" />
                    <input class="button" type="button" value="Chọn hình..." onclick="mcImageManager.browse({fields : 'url_abs'});"/>
                    </td>
                </tr>

                <tr><td class="title"  style="vertical-align: top">Tóm tắt nội dung: (<span>*</span>)</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('id' => 'summary', 'name' => 'summary', 'cols' => '90', 'rows' => '3', 'style' => 'width:560px;', 'value' => $summary)); ?>
                    </td>
                </tr>

                <tr><td class="title" style="vertical-align: top">Nội dung tin: (<span>*</span>)</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('id' => 'content', 'name' => 'content', 'value' => ($content != '') ? $content : set_value('content'), 'class' => 'wysiwyg')); ?>
                    </td>
                </tr>
                <tr><td class="title">Ngày đăng tin: (<span>*</span>)</td></tr>
                <tr>
                    <td>
                        <?php echo form_input(array('id' => 'news_created_date', 'name' => 'created_date', 'size' => '50', 'maxlength' => '10', 'value' => $created_date)); ?>
                        <span style="color:#999;">(định dạng: dd-mm-yyyy)</span>
                    </td>
                </tr>
            </table>
        </div>
        <div id="tab2" class="tab_content">
            <table>
                <tr><td class="title">Meta title: </td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'meta_title', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $meta_title)); ?></td>
                </tr>

                <tr><td class="title" style="vertical-align: top">Meta keywords:</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('name' => 'meta_keywords','size' => '50', 'maxlength' => '256', 'style' => 'width:560px; height: 80px;', 'value' => $meta_keywords)); ?>
                    </td>
                </tr>

                <tr><td class="title" style="vertical-align: top">Meta description:</td></tr>
                <tr>
                    <td>
                        <?php echo form_textarea(array('name' => 'meta_description','size' => '50', 'style' => 'width:560px; height: 80px;', 'value' => $meta_description)); ?>
                    </td>
                </tr>

                <tr><td class="title">Tags:</td></tr>
                <tr>
                    <td><?php echo form_input(array('name' => 'tags', 'size' => '50', 'maxlength' => '256', 'style' => 'width:560px;', 'value' => $tags)); ?></td>
                </tr>
                <tr><td class="hint">Mỗi tag cách nhau bởi dấu phấy.</td></tr>
            </table>
        </div>
    </div>
    <br class="clear"/>
    <div style="margin-top: 10px;"></div>
    <?php echo form_submit(array('name' => 'btnSubmit', 'value' => $button_name, 'class' => 'button')); ?>
    <br class="clear"/>&nbsp;
</div>
<?php echo form_close(); ?>