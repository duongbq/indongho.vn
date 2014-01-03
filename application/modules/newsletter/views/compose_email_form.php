<div class="page_header">
    <div class="fleft"><h1>Soạn thư</h1></div>
    <br style="clear:both;">
</div>
<div class="form_content">
    <!--form open    -->
    <?php $this->load->view('duongbq/message'); ?>
    <?php echo form_open('/news-letter/compose'); ?>
    <table style="width:100%;margin-top: 10px;">
        <tr><td class="title">Tiêu đề: (<span>*</span>)</td></tr>
        <tr>
            <td>
                <?php echo form_input(array('name' => 'title','size' => '92', 'value' =>  set_value('title'))); ?>
            </td>
        </tr>
        <?php if(count($templates) > 0):?>
        <tr><td class="title">Chọn thư mẫu: </td></tr>
        <tr>
            <td>
                <br/>
                <?php foreach($templates as $template):?>
                <div class="template_panel">
                    <span><?php echo $template->template_name;?></span>
                    <br/>
                    <a href="javascript:void(0);" onclick="get_template_to_content(<?php echo $template->id;?>);" ><img src="/images/templates/<?php echo ($template->template_thumbnail == NULL && $template->template_thumbnail == '') ? 'default.png' :  $template->template_thumbnail;?>"></a>
                </div>
                <?php endforeach;?>
            </td>
        </tr>
        <?php endif;?>
        <tr><td class="title">Nội dung: (<span>*</span>)</td></tr>
        <tr>
            <td>
                <?php echo form_textarea(array('id' => 'content', 'name' => 'content', 'value' =>  ($content != '') ? $content : set_value('content'), 'class' => 'wysiwyg')); ?>
            </td>
        </tr>

        <tr><td class="title">Chọn nhóm (<span>*</span>)</td></tr>
        <tr>
            <tr><td><?php if(isset($group_combo)) echo $group_combo;?></td>
        </tr>
        
        <tr>
            <td style="padding-top: 5px;">
                <?php echo form_submit(array('name' => 'btnSubmit', 'value' => 'Xem trước thư' , 'class' => 'button'));?>
            </td>
        </tr>
    </table>

    <div class="clear" style="margin-bottom: 10px;"/></div>

    <?php echo form_close();?>
</div>
