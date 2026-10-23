<?php
/*
Widget-title: Title + ads
Widget-preview-image: /assets/img/widgets_preview/top_titlebreadcrumb.jpg
*/
?>
<section class="top-title section-color-primary">
    <div class="container"> 
        <div class="row">
            <div class="col-lg-5" style='padding-top: 10px;'>
                <?php echo print_breadcrump(null, ' ', 'class="breadcrumb"');?>
                <h2 class="h-side-title page-title page-title-big text-color-primary">{page_title}</h2> 
            </div>
            <div class="col-lg-7" style='padding-top: 10px;'>
                <div class="text-xs-right">
                <?php if(file_exists(APPPATH.'controllers/admin/ads.php')):?>
                    {has_ads_728x90px}
                    <a href="{random_ads_728x90px_link}" target="_blank"><img src="{random_ads_728x90px_image}" alt="ads" /></a>
                    {/has_ads_728x90px}
                <?php elseif(!empty($settings_adsense728_90)): ?>     
                    <?php echo $settings_adsense728_90; ?>
                <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /. content-header --> 