<?php
    $col=6;
    $f_id = $field->id;
    $placeholder = _ch(${'options_name_'.$f_id});
    $direction = $field->direction;
    if($direction == 'NONE'){
        $col=12;
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
    
?>
<div class="form-group <?php echo $class_add; ?>" style="<?php _che($field->style); ?>">
    <input data-option_id="smart" name="search_option_smart" type="text" class="form-control input_am<?php echo $direction;?> id_<?php echo $f_id; ?>"   value="{search_query}" placeholder="{lang_CityorCounty}" autocomplete="off" />
</div><!-- /.form-group -->