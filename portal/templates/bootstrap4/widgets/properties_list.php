<?php foreach($results as $key=>$item): ?>
<div class="col-12">
    <div class="property-card  property-card-list row-fluid clearfix">
        <div class="property-card-header image-box col-md-4">
            <img src="<?php echo _simg($item['thumbnail_url'], '255x165'); ?>" alt="" class="">
            <?php if(($item['is_featured'])):?>
                <div class="budget fea_<?php echo _ch($item['is_featured']); ?>"><i class="fa fa-star"></i></div>
            <?php endif;?>
            <?php if(!empty($item['option_38'])):?>
                <div class="badget"><img src="assets/img/badgets/<?php echo _ch($item['option_38']); ?>.png" alt="<?php echo _ch($item['option_38']); ?>"/></div>
            <?php endif; ?>
            <?php if(!empty($item['option_54'])):?>
                <div class="ownership-badget color-primary fea_<?php echo _ch($item['is_featured']); ?>"><?php echo _ch($item['option_54']); ?></div>
            <?php endif;?>
            <a href="<?php echo $item['url']; ?>" class="property-card-hover">
                <img src="assets/img/property-hover-arrow.png" alt="" class="left-icon">
                <img src="assets/img/plus.png" alt="" class="center-icon">
                <img src="assets/img/icon-notice.png" alt="" class="right-icon">
            </a>
        </div>
        <div class="col-md-8">
            <div class="property-card-tags">
                <?php if(!empty($item['option_4'])):?>
                <span class="label label-default label-tag-warning <?php $a='';$a=strtolower($item['option_4']);echo url_title_cro( str_replace(' ','_',$a)); ?>"><?php _che($item['option_4']); ?></span>
                <?php endif;?>
            </div>
            <div class="property-card-box card-box card-block">
                <h3 class="property-card-title"><a href="<?php echo $item['url']; ?>"><?php _che($item['option_10']); ?></a></h3>
                <div class="property-card-descr"><?php _che($item['option_chlimit_8']); ?></div>
                <div class="property-preview-footer  clearfix">
                    <div class="property-preview-f-right">
                        <a href="<?php echo $item['url']; ?>" class="btn btn-details text-uppercase"><?php echo _l('view details');?></a>
                    </div>
                    <div class="property-preview-f-left text-color-primary fixed">
                        <?php
                        $custom_elements = _get_custom_items();
                        $i=0;
                        if(sw_count($custom_elements) > 0):
                            foreach($custom_elements as $key=>$elem):

                            if(!empty($item['option_'.$elem->f_id]) && $i++<3)
                                if($elem->type == 'DROPDOWN' || $elem->type == 'INPUTBOX'):
                                 ?>
                                    <span class="property-card-value">
                                        <i class="fa <?php _che($elem->f_class); ?>"></i><?php echo _ch($item['option_'.$elem->f_id], '-'); ?> <?php echo _ch(${"options_suffix_$elem->f_id"}, ''); ?> <span style="<?php _che($elem->f_style); ?>"><?php echo _ch(${"options_name_$elem->f_id"}, '-'); ?></span>
                                    </span>
                                 <?php 
                                elseif($elem->type == 'CHECKBOX'):
                                ?>
                                    <span class="property-card-value">
                                        <i class="fa <?php _che($elem->f_class); ?>"></i><strong class="<?php echo (!empty($item['option_'.$elem->f_id])) ? 'glyphicon glyphicon-ok':'glyphicon glyphicon-remove';  ?>"></strong> <?php echo _ch(${"options_name_$elem->f_id"}, '-'); ?>
                                    </span>
                                <?php 
                                endif;                    
                            endforeach;  
                        else:?>

                        <span class="property-card-value">
                            <i class="fa fa-home"></i><?php _che($item['option_2']); ?>
                        </span>
                        <span class="property-card-value">
                            <i class="fa fa-tint"></i><?php _che($item['option_58']); ?>
                        </span>
                        <span class="property-card-value">
                            <i class="fa fa-square-o"></i><?php echo _ch($item['option_57'], '-'); ?> <?php echo _ch($options_suffix_57, '-'); ?>
                        </span>  
                        <?php endif; ?>
                        
                        <span class="property-card-value">
                            <?php if(!empty($item['option_36']) || !empty($item['option_37'])): ?>
                                <?php 
                                    if(!empty($item['option_36']))echo $options_prefix_36.price_format($item['option_36'], $lang_id).$options_suffix_36;
                                    if(!empty($item['option_37']))echo ' '.$options_prefix_37.price_format($item['option_37'], $lang_id).$options_suffix_37
                                ?>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endforeach;?>