<?php
echo form_open($submit_uri);
if (isset($menu_id))
    echo form_hidden('menu_id', $menu_id);
if (isset($parent_id))
    echo form_hidden('parent_id', $parent_id);
if (isset($parent))
    echo form_hidden('parent', $parent);
if (isset($back_url))
    echo form_hidden('back_url', $back_url);
?>

<div class="page_header">
    <h1 class="fleft">Menu</h1>
    <small class="fleft">"Thêm/sửa menu cho trang web của bạn"</small>
    <span class="fright"><?php $this->load->view('admin/back-menu-nav'); ?></span>
    <br class="clear"/>
</div>

<div class="form_content">
    <table>
<?php $this->load->view('duongbq/message'); ?>
        <tr><td class="title">Ngôn ngữ: (<span>*</span>)</td></tr>
        <tr><td><?php echo $language; ?></td></tr>
        <tr><td class="title">Tên menu: (<span>*</span>)</td></tr>
        <tr><td><?php echo form_input(array('name' => 'menu_name', 'size' => '35', 'maxlength' => '45', 'value' => isset($menu_name) ? $menu_name : set_value('menu_name'))); ?></td></tr>
        <tr><td class="title">Đường dẫn: (<span>*</span>)</td></tr>
        <tr><td><?php echo form_input(array('name' => 'url_path', 'size' => '35', 'maxlength' => '512', 'value' => isset($url_path) ? $url_path : set_value('url_path'))); ?></td></tr>
        <tr><td class="title">Css:</td></tr>
        <tr><td><?php echo form_input(array('name' => 'css', 'size' => '35', 'value' => isset($css) ? $css : set_value('css'))); ?></td></tr>
        <tr><td class="title">Vị trí: (<span>*</span>)</td></tr>
        <tr><td><?php if (isset($navigation_menu)) echo $navigation_menu; ?></td></tr>
        <tr>
            <td class="title">
                <table id="role">
                    <tbody>
                        <tr>
                            <th class="title" style="padding: 5px 0;"><h1>Quyền</h1></th>
                    <td ></th>
                    <th class="title" style="padding: 5px 0;"><h1>Phân quyền</h1></th>
        </tr>
        <tr>
            <td>
<?php echo form_multiselect('list_role', $role_menu, '', 'id="list_role" size="5"'); ?>
            </td>
            <td style="vertical-align: middle">
                <input id="add_role" type="button" style="margin: 5px" value="&Gt;"/>
                <div class="clear"></div>
                <input id="remove_role" type="button" style="margin: 5px" value="&Lt;"/>
            </td>
            <td>
<?php echo form_multiselect('selected_role[]', $current_role, '', 'id="selected_role" size="5"'); ?>
                <!--<select id="selected_role" name="selected_role" size="5" multiple="true" >
                    
                </select>-->
            </td>
        </tr>
        </tbody>
    </table>
</td>
</tr>
<tr><td style="padding-top: 5px;">
        <input type="submit" name="submit" value="<?php echo $button_name; ?>" onclick="reload_selected();" class="button" />
    </td></tr>
</table>
</div>
<br class="clear"/>&nbsp;
<?php echo form_close(); ?>
<style>
    table#role{
        width: 300px;
        text-align: center;
    }
    table#role select{
        width: 150px;
        height: 150px;
    }
</style>