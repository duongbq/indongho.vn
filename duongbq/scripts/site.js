function submit_email(id, action)
{
    $('input[name=email_id]').val(id);

    if (action=='delete')
        if ( !confirm('Bạn có thực sự muốn xóa email này không?'))
            return;

    $('#email_form').attr('action', '/dashboard/emails/' + action);
    $('#email_form').submit();
}

function submit_menu(id, action, parent_id)
{
    $('input[name=menu_id]').val(id);

    if (action=='delete')
        if ( !confirm('Bạn có thực sự muốn xóa menu này không?'))
            return;
    if(parent_id) $('input[name=parent_id]').val(parent_id);
    $('#menu_form').attr('action', '/dashboard/menu/' + action);
    $('#menu_form').submit();
}

function uploadify(){
    if($('#session_upload').val() === null) return;
    var session_upload      = $('#session_upload').val() ;
    var process_url     = $('#process_url').val();
    $('#file_upload').uploadify({
        'swf'               : '/duongbq/scripts/uploadify/uploadify.swf',
        'formData'          : {'session_upload' : session_upload},
        'uploader'          : process_url,
        'fileTypeExt'       : '*.jpg; *.jpeg; *.gif; *.png',
        'fileTypeDesc'      : 'Image Files (.JPG, .JPEG, .GIF, .PNG)',
        'fileSizeLimit'     : '1MB',
        'removeTimeout'     : 1,
        'buttonText'        : 'Chọn ảnh',
        'onUploadSuccess'   : function(file, data, response) {
            //alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
        },
        'onQueueComplete': function ()
        {
            if(process_url === '/upload_products_images')
            {
                $.ajax(
                {
                    type:   'post',
                    url:    '/get_products_images',
                    data:   {
                        'is-ajax'           : 1
                    },
                    success: function(responseText)
                    {
                        var object = document.getElementById("products_images").childNodes[1];
                        object.innerHTML = responseText;
                        set_hover_img();
                    }
                });
            }
            else if(process_url === '/upload_advertisement_images')
            {
                location.href='/dashboard/advertisements/' + $('#back_url').val() ;
            }
            else if(process_url == '/upload_album_images')
            {
                $.ajax(
                {
                    type:   'post',
                    url:    '/get_album_images',
                    data:   {
                        'is-ajax'           : 1
                    },
                    success: function(responseText)
                    {
                        var object = document.getElementById("albums_images").childNodes[1];
                        object.innerHTML = responseText;
                        editable();
                    }
                });
            }
        }
      });
}

function setup_moveable() {

    // thay đổi vị trí ảnh của sản phẩm
    $("#products_images ul").sortable({
        opacity: 0.6,
        cursor: 'move',
        update: function() {
            var order = $(this).sortable("serialize");
            $.post('/sort_products_images', order, function(data){
                $('#sort_success').fadeIn(1600);
                $('#sort_success').fadeOut(1600, 'linear');
            });
        }
    });

    //thay đổi vị trí hỗ trợ trực tuyến
    $("#sort_support ul").sortable({
        opacity: 0.6,
        cursor: 'move',
        update: function() {
            var order = $(this).sortable("serialize");
            $.post('/supports/sort', order, function(data){
                });
        }
    });

    //thay đổi vị trí quảng cáo
    $("#sort_advertisement ul").sortable({
        opacity: 0.6,
        cursor: 'move',
        update: function() {
            var order = $(this).sortable("serialize");
            $.post('/advertisements/sort', order, function(data){
                });
        }
    });

    // sắp xếp các ảnh trong album
    $("#albums_images ul").sortable({
        opacity: 0.6,
        cursor: 'move',
        update: function() {
            var order = $(this).sortable("serialize");
            $.post('/albums/sort_album_image', order, function(data){
                });
        }
    });

    // sắp xếp album
    $("#sort_album ul").sortable({
        opacity: 0.6,
        cursor: 'move',
        update: function() {
            var order = $(this).sortable("serialize");
            $.post('/albums/sort_album', order, function(data){
                });
        }
    });

    // sắp xếp vị trí của menu
    $("#sort_menu ul").sortable({
        opacity: 0.6,
        cursor: 'move',
        update: function() {
            var order = $(this).sortable("serialize");
            $.post('/menus/sort', order, function(data){
                });
        }
    });
    
    // sắp xếp vị trí của danh mục sản phẩm
    $("#sort_cat ul").sortable({
        opacity: 0.6,
        cursor: 'move',
        update: function() {
            var order = $(this).sortable("serialize");
            $.post('/products_categories/sort', order, function(data){
                });
        }
    });
    
    //Sắp sếp đơn vị
    $("#sort_units ul").sortable({
        opacity: 0.6,
        cursor: 'move',
        update: function() {
            var order = $(this).sortable("serialize");
            $.post('/units/sort', order, function(data){
                });
        }
    });
}

