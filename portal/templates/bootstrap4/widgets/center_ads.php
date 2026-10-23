<?php
/*
Widget-title: Ads
Widget-preview-image: /assets/img/widgets_preview/bottom_ads.jpg
*/
?>
<section class="widget section-color-primary ">
    <h3 class="hidden-xs-up"><?php echo _l('Ads');?></h3>
    <div class="container text-center">
<?php if(file_exists(APPPATH.'controllers/admin/ads.php')):?>
    {has_ads_728x90px}
        <a href="{random_ads_728x90px_link}" target="_blank"><img src="{random_ads_728x90px_image}" alt='ads'/></a>
    {/has_ads_728x90px}
<?php elseif(!empty($settings_adsense728_90)): ?>     
    <?php echo $settings_adsense728_90; ?>
<?php endif;?>
    </div>
</section>