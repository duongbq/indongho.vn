<?php 
echo modules::run('pages/get_static_page_content', array('uri' => get_url_by_lang(switch_language($this->uri->segment(1)), 'footer', TRUE)));
//echo __('INFOPOWERS');
?>