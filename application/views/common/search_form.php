<div class="top_search">
    <form class="form fright" method="get" action="<?php echo get_url_by_lang(switch_language($this->uri->segment(1)), 'search')?>">
        <input type="text" name="q" value="<?php echo $this->input->get('q');?>"/> 
        <input type="submit" value="<?php echo __('IP_search');?>" class="input_button" />
    </form>
</div>