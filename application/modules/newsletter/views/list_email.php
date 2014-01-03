<div class="page_header">
        <div class="fleft"><h1>Email Khách hàng</h1></div>
        <div class="fright" style="margin-top: 6px; margin-right: 5px">
            <a href="#" onclick="toggle_form('upload_email')" class="button up bg" style="padding:5px;" title="Upload email"><em></em><span>Upload email</span></a>    
            <a href="/news-letter/emails/download" class="button download bg" style="padding:5px;" title="Download danh sách emails"><em></em><span>Download emails</span></a>
            <a href="/news-letter/emails/add" class="button add" style="padding:5px;" title="Thêm email khách hàng"><em></em><span>Thêm email</span></a>    
        </div>
        <br style="clear:both;">
</div>
<div class="form_content">
<?php $this->load->view('duongbq/message'); ?>
<?php $this->load->view('newsletter/search_form'); ?>
<?php $this->load->view('newsletter/toggle_upload_form'); ?>
<?php $this->load->view('newsletter/email_content'); ?>
</div>