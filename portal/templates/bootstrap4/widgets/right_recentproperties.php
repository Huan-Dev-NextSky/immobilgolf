<?php
/*
Widget-title: Recent Properties
Widget-preview-image: /assets/img/widgets_preview/right_recentproperties.jpg
*/
?>
<?php if(!empty($last_estates)):?>
<div class="widget  widget-agent widget-agentslist">
    <div class="widget-box">
        <h2 class="widget-header text-uppercase">
            <?php _l('Lastaddedproperties'); ?>
        </h2>
    </div>
    <div class="properties-list-small">
        <?php foreach($last_estates as $item): ?>
        <div class="property">
            <a href="<?php echo $item['url']; ?>" class="image image-hoveffect image-cover-div">
                <img src="<?php echo _simg($item['thumbnail_url'], '95x70'); ?>" alt="<?php _che($item['alt']); ?>">
            </a><!-- /.image -->
            <div class="body">
                <div class="title">
                    <h3>
                        <a href="<?php echo $item['url']; ?>"><?php echo _ch($item['option_10']); ?></a>
                    </h3>
                </div><!-- /.title -->
                <div class="location"><?php echo _ch($item['address']); ?></div><!-- /.location -->
                <div class="price">
                    <?php if(!empty($item['option_36']) || !empty($item['option_37'])): ?>
                    <?php 
                        if(!empty($item['option_36']))echo $options_prefix_36.price_format($item['option_36'], $lang_id).$options_suffix_36;
                        if(!empty($item['option_37']))echo ' '.$options_prefix_37.price_format($item['option_37'], $lang_id).$options_suffix_37
                    ?>
                    <?php else: ?>
                    <?php endif; ?>
                </div><!-- /.price -->
            </div><!-- /.wrapper -->
        </div>
        <?php endforeach;?>
    </div> <!-- /. recent properties -->
</div><!-- /. widget recent properties -->
<?php endif;?>