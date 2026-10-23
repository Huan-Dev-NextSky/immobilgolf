<?php
/*
Widget-title: Ads
Widget-preview-image: /assets/img/widgets_preview/right_ads.jpg
*/
?>
<div class="widget text-center">
    <?php if(file_exists(APPPATH.'controllers/admin/ads.php')):?>
        {has_ads_180x150px}
        <a href="{random_ads_180x150px_link}" target="_blank"><img src="{random_ads_180x150px_image}" alt="ads" /></a>
        {/has_ads_180x150px}
    <?php elseif(!empty($settings_adsense160_600)): ?>
        <?php echo $settings_adsense160_600; ?>
    <?php endif; ?>
</div>