function submit_support(id, action)
{
    $('input[name=support_id]').val(id);
    if (action=='delete')
        if ( !confirm('Bạn có thực sự muốn xóa hỗ trợ trực tuyến này không?'))
            return;

    $('#support_form').attr('action', '/dashboard/supports/' + action);
    $('#support_form').submit();
}

function submit_menu(id, action)
{
    $('input[name=menu_id]').val(id);
    if (action=='delete')
        if ( !confirm('Bạn có thực sự muốn xóa menu này không?'))
            return;

    $('#menu_form').attr('action', '/dashboard/menu/' + action);
    $('#menu_form').submit();
}

function enable_advanced_wysiwyg(selector)
{
    tinyMCE.init({
        mode : "textareas",
        editor_selector : selector,
        theme : "advanced",
        invalid_elements : "div,script,abbr,acronym,address,applet,area,bdo,big,blockquote,button,caption,cite,code,col,colgroup,dd,del,dfn,input,ins,isindex,kbd,label,legend,map,menu,noscript,optgroup,option,param,textarea,var,ruby,samp,select,rtc,hr",
        extended_valid_elements : "iframe[src|width|height|name|align]",
        height: "300px",
        plugins : "paste,inlinepopups,imagemanager,contextmenu,table,heading,preview, media",
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,|,formatselect,fontselect,fontsizeselect,|,image,table, media, code",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        //theme_advanced_path_location : "bottom",
        entity_encoding : "raw",
        language : 'en',
        theme_advanced_buttons1_add : "forecolor,backcolor,separator,link,unlink,pasteword,removeformat,preview, media",
        plugin_preview_width : "640",
        plugin_preview_height : "480",
        convert_urls : false,
        setup : function(ed) {
            ed.onInit.add(function() {
                ed.settings.file_browser_callback = function(field_name, url, type, win) {
                    if (type == 'image')
                        mcImageManager.filebrowserCallBack(field_name, url, type, win);
                    else
                        alert('Do other stuff here');
                };
            });
        }
    });
}

function enable_advanced_wysiwyg1(selector)
{
    tinyMCE.init({
        mode : "textareas",
        editor_selector : selector,
        theme : "advanced",
        invalid_elements : "script,abbr,acronym,address,applet,area,bdo,big,blockquote,button,caption,cite,code,col,colgroup,dd,del,dfn,input,ins,isindex,kbd,label,legend,map,menu,noscript,optgroup,option,param,textarea,var,ruby,samp,select,rtc,hr",
        extended_valid_elements : "iframe[src|width|height|name|align]",
        height: "300px",
        plugins : "paste,inlinepopups,imagemanager,contextmenu,table,heading,preview, media",
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,|,formatselect,fontselect,fontsizeselect,|,image,table, media, code",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        //theme_advanced_path_location : "bottom",
        entity_encoding : "raw",
        language : 'en',
        theme_advanced_buttons1_add : "forecolor,backcolor,separator,link,unlink,pasteword,removeformat,preview, media",
        plugin_preview_width : "640",
        plugin_preview_height : "480",
        convert_urls : false,
        setup : function(ed) {
            ed.onInit.add(function() {
                ed.settings.file_browser_callback = function(field_name, url, type, win) {
                    if (type == 'image')
                        mcImageManager.filebrowserCallBack(field_name, url, type, win);
                    else
                        alert('Do other stuff here');
                };
            });
        }
    });
}

