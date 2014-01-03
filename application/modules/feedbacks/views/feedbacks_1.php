<div class="food_menu">
    <h2 class="customer"><em></em><?php echo __("IP_testimonial");?></h2>
    <div class="feedback">
        <?php foreach($feedbacks as $feedback):?>
        <div>
            <p class="customer"><?php echo $feedback->customer;?><span>(<?php echo date('d/m H:i', strtotime($feedback->created_date));?>)</span></p>
            <p><?php echo shorten_str($feedback->content, TESTIMONIAL_MAXLENGTH);?></p>
        </div>
        <?php endforeach;?>
        <div style="text-align:center;"><a class="button2" href="<?php echo get_url_by_lang($lang, 'send_testimonial');?>" title="<?php echo __("IP_send_testimonial_title");?>"><?php echo __("IP_send_testimonial");?></a></div>
    </div>
</div>