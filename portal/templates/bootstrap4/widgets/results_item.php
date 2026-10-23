<?php
$col_sm = '4';
if(isset($columns) && $columns == 3)
{
    $col_sm = '4';
}

if(isset($columns) && $columns == 4)
{
    $col_sm = '3';
}
if(isset($columns) && $columns == 2)
{
    $col_sm = '6';
}

if(isset($columns) && $columns == 12)
{
    $col_sm = '12';
}
$class='';
if(isset($custom_class) && !empty($custom_class))
{
    $class = $custom_class;
} else {
    $class = 'col-lg-'.$col_sm;
}
?>

<div class="<?php echo $class;?>">
    <div class="ribbon-immobilgolf"><?php echo _ch($item['option_4']); ?></div>
    <div class="property-card card">
        <div class="property-card-header image-box">
            <img src="<?php echo _simg($item['thumbnail_url'], '510x330'); ?>" alt="" class="">
            <?/*php if(($item['is_featured'])):?>
                <div class="budget fea_<?php echo _ch($item['is_featured']); ?>"><i class="fa fa-star"></i></div>
            <?php endif;*/?>
            <?/*php if(!empty($item['option_38'])):?>
                <div class="badget"><img src="assets/img/badgets/<?php echo _ch($item['option_38']); ?>.png" alt="<?php echo _ch($item['option_38']); ?>"/></div>
            <?php endif;*/?>
            <?php if(!empty($item['option_54'])):?>
                <div class="ownership-badget color-primary fea_<?php echo _ch($item['is_featured']); ?>"><?php echo _ch($item['option_54']); ?></div>
            <?php endif;?>
            <a href="<?php echo $item['url']; ?>" class="property-card-hover">
                <img src="assets/img/property-hover-arrow.png" alt="" class="left-icon">
                <img src="assets/img/plus.png" alt="" class="center-icon">
                <img src="assets/img/icon-notice.png" alt="" class="right-icon">
            </a>
        </div>
        <div class="property-card-tags">
            <span class="golf-club"><img src="assets/img/immobilgolf/golf-flag.png" alt="golf flag"><?php
                $valore_completo = $item['option_1000'];
                $parte_desiderata = '';
                
                // Cerca l'ultima occorrenza del trattino
                $pos_ultimo_trattino = strrpos($valore_completo, '-');
                
                if ($pos_ultimo_trattino !== false) {
                    // Estrai la sottostringa partendo dalla posizione dopo il trattino
                    // e lo spazio (quindi +2)
                    $parte_desiderata = substr($valore_completo, $pos_ultimo_trattino + 2);
                    // Rimuovi eventuali spazi bianchi all'inizio o alla fine
                    $parte_desiderata = trim($parte_desiderata);
                
                    // Stampa il risultato
                    echo $parte_desiderata;
                }
            ?>
            </span>
            <?/*php if(!empty($item['option_4'])):?>
            <span class="label label-default label-tag-warning <?php $a='';$a=strtolower($item['option_4']);echo url_title_cro( str_replace(' ','_',$a)); ?>"><?php _che($item['option_4']); ?></span>
            <?php endif;*/?>
        <span class="badge-superficie"><i class="fas fa-ruler-combined"></i> <span><?php _che($item['option_57']); ?> m²</span></span>    
        <span class="glifo"><img src="assets/img/immobilgolf/glifo-bianco.png" alt="glifo"></span>    
        </div>
        <div class="property-card-box card-box card-block">
            <h3 class="property-card-title"><a href="<?php echo $item['url']; ?>"><?php _che($item['option_10']); ?></a></h3>
            <div class="property-card-descr"><?php _che($item['option_chlimit_8']); ?>
            </div>
            <?php/*
            <div class="property-preview-footer  clearfix">
                <?php
                    $custom_elements = _get_custom_items();
                ?>
                <div class="property-preview-f-left text-color-primary <?php if(empty($custom_elements)) echo 'fixed';?>">         
                    <span class="property-card-value value-price">
                        <?php if(!empty($item['option_36']) || !empty($item['option_37'])): ?>
                            <?php 
                                if(!empty($item['option_36']))echo $options_prefix_36.price_format($item['option_36'], $lang_id).$options_suffix_36;
                                if(!empty($item['option_37']))echo ' '.$options_prefix_37.price_format($item['option_37'], $lang_id).$options_suffix_37
                            ?>
                        <?php endif; ?>
                    </span>
                    <?php

                    $i=0;
                    if(sw_count($custom_elements) > 0):
                        foreach($custom_elements as $key=>$elem):

                        if(!empty($item['option_'.$elem->f_id]) && $i++<3)
                            if($elem->type == 'DROPDOWN' || $elem->type == 'INPUTBOX'):
                             ?>
                                <span class="property-card-value">
                                    <i class="fa <?php _che($elem->f_class); ?> "></i><?php echo _ch($item['option_'.$elem->f_id], '-'); ?> <?php echo _ch(${"options_suffix_$elem->f_id"}, ''); ?> <span style="<?php _che($elem->f_style); ?>"><?php echo _ch(${"options_name_$elem->f_id"}, '-'); ?></span>
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
                </div>
            </div>
            */?>
            
            
        </div>
    </div>
</div>