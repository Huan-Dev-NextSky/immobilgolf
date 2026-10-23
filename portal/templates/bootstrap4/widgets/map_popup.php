<?php if(config_item('prices_on_map')== TRUE):?>

<?php 
$price = '';
if(!empty($option_36) || !empty($option_37)):
    $price.='<span class="price">';
        if(!empty($option_36))$price.= $options_prefix_36.price_format($option_36, $lang_id).$options_suffix_36;
        if(!empty($option_37))$price.= ' '.$options_prefix_37.price_format($option_37, $lang_id).$options_suffix_37;
    $price.='</span>';
endif; ?>
<?php endif; ?>  

<div class="infobox">
    <div class="image hover-default">
        <img src="<?php echo _simg($thumbnail_url, '275x160'); ?>" alt="">
        <?php if(($is_featured)):?>
            <div class="budget"><i class="fa fa-star"></i></div>
        <?php endif;?>
        <a href="<?php _che($url, ''); ?>" class="property-card-hover">
        </a>
    </div>
    <div class="title">
        <a href="<?php _che($url, ''); ?>"><?php _che($option_10, ''); ?></a>
    </div>
    <div class="content clearfix">
        <div class="pull-left">
               <?php _che($address, ''); ?>          
        </div>
        <div class="pull-right">
              <a href="<?php _che($url, ''); ?>" class="infobox-link-btn"><?php echo _l('View details');?></a>                
        </div>
    </div>
    <div class="infobox-footer text-color-primary">
        <div class="property-preview-f-left"> 
            <span class="property-card-value"> 
                <i class="fa fa-home"></i><?php _che($option_2, ''); ?> 
            </span> 
            <span class="property-card-value"> 
                <i class="fa fa-tint"></i><?php _che($option_58, ''); ?>
            </span> 
            <span class="property-card-value"> 
                <i class="fa fa-square-o"></i><?php echo _ch($options_prefix_57, ''); ?><?php _che($option_57, ''); ?><?php echo _ch($options_suffix_57, ''); ?>
            </span> 
            <span class="property-card-value"> 
                <?php if(!empty($option_36) || !empty($option_37)): ?>
                    <?php 
                        if(!empty($option_36))echo $options_prefix_36.price_format($option_36, $lang_id).$options_suffix_36;
                        if(!empty($option_37))echo ' '.$options_prefix_37.price_format($option_37, $lang_id).$options_suffix_37
                    ?>
                <?php endif; ?>
            </span> 
        </div> 
    </div>
</div>