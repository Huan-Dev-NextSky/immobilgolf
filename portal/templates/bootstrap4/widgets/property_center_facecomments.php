<?php if(!empty($settings_facebook_comments)): ?>
<div class="widget widget-box box-container">
    <div class="widget-header text-uppercase">
       <?php echo lang_check('Facebook comments');?>
    </div>
        <?php echo str_replace('http://example.com/comments', $page_current_url, $settings_facebook_comments); ?>
</div><!-- /. widget-facebook -->  
<?php endif;?>