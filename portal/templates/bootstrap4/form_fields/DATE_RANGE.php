<?php if(file_exists(APPPATH.'controllers/admin/booking.php')):?>
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
<div class="<?php echo $class_add; ?>" style="<?php _che($field->style); ?>">
    <div class="row clearfix form-group-data" >
        <div class="col-md-6">
            <div class="form-group form-group-lg field_select">
                <input id="booking_date_from" type="text" name="booking_date_from" class="form-control noavtoWidth" value="<?php echo search_value('date_from'); ?>"  placeholder="<?php _l('Fromdate'); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-lg field_select">
                <input id="booking_date_to" type="text" name="booking_date_to" class="form-control noavtoWidth" value="<?php echo search_value('date_to'); ?>"  placeholder="<?php _l('Todate'); ?>" autocomplete="off" />
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
