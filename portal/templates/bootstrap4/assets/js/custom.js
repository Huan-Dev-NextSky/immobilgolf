/* End Image gallery script. Big Image */ 

function custom_number_format(val)
{
    return val.toFixed(2);
}

$(document).ready(function(){
    
        if ($('.sw_scale_range').length){
        $('.sw_scale_range').each(function(){
            var th_scale = $(this);
            var th_scale_id = $(this).attr('id');
            var conf_min = '0';
            var conf_max = '100000';
            var conf_sufix= '';
            var conf_prefix= '';
            var conf_infinity = '';
            var conf_predifinedMin = '';
            var conf_predifinedMax =  '';

            if(th_scale.find('.config-range').length ) {
                var $config = th_scale.find('.config-range');
                conf_min = $config.attr('data-min') || 0;
                conf_max = $config.attr('data-max') || '';
                conf_sufix= $config.attr('data-sufix') || '';
                conf_prefix= $config.attr('data-prefix') || '';
                conf_infinity = $config.attr('data-infinity') || "false";
                conf_predifinedMin = $config.attr('data-predifinedMin') || '';
                conf_predifinedMax = $config.attr('data-predifinedMax') || '';
            }
            scale_range('#'+th_scale_id,conf_min,conf_max,conf_prefix,conf_sufix,conf_infinity,conf_predifinedMin,conf_predifinedMax);
       
        })
    }
    
    if($('[autocomplete="off"]').length)
        if(navigator.userAgent.toLowerCase().indexOf('firefox')<0)
            $('[autocomplete="off"]').attr('autocomplete', 'nope')
    
    
});


function scale_range(object, min, max, prefix, sufix, infinity, predifinedMin, predifinedMax, direction) {
    if (typeof object == 'undefined')
        return false;
    if (typeof min == 'undefined' || min=='')
        var min = 0;
    if (typeof max == 'undefined' || max=='')
        return false;
    if (typeof prefix == 'undefined' || prefix=='')
        var prefix = '';
    if (typeof sufix == 'undefined' || sufix=='')
        var sufix = '';
    if (typeof infinity === 'infinity' || infinity=='')
        var infinity = true;
    if (typeof direction == 'undefined' || direction=='')
        var direction = 'ltr';
    if(infinity == "false") infinity = false;
    
    var $ = jQuery;
    if (typeof predifinedMin == 'undefined' || predifinedMin ==''){
        var predifinedMin = min || 0;
        predifinedMin-=10;
    }
    if (typeof predifinedMax == 'undefined' || predifinedMax==''){
        var predifinedMax = max || 100000;
        predifinedMax+=10;
    }
    
    /* errors */
    
    if(!$(object + ' .value-min').length || !$(object + ' .value-max').length) {
        console.log('Scale range: missing input min or max');
        return false;
    }
    
    var r = 0;
    if(infinity) {
        r = 10;
    }
    
    if ($(object + ' .nonlinear').length) {
        var nonLinearSlider = document.querySelector(object + ' .nonlinear');
        noUiSlider.create(nonLinearSlider, {
            connect: true,
            behaviour: 'tap',
            direction: direction,
            start: [predifinedMin, predifinedMax],
            range: {
                'min': [parseInt(min)-r],
                'max': [parseInt(max)+r]
            }
        });

        var nodes = [
            document.querySelector(object + ' .nonlinear-min'), // 0
            document.querySelector(object + ' .nonlinear-max')  // 1
        ];
        
        var inputs = [
            document.querySelector(object + ' .value-min'), // 0
            document.querySelector(object + ' .value-max')  // 1
        ];

        // Display the slider value and how far the handle moved
        
        var noUiSlider_ini = 0;
        
        nonLinearSlider.noUiSlider.on('update', function (values, handle, unencoded, isTap, positions) {
            noUiSlider_ini++;
            
            if(parseInt(values[handle]) > max && infinity){
                nodes[handle].innerHTML = prefix + selio_number_format(parseInt(max)) + sufix+'+';
            }
            else if(parseInt(values[handle]) < min && infinity){
                nodes[handle].innerHTML = prefix +selio_number_format(parseInt(min)) + sufix+'-';
            }
            else
                nodes[handle].innerHTML = prefix + selio_number_format(parseInt(values[handle])) + sufix;
            
            if(parseInt(values[handle]) > max && infinity){
                inputs[handle].value = '';
            }
            else if(parseInt(values[handle]) < min && infinity){
                inputs[handle].value = '';
            }
            else if(noUiSlider_ini>2)
                inputs[handle].value = parseInt(values[handle]).toFixed();
                   
            if(noUiSlider_ini>2 && $(object + ' .value-max').val()=='') {
                $(object + ' .value-max').val(predifinedMax);
            }
            
            $(object + ' .value-min, '+object + ' .value-max').trigger('change')
        });
    }
    
}

function selio_number_format(number, format) {
    if(typeof format == 'undefined') var  format = true;
    
    if(format)
        return new Intl.NumberFormat('de-DE').format(number.toFixed());
    else
        return number.toFixed();
        
}