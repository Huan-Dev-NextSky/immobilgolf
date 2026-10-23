<?php if(config_db_item('currency_conversions_enabled') === TRUE): ?>

<?php

if(!empty($estate_data_option_36))
{
    $default_value = $estate_data_option_36;
    
    if(!empty($options_suffix_36))
    {
        $default_currency = $options_suffix_36;
    }
    else
    {
        $default_currency = $options_prefix_36;
    }
    
}
else if(!empty($estate_data_option_37))
{
    $default_value = $estate_data_option_37;

    if(!empty($options_suffix_37))
    {
        $default_currency = $options_suffix_37;
    }
    else
    {
        $default_currency = $options_prefix_37;
    }

}

if(!empty($default_value)):

$default_value = str_replace(',', '', $default_value);
$default_value = number_format($default_value, 2, '.', '');;

?>
<div class="widget widget-box box-container widget-overview">
    <div class="widget-header text-uppercase"><span class="marker-proprieta"><img src="assets/img/immobilgolf/marker_immobilgolf.png" width="25px" alt="immobilgolf"></span>
       <?php _l('Currency conversions'); ?>
    </div>
<div class="currency_widget">
    <table class="table table-striped">
        <tr>
            <td><input id="ccw_value" class="currency_value" name="currency_value" type="text" value="<?php echo $default_value; ?>" /></td>
            <td>
<?php
$CI =& get_instance();
$CI->load->model('conversions_m');

$conversion_table = $CI->conversions_m->get_conversions_table();

// Generate options
$options = array();
if(sw_count($conversion_table) > 0)
foreach($conversion_table['code'] as $key=>$row)
{
    $options[$key] = $key;
    if(!empty($row->currency_symbol))
        $options[$key].=' ('.$row->currency_symbol.')';

}

// Default selected
if(isset($conversion_table['code'][$default_currency]))
{
    $default_currency = $conversion_table['code'][$default_currency]->currency_code;
}
else if(isset($conversion_table['symbol'][$default_currency]))
{
    $default_currency = $conversion_table['symbol'][$default_currency]->currency_code;
}

echo form_dropdown('currency_code', $options, $default_currency, 'id="ccw_code"');
?>
            </td>
        </tr>
        
<?php

$default_currency_index = $conversion_table['code'][$default_currency]->conversion_index;
$js_array_gen = '';


foreach($conversion_table['code'] as $key=>$row)
{    
    $curr_complete = $key;
    if(!empty($row->currency_symbol))
        $curr_complete.=' ('.$row->currency_symbol.')';
    
    
    
    $curr_value = $default_value / $row->conversion_index * $default_currency_index;
    
    
    $js_array_gen.= '{code:"'.$key.'", codefull:"'.$curr_complete.'", index:'.$row->conversion_index.'},'."\n";
    
    if($key == $default_currency)
        continue;
    
    echo '
    <tr>
        <td>'.number_format($curr_value, 2, '.', '').'</td>
        <td>'.$curr_complete.'</td>
    </tr>
    ';

}

if(!empty($js_array_gen))
    $js_array_gen = substr($js_array_gen, 0, -1);
        
?>
    </table>
    </div>
</div><!-- /. widget-OVERVIEW -->   

<script>

$( document ).ready(function() {

    $("#ccw_code, #ccw_value").change(function() {
        refresh_cctable();
    });
    
    refresh_cctable();

});

function refresh_cctable()
{
    var curr_value = $("#ccw_value").val();
    var curr_code = $("#ccw_code").val();
    var curr_index = 1;
    
    curr_value = curr_value.replace(/,/g, ""); 
    
    var cc_array = 
    [
        <?php echo $js_array_gen; ?>
    ];
    
    $('.currency_widget table tr:not(:first)').remove();
    
    $.each(cc_array, function( index, value_obj ) {
        if(value_obj.code == curr_code)
        {
            curr_index = value_obj.index;
        }
    });
    
    $.each(cc_array, function( index, value_obj ) {
        if(value_obj.code != curr_code)
        {
            $('.currency_widget table').append('<tr><td>'+custom_number_format(curr_value/value_obj.index*curr_index)+'</td><td>'+value_obj.codefull+'</td></tr>');
        }
    });
    
}

 

</script>



<?php endif;endif; ?>