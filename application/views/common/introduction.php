<?php 
echo modules::run('pages/get_static_page_content', array('uri' => get_url_by_lang(switch_language($this->uri->segment(1)), 'introduction', TRUE), 'get_summary' => TRUE));
?>
<a href="<?php echo get_url_by_lang(switch_language($this->uri->segment(1)), 'introduction');?>" class="read_more fright"><?php echo __('IP_view_more');?></a>