<?php
/*
Widget-title: Search form Visual
Widget-preview-image: /assets/img/widgets_preview/top_search.jpg
*/
?>
<section class="search-form color-primary parallax" id="main-search">
    <div class="container">
        <h3 class="hidden-xs-up"><?php echo _l('Search');?></h3>
        <form action="{page_current_url}#main-search" class="form-horisontal">
            <input id="rectangle_ne" type="text" class="hidden-xs-up" />
            <input id="rectangle_sw" type="text" class="hidden-xs-up" />
            <div class="row">
                <?php  _search_form_primary(4); ?>
                <div class="col-lg-1">
                    <button type="submit" id="search-start" class="btn btn-search focus-color"><i class="fa fa-search fa-color-white hide_on_ajax"></i><i class="fa fa-spinner fa-spin ajax_v fa-ajax-indicator hidden"></i></button>
                </div>
            </div>
            <div class="hidden-xs-up">
                <?php if(config_db_item('secondary_disabled') === TRUE): ?>
                 <!--
                <input id="search_option_36_from" type="text" class="span3 mPrice" placeholder="{lang_Fromprice} ({options_prefix_36}{options_suffix_36})" value="<?php echo search_value('36_from'); ?>" />
                <input id="search_option_36_to" type="text" class="span3 xPrice" placeholder="{lang_Toprice} ({options_prefix_36}{options_suffix_36})" value="<?php echo search_value('36_to'); ?>" />
                -->
                <input id="search_option_19" name="search_option_19" type="text" class="span3 Bathrooms" placeholder="{options_name_19}" value="<?php echo search_value(19); ?>" />
                <input id="search_option_20" name="search_option_20" type="text" class="span3" placeholder="{options_name_20}" value="<?php echo search_value(20); ?>" />
                <div class="form-row-space"></div>
                <?php if(file_exists(APPPATH.'controllers/admin/booking.php')):?>
                <input id="booking_date_from" name="booking_date_from" type="text" class="span3 mPrice" placeholder="{lang_Fromdate}" value="<?php echo search_value('date_from'); ?>" />
                <input id="booking_date_to" name="booking_date_to" type="text" class="span3 xPrice" placeholder="{lang_Todate}" value="<?php echo search_value('date_to'); ?>" />
                <div class="form-row-space"></div>
                <?php endif; ?>
                <?php if(config_db_item('search_energy_efficient_enabled') === TRUE): ?>
                <select id="search_option_59_to" name="search_option_59_to" class="span3 selectpicker nomargin">
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
                    <input id="search_option_11" name="search_option_11" type="checkbox" class="span1" value="true{options_name_11}" <?php echo search_value('11', 'checked'); ?>/>{options_name_11}
                </label>
                <label class="checkbox">
                <input id="search_option_22" name="search_option_22" type="checkbox" class="span1" value="true{options_name_22}" <?php echo search_value('22', 'checked'); ?>/>{options_name_22}
                </label>
                <label class="checkbox">
                <input id="search_option_25" name="search_option_25" type="checkbox" class="span1" value="true{options_name_25}" <?php echo search_value('25', 'checked'); ?>/>{options_name_25}
                </label>
                <label class="checkbox">
                <input id="search_option_27" name="search_option_27" type="checkbox" class="span1" value="true{options_name_27}" <?php echo search_value('27', 'checked'); ?>/>{options_name_27}
                </label>
                <label class="checkbox">
                <input id="search_option_28" name="search_option_28" type="checkbox" class="span1" value="true{options_name_28}" <?php echo search_value('28', 'checked'); ?>/>{options_name_28}
                </label>
                <label class="checkbox">
                <input id="search_option_29" name="search_option_29" type="checkbox" class="span1" value="true{options_name_29}" <?php echo search_value('29', 'checked'); ?>/>{options_name_29}
                </label>
                <label class="checkbox">
                <input id="search_option_32" name="search_option_32" type="checkbox" class="span1" value="true{options_name_32}" <?php echo search_value('32', 'checked'); ?>/>{options_name_32}
                </label>
                <label class="checkbox">
                <input id="search_option_30" name="search_option_30" type="checkbox" class="span1" value="true{options_name_30}" <?php echo search_value('30', 'checked'); ?>/>{options_name_30}
                </label>
                <label class="checkbox">
                <input id="search_option_33" name="search_option_33" type="checkbox" class="span1" value="true{options_name_33}" <?php echo search_value('33', 'checked'); ?>/>{options_name_33}
                </label>
                <label class="checkbox">
                <input id="search_option_23" name="search_option_23" type="checkbox" class="span1" value="true{options_name_23}" <?php echo search_value('23', 'checked'); ?>/>{options_name_23}
                </label>
                <?php else: ?>
                <?php _search_form_secondary_hidden(4); ?>
                <?php endif; ?>
            </div><!-- /.adittional-search-->
        </form>
    </div>
</section><!-- /.header-search-->

<script>
    $('document').ready(function(){
        $('.form-horisontal input, .form-horisontal select').addClass('color-secondary');
    })
</script>