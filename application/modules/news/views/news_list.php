<div class="news" style="margin-top: 5px;">
    <h1 class="title"><?php echo $title; ?></h1>
        <?php if (count($news) > 0): ?>
            <ul>
                <?php
                foreach ($news as $new):
                    $this->load->view('news_content', array('new' => $new));
                endforeach;
                ?>
            </ul>
        <?php 
        endif; 
        echo (isset($pagination) && trim($pagination) != '') ? '<div class="pagination">' . $pagination . '</div>' : '';
        ?>
</div>