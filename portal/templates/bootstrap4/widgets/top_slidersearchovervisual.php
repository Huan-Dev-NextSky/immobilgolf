<?php
/*
Widget-title: SLider + Search Form
Widget-preview-image: /assets/img/widgets_preview/top_slidersearchover.jpg
*/
?>
<section class="header-slider header-slider-search" id="main-search">
    <h3 class="hidden-xs-up"><?php echo _l('Slider search');?></h3>
    <!-- Carousel container -->
    <div id="header-slider" class="carousel slide" data-ride="carousel">

        <!-- Indicators -->
        <ol class="carousel-indicators">
        <?php foreach($slideshow_images as $item): ?>
            <li data-target="#header-slider" data-slide-to="0" class="<?php _che($item['first_active']);?>"></li>
        <?php endforeach;?>
        </ol>

        <!-- Content -->
        <div class="carousel-inner" role="listbox">
            <!-- Slide 1 -->
            <?php foreach($slideshow_images as $key=>$file): ?>
                <div class="carousel-item <?php _che($file['first_active']);?>">
                    <img src="<?php echo _simg($file['url'], '1800x600'); ?>" alt="<?php _che($file['alt']);?>">
                    <?php if(config_item('property_slider_enabled')===TRUE&&!empty($file['property_details'])):?>
                        <div class="carousel-caption">
                            <div class="text-left-xs carousel-caption-title-box">
                                <h3 class="carousel-caption-title"><?php _che($file['property_details']['title']);?><i class="line-bottom color-primary"></i></h3>
                            </div>
                            <p><?php _che($file['property_details']['option_chlimit_8']);?></p>
                            <a href="<?php _che($file['property_details']['link']);?>" class="btn btn-primary color-primary"><span><?php echo _l('Click to show');?></span></a>
                        </div>
                    <?php elseif(!empty($file['title'])): ?>
                        <div class="carousel-caption">
                            <div class="text-left-xs carousel-caption-title-box">
                                <h3 class="carousel-caption-title"><?php _che($file['title']);?><i class="line-bottom color-primary"></i></h3>
                            </div>
                            <p><?php _che($file['description']);?></p>
                            <?php if(!empty($file['link'])):?>
                                <a href="<?php _che($file['link']);?>" class="btn btn-primary color-primary"><span><?php echo _l('Click to show');?></span></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div> 
            <?php endforeach;?>
        </div>

        <!-- Previous/Next controls -->
        <a class="left carousel-control" href="#header-slider" role="button" data-slide="prev">
            <span class="icon-prev" aria-hidden="true"></span>
            <span class="sr-only"><?php echo _l('Previous');?></span>
        </a>
        <a class="right carousel-control" href="#header-slider" role="button" data-slide="next">
            <span class="icon-next" aria-hidden="true"></span>
            <span class="sr-only"><?php echo _l('Next');?></span>
        </a>

    </div>
    <!-- Carousel container -->
    <div class="header-over-search color-primary">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-8 col-lg-3 offset-md-9 widget widget-box  box-container widget-rightsearch color-primary">
                    <div class="widget-header text-uppercaser"><?php echo _l('Search');?></div>

                    <div class="form-additional2">
                        <form action="{page_current_url}#main-search" class="form-horisontal2">
                            <input id="rectangle_ne" type="text" class="hidden-xs-up" />
                            <input id="rectangle_sw" type="text" class="hidden-xs-up" />
                            <div class="row">
                                <?php  _search_form_primary(4); ?>
                            </div>
                            <button type="submit" class="btn btn-search btn-wide color-secondary" id="search-start"><i class="fa fa-search fa-color-white hide_on_ajax"></i><i class="fa fa-spinner fa-spin ajax_v fa-ajax-indicator hidden"></i></button>
                        
                            <div class="hidden-xs-up">
                                <?php if(config_db_item('secondary_disabled') === TRUE): ?>
                                 <!--
                                <input id="search_option_36_from" type="text" class="span3 mPrice" placeholder="{lang_Fromprice} ({options_prefix_36}{options_suffix_36})" value="<?php echo search_value('36_from'); ?>" />
                                <input id="search_option_36_to" type="text" class="span3 xPrice" placeholder="{lang_Toprice} ({options_prefix_36}{options_suffix_36})" value="<?php echo search_value('36_to'); ?>" />
                                -->
                                 <input id="search_option_19" type="text" class="span3 Bathrooms" placeholder="{options_name_19}" value="<?php echo search_value(19); ?>" />
                                <input id="search_option_20" type="text" class="span3" placeholder="{options_name_20}" value="<?php echo search_value(20); ?>" />
                                <div class="form-row-space"></div>
                                <?php if(file_exists(APPPATH.'controllers/admin/booking.php')):?>
                                <input id="booking_date_from" type="text" class="span3 mPrice" placeholder="{lang_Fromdate}" value="<?php echo search_value('date_from'); ?>" />
                                <input id="booking_date_to" type="text" class="span3 xPrice" placeholder="{lang_Todate}" value="<?php echo search_value('date_to'); ?>" />
                                <div class="form-row-space"></div>
                                <?php endif; ?>
                                <?php if(config_db_item('search_energy_efficient_enabled') === TRUE): ?>
                                <select id="search_option_59_to" class="span3 selectpicker nomargin">
                                    <option value="">{options_name_59}</option>
                                    <option value="50">A</option>
                                    <option value="90">B</option>
                                    <option value="150">C</option>
                                    <option value="230">D</option>
                                    <option value="330">E</option>
                                    <option value="450">F</option>
                                    <option value="999999">G</option>
                                </select>
                                <div class="form-row-space"></div>
                                <?php endif; ?>
                                <label class="checkbox">
                                <input id="search_option_11" type="checkbox" class="span1" value="true{options_name_11}" <?php echo search_value('11', 'checked'); ?>/>{options_name_11}
                                </label>
                                <label class="checkbox">
                                <input id="search_option_22" type="checkbox" class="span1" value="true{options_name_22}" <?php echo search_value('22', 'checked'); ?>/>{options_name_22}
                                </label>
                                <label class="checkbox">
                                <input id="search_option_25" type="checkbox" class="span1" value="true{options_name_25}" <?php echo search_value('25', 'checked'); ?>/>{options_name_25}
                                </label>
                                <label class="checkbox">
                                <input id="search_option_27" type="checkbox" class="span1" value="true{options_name_27}" <?php echo search_value('27', 'checked'); ?>/>{options_name_27}
                                </label>
                                <label class="checkbox">
                                <input id="search_option_28" type="checkbox" class="span1" value="true{options_name_28}" <?php echo search_value('28', 'checked'); ?>/>{options_name_28}
                                </label>
                                <label class="checkbox">
                                <input id="search_option_29" type="checkbox" class="span1" value="true{options_name_29}" <?php echo search_value('29', 'checked'); ?>/>{options_name_29}
                                </label>
                                <label class="checkbox">
                                <input id="search_option_32" type="checkbox" class="span1" value="true{options_name_32}" <?php echo search_value('32', 'checked'); ?>/>{options_name_32}
                                </label>
                                <label class="checkbox">
                                <input id="search_option_30" type="checkbox" class="span1" value="true{options_name_30}" <?php echo search_value('30', 'checked'); ?>/>{options_name_30}
                                </label>
                                <label class="checkbox">
                                <input id="search_option_33" type="checkbox" class="span1" value="true{options_name_33}" <?php echo search_value('33', 'checked'); ?>/>{options_name_33}
                                </label>
                                <label class="checkbox">
                                <input id="search_option_23" type="checkbox" class="span1" value="true{options_name_23}" <?php echo search_value('23', 'checked'); ?>/>{options_name_23}
                                </label>
                                <?php else: ?>
                                <?php _search_form_secondary_hidden(4); ?>
                                <?php endif; ?>
                            </div><!-- /.adittional-search-->
                        
                        </form>
                    </div>
                </div><!-- /.widget-filter--> 
            </div>
        </div>
    </div>
</section><!-- /.header-slider-->

<script>
    $('document').ready(function(){
        $('.form-horisontal2 input, .form-horisontal2 select').addClass('color-secondary');
        $('.form-horisontal2 .selectpicker-primary').addClass('select-secondary');
    })
</script>
