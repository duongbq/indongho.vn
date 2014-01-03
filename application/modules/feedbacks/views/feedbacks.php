<div class="food_menu">
    <h2 class="customer"><em></em>Ý kiến khách hàng</h2>
    <div class="feedback">
        <?php foreach($feedbacks as $feedback):?>
        <div>
            <p class="customer"><?php echo $feedback->customer;?><span>(<?php echo date('d/m H:i', strtotime($feedback->created_date));?>)</span></p>
            <p><?php echo $feedback->content;?></p>
        </div>
        <?php endforeach;?>
        <div style="text-align:center;"><a class="button2" href="/y-kien-khach-hang" title="Gửi ý kiến phản hồi về nhà hàng nhật bản New Sake">Gửi phản hồi</a></div>
    </div>
</div>