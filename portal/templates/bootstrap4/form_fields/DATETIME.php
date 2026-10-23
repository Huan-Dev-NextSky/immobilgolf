<?php
    $col=3;
    $f_id = $field->id;
    $placeholder = _ch(${'options_name_'.$f_id});
    $direction = $field->direction;
    if($direction == 'NONE'){
        $col=3;
        $direction = '';
    }
    else
    {
        $placeholder = lang_check($direction);
        $direction=strtolower('_'.$direction);
    }
    
    $suf_pre = _ch(${'options_prefix_'.$f_id}, '')._ch(${'options_suffix_'.$f_id}, '');
    if(!empty($suf_pre))
        $suf_pre = ' ('.$suf_pre.')';
        
    $class_add = $field->class;
    if(empty($class_add))
        $class_add = ' col-md-'.$col;
    
?>
<div class="form-group <?php echo $class_add; ?>" style="<?php _che($field->style); ?>">
    <input id="search_option_<?php echo $f_id.$direction; ?>" type="text" class="form-control color-secondary field_datepicker" placeholder="<?php echo $placeholder ?><?php echo $suf_pre; ?>" value="<?php echo search_value($f_id); ?>" />
</div><!-- /.form-group -->