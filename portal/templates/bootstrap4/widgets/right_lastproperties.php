<?php
/*
Widget-title: Last properties
Widget-preview-image: /assets/img/widgets_preview/right_lastproperties.jpg
*/
?>
<?php if(!empty($last_estates)):?>
<div class="widget widget-box box-container widget-properties">
    <div class="widget-header text-uppercaser"><?php _l('Lastaddedproperties'); ?></div>

        <div class="properties">
            <div class="row">
                <?php foreach($last_estates as $item): ?>
                <div class="col-lg-12">
                    <div class="property-card card">
                        <div class="property-card-header image-box">
                           <img src="<?php echo _simg($item['thumbnail_url'], '383x248'); ?>" alt="" class="">
                           <?php if(($item['is_featured'])):?>
                               <div class="budget"><i class="fa fa-star"></i></div>
                           <?php endif;?>
                           <a href="<?php echo $item['url']; ?>" class="property-card-hover">
                               <img src="assets/img/property-hover-arrow.png" alt="" class="left-icon">
                               <img src="assets/img/plus.png" alt="" class="center-icon">
                               <img src="assets/img/icon-notice.png" alt="" class="right-icon">
                           </a>
                       </div>

                        <div class="property-card-tags">
                            <?php if(!empty($item['option_4'])):?>
                                <span class="label label-default label-tag-warning <?php $a='';$a=strtolower($item['option_4']);echo url_title_cro( str_replace(' ','_',$a)); ?>"><?php _che($item['option_4']); ?></span>
                            <?php endif;?>
                        </div>
                        <div class="property-card-box card-box card-block">
                            <h3 class="property-card-title"><a href="<?php echo $item['url']; ?>"><?php _che($item['option_10']); ?></a></h3>
                            <span class="property-card-title-price">
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
                <?php endforeach;?>
             </div>
        </div>

</div><!-- /.widget-form-->
<?php endif;?>