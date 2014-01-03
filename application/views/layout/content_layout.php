<?php echo $this->load->view('common/header'); ?>
<?php if (isset($url)) echo form_hidden('url', $url); ?>
<div class="header_container">
    <div class="top_header">
        <div class="container_24">
            <div class="grid_24">
                <?php $this->load->view('common/logo');?>
                <?php $this->load->view('common/login_panel');?>
                <?php $this->load->view('common/lang_navigation');?>
            </div>
        </div>
    </div>
    <div class="middle_header silver_gradient">
        <div class="container_24">
            <div class="grid_24">
                <div class="main_menus fleft">
                    <ul class="menus">
                        <?php if(isset($main_menu)) echo $main_menu;?>
                    </ul>
                </div>
                <div class="top_search fright">

                </div>
            </div>
        </div>
    </div>
    <div class="bottom_header">
        <div class="container_24">
            <div class="grid_24 slideshow">
                <ul class="slides">
                    <?php if(isset($slide_banner)) echo $slide_banner;?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="main_container">
    <div class="container_24">
        <div class="grid_24 top_bar grey_gradient"></div>
        <div class="grid_5">
            <?php if(isset($left_content)) echo $left_content;?>
        </div>
        <div class="main_content">
            <?php if(isset($breadcrumbs)) echo $breadcrumbs;?>
            <?php if(isset($main_content)) echo $main_content;?>
        </div>
    </div>
</div>


<div class="footer_container">
    <div class="container_24">
        <div class="grid_24 footer_content">
            <div class="content content_detail">
                <?php $this->load->view('common/footer_content');?>
            </div>
        </div>
    </div>
</div>


<?php echo $this->load->view('common/footer'); ?>