function change_product_status(id)
{
    $.ajax(
    {
        type:'post',
        url : '/change_product_status',
        data:{
            'id'        : id
        },
        success: function()
        {
            return true;
        }
    });
}

function change_page_status(id)
{
    $.ajax(
    {
        type:'post',
        url : '/change_page_status',
        data:{
            'id'        : id
        },
        success: function()
        {
            return true;
        }
    });
}

function change_feedback_status(id)
{
    $.ajax(
    {
        type:'post',
        url : '/change_feedback_status',
        data:{
            'id'        : id
        },
        success: function()
        {
            return true;
        }
    });
}

function submit_page(id, action)
{
    $('input[name=page_id]').val(id);
    if (action=='delete')
        if ( !confirm('Bạn có thực sự muốn xóa trang này không?'))
            return;

    $('#page_form').attr('action', '/dashboard/pages/' + action);
    $('#page_form').submit();
}

function submit_feedback(id, action)
{
    $('input[name=feedback_id]').val(id);
    if (action=='delete')
        if ( !confirm('Bạn có thực sự muốn xóa ý kiến này không?'))
            return;

    $('#feedback_form').attr('action', '/dashboard/feedbacks/' + action);
    $('#feedback_form').submit();
}

function tabs()
{
    $(".tab_content").hide(); //Hide all content
    $("ul.tabs li:first").addClass("active").show(); //Activate first tab
    $(".tab_content:first").show(); //Show first tab content

    //On Click Event
    $("ul.tabs li").click(function() {
        $("ul.tabs li").removeClass("active"); //Remove any "active" class
        $(this).addClass("active"); //Add "active" class to selected tab
        $(".tab_content").hide(); //Hide all tab content

        var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
        $(activeTab).fadeIn(); //Fade in the active ID content
        return false;
    });
}

function setup_datepicker() {
    $("#starting_date").datepicker({
                    dateFormat: 'dd/mm/yy',
                    minDate:0
                    
            }
    );
    $("#ending_date").datepicker({
                dateFormat: 'dd/mm/yy',
                minDate:0
        }
    );
    $("#news_created_date").datepicker({
        dateFormat: 'dd-mm-yy'
    }
    );
    $('#from_date').datepicker({dateFormat: 'dd/mm/yy'});
    $('#to_date').datepicker({dateFormat: 'dd/mm/yy'});
}

function submit_news(id, action)
{
    $('input[name=news_id]').val(id);
    if (action=='delete')
        if ( !confirm('Bạn có thực sự muốn xóa tin này không?'))
            return;

    $('#news_form').attr('action', '/dashboard/news/' + action);
    $('#news_form').submit();
}

function submit_news_cat(id, action)
{
    $('input[name=cat_id]').val(id);
    if (action=='delete')
        if ( !confirm('Bạn có thực sự muốn xóa danh mục này không?'))
            return;

    $('#cat_form').attr('action', '/dashboard/news/categories/' + action);
    $('#cat_form').submit();
}

function submit_cat(id, action)
{
    $('input[name=cat_id]').val(id);
    if (action=='delete')
        if ( !confirm('Bạn có thực sự muốn xóa danh mục này không?'))
            return;

    $('#cat_form').attr('action', '/dashboard/products/categories/' + action);
    $('#cat_form').submit();
}

function show_add_product_form()
{
    $("#add_product").toggle("slow");
}

function delete_products_images(id)
{
    $.ajax(
    {
        type:   'post',
        url:    '/delete_products_images',
        data:   {
            'is-ajax'           : 1,
            'id'                : id
        },
        success: function(responseText)
        {
            var object = document.getElementById("products_images").childNodes[1];
            object.innerHTML = responseText;
            set_hover_img();
        }
    });
}

function show_add_adv_form()
{
    $("#add_adv").toggle("slow");
}

function editable()
{
    $(".img_link").editable("/advertisements/edit_link", {
        indicator : "saving...",
        tooltip   : "Click to edit...",
        style     : "inherit"
    });
    $(".img_title").editable("/advertisements/edit_title", {
        indicator : "saving...",
        tooltip   : "Click to title...",
        style     : "inherit"
    });
}

function change_adv_status(id)
{
    $.ajax(
    {
        type:'post',
        url : '/advertisements/change_adv_status',
        data:{
            'id'        : id
        },
        success: function()
        {
            return true;
        }
    });
}

