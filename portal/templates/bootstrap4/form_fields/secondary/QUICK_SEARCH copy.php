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
    if(empty($class_add))
        $class_add = ' col-md-'.$col;
    
?>

<div class='<?php echo $class_add; ?>' style="<?php _che($field->style); ?>">
    <div class="row clearfix">
        <div class="col-xl-12">
            <div class="form-group form-group-lg field_select">
                <input id="search_option_quick" name="search_option_quick" type="text" class="form-control noavtoWidth color-secondary" value="{search_query}" placeholder="<?php echo lang_check('Quick search');?>" autocomplete="off" />
            </div>
        </div>
        <!--
        <div class="col-xl-4">
            <div class="form-group form-group-lg field_select">
                <select id="search_radius" name="search_radius"  class="form-control select_styled base no-padding color-secondary">
                    <option value="0">0 km</option>
                    <option value="50">50 km</option>
                    <option value="100">100 km</option>
                    <option value="200">200 km</option>
                </select>
            </div>
        </div>
        -->
    </div>
</div>