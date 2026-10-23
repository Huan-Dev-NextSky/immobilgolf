<?php if(config_db_item('app_type') == 'demo' || $this->session->userdata('type') == 'ADMIN'): ?>
<div class="custom-palette border-color-secondary  palette-closed">
    <div class="custom-palette-box">
        <div class="custom-palette-box-pr">
            <div class="row-fluid">
                <div class='palette-prepared' id='palette-colors-prepared'>
                    <label class="label-title"><?php echo _l('Color Variant');?></label>
                    <ul class="palette-prepared-list palette-colors clearfix">
                        <li class="palette-color-red" data-color-id='red' data-primary-color='#cf4041' data-secondary-color='#a61c1d' data-focus-color='#000000' data-badgesprimary-color='#387DAB' data-badgessecondary-color='#314D68'><a href="#" title='red'></a></li>
                        <li class="palette-color-pink" data-color-id='pink' data-primary-color='#bf224e' data-secondary-color='#940a31' data-focus-color='#b6ac20' data-badgesprimary-color='#2892BA' data-badgessecondary-color='#296275'><a href="#" title='pink'></a></li>
                        <li class="palette-color-blue" data-color-id='blue' data-primary-color='#0f7ad5' data-secondary-color='#004790)' data-focus-color='#cc1b0e' data-badgesprimary-color='#B7CD08' data-badgessecondary-color='#7D881E'><a href="#" title='blue'></a></li>
                        <li class="palette-color-green" data-color-id='green' data-primary-color='#39b54a' data-secondary-color='#2f913c' data-focus-color='#5C36AD' data-badgesprimary-color='#AD7236' data-badgessecondary-color='#5E4830'><a href="#" title='green'></a></li>
                        <li class="palette-color-cyan" data-color-id='cyan' data-primary-color='#0aa699' data-secondary-color='#197069'  data-focus-color='#9d098c' data-badgesprimary-color='#F2CE3A' data-badgessecondary-color='#9D7E09'><a href="#" title='cyan'></a></li>
                        <li class="palette-color-purple" data-color-id='purple' data-primary-color='#8e5c90' data-secondary-color='#5a2f5c' data-focus-color='#000000' data-badgesprimary-color='#55867D' data-badgessecondary-color='#56857D'><a href="#" title='purple'></a></li>
                        <li class="palette-color-orange" data-color-id='orange' data-primary-color='#d9b62e' data-secondary-color='#967e1b' data-focus-color='#000000' data-badgesprimary-color='#D927CE' data-badgessecondary-color='#D927CE'><a href="#" title='orange'></a></li>
                        <li class="palette-color-brown" data-color-id='brown' data-primary-color='#846447' data-secondary-color='#a1764f' data-focus-color='#000000' data-badgesprimary-color='#504180' data-badgessecondary-color='#4E3F79'><a href="#" title='brown'></a></li>
                    </ul>
                </div>
                <div class="custom-palette-color" >
                    <label class="label-title"><?php echo lang_check('Primary color');?></label>
                    <div class="input-group " id="color-primary">
                        <input type="text" value="" class="form-control" />
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                <div class="custom-palette-color">
                    <label class="label-title"><?php echo lang_check('Secondary color');?></label>
                    <div class="input-group" id="color-secondary">
                        <input type="text" value="" class="form-control" />
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                <div class="custom-palette-color">
                    <label class="label-title"><?php echo lang_check('Focus color');?></label>
                    <div class="input-group" id="color-focus">
                        <input type="text" value="" class="form-control" />
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                <div class="custom-palette-color visible-lg">
                    <label class="label-title"><?php echo lang_check('Badges primary');?></label>
                    <div class="input-group" id="badges-primary">
                        <input type="text" value="" class="form-control" />
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                <div class="custom-palette-color visible-lg">
                    <label class="label-title"><?php echo lang_check('Badges secondary');?></label>
                    <div class="input-group" id="badges-secondary">
                        <input type="text" value="" class="form-control" />
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                <div class="custom-palette-color">
                    <div class="input-group">
                        <label class="c-input c-radio">
                            <input name="type-site" type="radio" value="boxed">
                            <span class="c-indicator"></span>
                            <?php echo lang_check('boxed');?>
                        </label>

                        <label class="c-input c-radio">
                            <input name="type-site" type="radio" value="" checked="checked">
                            <span class="c-indicator"></span>
                            <?php echo lang_check('wide');?>
                        </label>
                    </div>
                </div>
                <div class="custom-palette-color" id='pallete-background-boxed'>
                    <label class="label-title"><?php echo lang_check('Background color');?></label>
                    <div class="input-group" id="color-background">
                        <input type="text" value="" class="form-control" />
                        <span class="input-group-addon"><i></i></span>
                    </div>
                    <div class='palette-prepared' id='palette-backgroundimage-prepared'>
                        <ul class="palette-prepared-list palette-prepared-list-images clearfix">
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/bg-white-lily-l.jpg'><a href="#"><img src="assets/img/patterns/bg-white-lily-l.jpg" alt="" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/bg-grass-m.jpg'><a href="#"><img src="assets/img/patterns/bg-grass-m.jpg" alt="" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/bg-villa-m.jpg'><a href="#"><img src="assets/img/patterns/bg-villa-m.jpg" alt="" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/wood-background-m.jpg'><a href="#"><img src="assets/img/patterns/wood-background-m.jpg" alt="" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/bg-a-farm-l.jpg'><a href="#"><img src="assets/img/patterns/bg-a-farm-l.jpg" alt="" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/bg-lavender.jpg'><a href="#"><img src="assets/img/patterns/bg-lavender.jpg" alt="" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/full-bg-ocean.jpg'><a href="#"><img src="assets/img/patterns/full-bg-ocean.jpg" alt="" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/full-bg-road.jpg'><a href="#"><img src="assets/img/patterns/full-bg-road.jpg" alt="" /></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php if($this->session->userdata('type') == 'ADMIN' && config_db_item('app_type') != 'demo'): ?>
            <div class="row-fluid text-center">
                <a href="#" id="design-save" class="btn btn-primary color-secondary full-width btn-wide" id="pallete-save"><span><?php echo _l('Save');?></span></a>
            </div>
            <script type="text/javascript">
                $(document).ready(function() {
                    //'use strict';

                    $('#design-save').click(function(e) {
                        e.preventDefault();
                        var color= '';

                        color = {
                            'primary_color':$('#color-primary input').val(),
                            'secondary_color':$('#color-secondary input').val(),
                            'background_color':$('#color-background input').val(),
                            'background_image':$('#palette-backgroundimage-prepared .active').closest('li').attr('data-backgroundimage'),
                            'background_image_style':$('#palette-backgroundimage-prepared .active').closest('li').attr('data-backgroundimage-style'),
                            'focus_color':$('#color-focus input').val(),
                            'badges_primary_color':$('#badges-primary input').val(),
                            'badges_secondary_color':$('#badges-secondary input').val(),
                        }

                        color = JSON.stringify(color)


                        var data = { design_parameters: $('body').attr('class'), css_variant: '', color: color };

                        var load_indicator = $(this).find('.load-indicator');
                        load_indicator.css('display', 'inline-block');
                        $.post("{api_private_url}/design_save/{lang_code}", data, 
                               function(data){

                            ShowStatus.show(data.message);

                            load_indicator.css('display', 'none');
                        });

                        return false;
                    });
                });
            </script>
            <?php endif; ?>
            <div class="row-fluid text-center">
                <a href="" class="btn btn-primary color-secondary btn-wide" id="pallete-reset"><span><?php echo _l('Reset');?></span></a>
            </div>
            <a class="btn btn-primary custom-palette-btn color-secondary">
                <span><?php echo _l('options');?></span>
            </a>
        </div>
    </div>
</div><!-- /.custom-palette -->  
<?php endif;?>