function show_add_album_form()
{
    $("#add_album").toggle("slow");
}

function delete_album_images(id)
{
    $.ajax(
    {
        type:   'post',
        url:    '/albums/delete_album_images',
        data:   {
            'is-ajax'           : 1,
            'id'                : id
        },
        success: function(responseText)
        {
            var object = document.getElementById("albums_images").childNodes[1];
            object.innerHTML = responseText;
        }
    });
}

function GetFilenameFromPath()
{
    var filePath = $('#url_abs').val();
    var first_url = filePath.substring(0,filePath.lastIndexOf("/")+1);
    var last_url = filePath.substring(filePath.lastIndexOf("/")+1);
    $('#url_abs').val(first_url + 'thumbnails/' + last_url);
}

function change_page_admin(offset, per_page)
{
    var current_uri = $('input[name=url]').val();
    var page = offset / per_page + 1;
    var url = current_uri + '/page-' + page;

    location.href = url;
    return;
}

function show_child(id)
{
    $("#list_item_" + id).toggle("slow");
}

function delete_adv(id)
{
    if ( !confirm('Bạn có thực sự muốn xóa quảng cáo này không?'))
        return;
    $.ajax(
    {
        type:   'post',
        url:    '/advertisements/delete_adv',
        data:   {
            'is-ajax'           : 1,
            'id'                : id
        },
        success: function()
        {
            location.href = '/dashboard/advertisements/' + $('#back_url').val();
        }
    });
}

function toggle_form(id)
{
    $("#" + id).toggle("slow");
}

function set_hover_img()
{
    var setHover = $(".t-wrapper .t-square");
    setHover.each(function(){
        var del = $(this).find(".delete_me")
        $(this).hover(function(){
        del.css("display", "block");
        }, function(){
            del.css("display", "none");
        })
    })
}

function change_lang()
{
    var lang        = $("select[name=lang]").val();
    var back_url    = $("input[name=back_url]").val();
    location.href = back_url + lang;
}

//categories of news and products
function get_categories_by_lang()
{
    var lang = $('select[name=lang]').val();
    //  nếu là thêm và sửa category
    var flag = typeof($('input[name=is_add_edit_category]').val()) != 'undefined' ? $('input[name=is_add_edit_category]').val() : 0;
    
    var form = $('input[name=form]').val()
    
    if(form == 'news_cat')
        my_url = '/get_categories_by_lang';
    else if(form == 'product_cat')
        my_url = '/get_products_categories_by_lang';
    
    
    $.ajax(
    {
        type:   'post',
        url:    my_url,
        data:   {
            'is-ajax'      : 1,
            'lang'         : lang,
            'is_add_edit'  : flag
        },
        success: function(responseText) {
            if ($('#category'))
                $('#category').html(responseText);
        }
    });
}

function edit_unit($id){
	if($id){
		$data = false;
		$.ajax({
			type : "post",
			url : "/units/get_unit_ajax",
			data : {
				is_ajax : 1,
				unit_id : $id
			},
			success : function( data ){
				$unit = $.parseJSON( data );
				if( typeof( $unit ) == 'object' ) {
					$('#edit_unit_form').show('slow');
					$('#edit_unit_form').attr( 'action', '/dashboard/units/edit');
					$('#unit_id').val($unit.id);
					$('#unit_name').val($unit.name);
					$('#is_edit').val(1);
					$('#btnSubmit').val('Sửa');
				}
			}
		});
	}	
}

function add_unit(){
    $('#edit_unit_form').attr( 'action', '/dashboard/units/add');
    $('#unit_name').val('');
    $('#is_edit').val(1);
    $('#btnSubmit').val('Thêm');
}

function delete_unit($id){
    $.ajax({
        type : "post",
        url : "/dashboard/units/delete",
        data : {
            is_ajax : 1,
            unit_id : $id
        },
        success : function( $data ){
            window.location.reload();
        }
    });
}

function submit_unit(){
    $.ajax({
        type : "post",
        url : $('#edit_unit_form').attr( 'action' ),
        data : {
            is_ajax : 1,
            unit_id : $('#unit_id').val(),
            unit_name : $('#unit_name').val()
        },
        success : function( $data ){
//            alert($data);
            if( "OK" == $data.replace(" ","") ){
                window.location.reload();
            }else{
                $('#message').html($data);
            }
        }
    });
    return false;
}

function get_template_to_content(id)
{
    $.ajax(
    {
        type:   'post',
        url:    '/get_template_to_content',
        data:   {
            'template_id'            : id
        },
        success: function(responseText) 
        {
            tinyMCE.execCommand('mceInsertContent', false, responseText);
        }
    });
}

var count = 0;
function prepare_send_email()
{
    var email_id = $('input[name=email_id]').val();
    var ids = email_id.split(',');
    if(ids != '')
    {
        add_history();
        send_email_ajax(count, ids);
    }
    
}

function add_history()
{
    $.ajax(
        {
            type:   'post',
            url:    '/add_history',
            success: function(responseText) 
            {
            }
        });
}

function send_email_ajax(count, ids)
{
    if(count >= ids.length)
    {
        $('#msg').html('Tiến trình gửi thư đã hoàn thành');
        return;
    }
    else
    {
        $.ajax(
        {
            type:   'post',
            url:    '/send_email_ajax',
            data:   {
                'id'            : ids[count]
            },
            beforeSend: function() {
            loading = '<img src="/images/loading.gif" style="border:0;"/> Đang gửi thư..';
            if ($('#msg'))
                $('#msg').html(loading);
            },
            success: function(responseText) 
            {
                    count++;
//                    setTimeout(function(){
                        send_email_ajax(count, ids);
                        $('#table_email').append(responseText);
//                    }, 10000);
            }
        });
    }
}


function prepare_resend_email()
{
    var email_id = $('input[name=email_id]').val();
    var ids = email_id.split(',');
    if(ids != '')
    {
        resend_email_ajax(count, ids);
    }
    
}

function resend_email_ajax(count, ids)
{
    if(count >= ids.length)
    {
        $('#msg').html('Tiến trình gửi thư đã hoàn thành');
        return;
    }
    else
    {
        $.ajax(
        {
            type:   'post',
            url:    '/resend_email_ajax',
            data:   {
                'id'            : ids[count]
            },
            beforeSend: function() {
            loading = '<img src="/images/loading.gif" style="border:0;"/> Đang gửi thư..';
            if ($('#msg'))
                $('#msg').html(loading);
            },
            success: function(responseText) 
            {
                    count++;
//                    setTimeout(function(){
                        resend_email_ajax(count, ids);
                        $('#table_email').append(responseText);
//                    }, 10000);
            }
        });
    }
}

function config_email(server)
{
    if(server == 'google')
    {
        $('input[name=protocol]').val('smtp');
        $('input[name=smtp_host]').val('ssl://smtp.googlemail.com');
        $('input[name=smtp_port]').val('465');
    }
    else if(server == 'yahoo')
    {
        $('input[name=protocol]').val('smtp');
        $('input[name=smtp_host]').val('ssl://smtp.mail.yahoo.com');
        $('input[name=smtp_port]').val('465');
    }
    else
    {
        $('input[name=protocol]').val('');
        $('input[name=smtp_host]').val('');
        $('input[name=smtp_port]').val('');
    }
}

function get_email_id()
{
    var option = $('select[name=resend_option]').val();
    $.ajax(
        {
            type:   'post',
            url:    '/get_email_id',
            data:   {
                'is-ajax'   : 1,
                'option'    : option
            },
            beforeSend: function() {
            loading = '<img src="/images/loading.gif" style="border:0;"/> Đang lấy dữ liệu email..';
            if ($('#msg'))
                $('#msg').html(loading);
            },
            success: function(responseText) 
            {
                $('input[name=email_id]').val(responseText);
                if(responseText != '')
                    $('#msg').html('Đã lấy xong dữ liệu email');
                else
                    $('#msg').html('Không có email nào gửi bị lỗi trong lịch sử này');
            }
        });
    
}

$(document).ready(function()
{
    //    setup_admin_menu();
    set_hover_img();
    uploadify();
    tabs();
    setup_datepicker();
    setup_moveable();
    editable();
});
