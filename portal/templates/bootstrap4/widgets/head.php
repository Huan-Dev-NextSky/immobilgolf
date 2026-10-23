 <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="robots" content="index, follow">
<title>{page_title}</title>

<!-- SEO -->
<!-- For Google -->
<meta name="description" content="{page_description}" />
<meta name="keywords" content="{page_keywords}" />
<meta name="author" content="" />
<meta name="application-name" content="" />
<?php
    echo generate_alternate_meta();
?>

<!-- For Facebook -->
<meta property="fb:app_id" content="" />
<meta property="og:site_name" content="<?php _che($settings_websitetitle, '');?>" />
<meta property="og:title" content="<?php _che($settings_websitetitle, '');?> - {page_title}" />

<?php if(isset($page_images) && !empty($page_images)):?>
<meta property="og:image" content="<?php _che($page_images[0]->url);?>" />
<?php else:?>
<meta property="og:image" content="<?php _che($website_logo_url);?>" />
<?php endif;?>

<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:description" content="{page_description}" />

<!-- For Twitter -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="<?php _che($settings_websitetitle, '');?> - {page_title}" />
<meta name="twitter:description" content="{page_description}" />

<?php if(isset($page_images) && !empty($page_images)):?>
<meta name="twitter:image" content="<?php _che($page_images[0]->url);?>" />
<?php else:?>
<meta name="twitter:image" content="<?php _che($website_logo_url);?>" />
<?php endif;?>

<!-- END SEO -->


<link rel="canonical" href="<?php echo slug_url(uri_string());?>" />
<link rel="shortcut icon" href="<?php echo $website_favicon_url;?>" type="image/png" />

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<?php cache_file('big_css.css', 'assets/libraries/fontawesome-6.7/css/all.min.css'); ?>
<?php cache_file('big_css.css', 'assets/libraries/fontawesome-6.7/css/v4-shims.min.css'); ?>

<!-- Start Jquery -->
<?php cache_file('big_js_critical.js', 'assets/js/jquery-2.2.1.min.js'); ?>
<?php cache_file('big_js_critical.js', 'assets/libraries/jquery.mobile/jquery.mobile.custom.min.js'); ?>
<!-- End Jquery -->

<!-- Start BOOTSTRAP -->
<?php cache_file('big_js.js', 'assets/libraries/tether/dist/js/tether.min.js'); ?>
<?php cache_file('big_css.css', 'assets/libraries/tether/dist/css/tether.min.css'); ?>

<?php cache_file('big_css.css', 'assets/libraries/bootstrap/dist/css/bootstrap.min.css'); ?>
<?php cache_file('big_js.js', 'assets/libraries/bootstrap/dist/js/bootstrap.min.js'); ?>

<?php cache_file('big_css.css', 'assets/css/bootstrap-select.min.css'); ?>
<?php cache_file('big_js.js', 'assets/js/bootstrap-select.min.js'); ?>

<?php cache_file('big_js.js', 'assets/libraries/bootstrap-colorpicker-master/dist/js/bootstrap-colorpicker.min.js'); ?>
<?php cache_file('big_css.css', 'assets/libraries/bootstrap-colorpicker-master/dist/css/bootstrap-colorpicker.min.css'); ?>
<!-- End Bootstrap -->

<!-- Start Template files -->
<?php cache_file('big_css.css', 'assets/css/winter-flat.css'); ?>
<?php cache_file('big_css.css', 'assets/css/custom.css'); ?>
<?php cache_file('big_css.css', 'assets/css/custom-media.css'); ?>
<?php cache_file('big_js.js', 'assets/js/winter-flat.js'); ?>
<?php cache_file('big_js.js', 'assets/js/custom.js'); ?>
<!-- End  Template files -->

<!-- Start owl-carousel -->
<?php cache_file('big_css.css', 'assets/libraries/owl.carousel/css/owl.carousel.css'); ?>
<?php cache_file('big_js.js', 'assets/libraries/owl.carousel/owl.carousel.min.js'); ?>
<!-- End owl-carousel -->



<!-- Start blueimp  -->
<?php cache_file('big_js.js', 'assets/js/blueimp-gallery.min.js'); ?>
<?php cache_file('big_css.css', 'assets/css/blueimp-gallery.min.css'); ?>
<!-- End blueimp  -->
<?php if(config_db_item('map_version') !='open_street'):?>
<!-- Start JS MAP  -->
<?php cache_file('big_js.js', 'assets/js/custom_google_marker.js'); ?>
<?php cache_file('big_js.js', 'assets/js/markerclusterer.js'); ?>
<?php cache_file('big_js.js', 'assets/js/map.js'); ?>
<?php endif;?>
<?php cache_file('big_css.css', 'assets/css/map.css'); ?>
<!-- End JS MAP  -->

<?php load_map_api(config_db_item('map_version'), $lang_code);?>


<?php cache_file('big_js.js', 'assets/libraries/bootstrap-3-typeahead/bootstrap3-typeahead.min.js'); ?>
<?php //cache_file('big_js2.js', 'assets/libraries/moment-master/moment.js'); ?>
<?php cache_file('big_js.js', 'assets/libraries/customd-jquery-number/jquery.number.js'); ?>
<?php cache_file('big_js.js', 'assets/libraries/h5Validate-master/jquery.h5validate.js'); ?>
<?php cache_file('big_js.js', 'assets/js/jquery.helpers.js'); ?>

<!-- Start bootstrap-datetimepicker-master -->
<?php cache_file('big_css.css', 'assets/libraries/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css'); ?>
<?php cache_file('big_js.js', 'assets/libraries/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js'); ?>
<!-- End bootstrap-datetimepicker-master -->

<!-- Start footable-jquery -->	
<?php cache_file('big_css.css', 'assets/libraries/footable-jquery/css/footable.bootstrap.min.css'); ?>
<?php cache_file('big_js.js', 'assets/libraries/footable-jquery/js/footable.min.js'); ?>
<!-- End footable-jquery -->

<!-- fileupload -->
<?php cache_file('big_css.css', 'assets/css/jquery.fileupload-ui.css'); ?>
<?php cache_file('big_css.css', 'assets/css/jquery.fileupload-ui-noscript.css'); ?> 

<?php cache_file('big_js.js', 'assets/js/jquery.flexslider.js'); ?>
<?php cache_file('big_js.js', 'assets/js/load-image.js'); ?>
<?php cache_file('big_js.js', 'assets/js/jquery-ui-1.10.3.custom.min.js'); ?>

<?php cache_file('big_js.js', 'assets/js/fileupload/jquery.iframe-transport.js'); ?>
<?php cache_file('big_js.js', 'assets/js/fileupload/jquery.fileupload.js'); ?>
<?php cache_file('big_js.js', 'assets/js/fileupload/jquery.fileupload-fp.js'); ?>
<?php cache_file('big_js.js', 'assets/js/fileupload/jquery.fileupload-ui.js'); ?>
<!-- end fileupload -->

<!-- cleditor -->
<?php cache_file('big_css.css', 'assets/css/jquery.cleditor.css'); ?>
<?php cache_file('big_js.js', 'assets/js/jquery.cleditor.min.js'); ?>
<!-- END cleditor -->

<!-- Start kevalbhatt-worldmapgenerator http://kevalbhatt.github.io/WorldMapGenerator/ -->
<?php cache_file('big_js.js', 'assets/libraries/kevalbhatt-worldmapgenerator/moment-with-locales.min.js'); ?>
<?php cache_file('big_js.js', 'assets/libraries/kevalbhatt-worldmapgenerator/moment-timezone-with-data.js'); ?>
<?php cache_file('big_js.js', 'assets/libraries/kevalbhatt-worldmapgenerator/worldmapgenerator.js'); ?>
<!-- END cleditor -->

<?php cache_file('big_js.js', 'assets/js/modernizr.custom.js'); ?>


<!-- url https://plugins.jquery.com/magnific-popup/ -->
<?php if(config_item('report_property_enabled') == TRUE): ?>
<?php cache_file('big_js.js', 'assets/libraries/magnific-popup/jquery.magnific-popup.js'); ?>
<?php cache_file('big_css.css', 'assets/libraries/magnific-popup/magnific-popup.css'); ?>
<?php endif;?>
<!--end magnific-popup -->
<!-- Start palette -->
<?php cache_file('big_css.css', 'assets/css/palette.css'); ?>
<?php cache_file('big_js.js', 'assets/js/palette.js'); ?>
<!-- End palette -->

<!-- jquery.cookiebar -->
<!-- url  http://www.primebox.co.uk/projects/jquery-cookiebar/ -->
<?php cache_file('big_js_critical.js', 'assets/js/jquery.cookiebar.js'); ?>
<?php cache_file('big_css.css', 'assets/css/jquery.cookiebar.css'); ?>
<!--end jquery.cookiebar -->

<!-- url  http://www.primebox.co.uk/projects/jquery-cookiebar/ -->
<?php cache_file('big_js_critical.js', 'assets/libraries/nouislider/nouislider.min.js'); ?>
<?php cache_file('big_css.css', 'assets/libraries/nouislider/nouislider.min.css'); ?>
<!--end jquery.cookiebar -->
    
<!-- Print big css/js -->
<?php cache_file('big_css.css', NULL); ?>
<?php cache_file('big_js_critical.js', NULL); ?>

{is_rtl}
    <link href="assets/css/styles_rtl.css" rel="stylesheet">
{/is_rtl}

<?php
/*
 *  Start Custom style`s (palette)
 * 
 */
if(isset($settings_color) and !empty($settings_color)):
   $settings_color = json_decode($settings_color); 
?>

    <?php if(isset($settings_color->primary_color) and !empty($settings_color->primary_color)):?>
        <style>
            .defaul-hover-primary:hover, .google_marker:before, .color-primary-easy, .section-title span:after,.section-title span:before,.treefield-categories .treefield-box-item:hover,.primary-hover:hover, .infobox .infobox-link-btn:hover,.infobox .title a:hover, .menu .nav >.nav-item .nav-link:hover, .menu .active .nav-link, .menu .nav-link.active, .agents-corousel-item .agent-details .mail:hover, .property-card .property-card-box .property-card-title a:hover ,
            body .dropdown-item:not(.active):hover,
            body .menu .dropdown-item.active,
            body .color-primary,
            .agents-corousel-item .agent-details .mail:hover,
            .property-card .property-card-box .property-card-title a:hover,
            .menu .nav >.nav-item .nav-link:hover, 
            .menu .active .nav-link,
            .menu .nav-link.active,
            .treefield-categories .treefield-box-item:hover,
            .color-primary-easy,
            body .btn.color-primary {
                background-color: <?php _che($settings_color->primary_color);?>;
            }

            .cluster div, .google_marker,
            body .widget .widget-header,
            body .border-color-primary {
                border-color: <?php _che($settings_color->primary_color);?>;
            }
            
            .defaul-hover-primary,
            .news:not(.section-parallax) .card .title a, .primary-hover,.infobox .infobox-footer, .infobox .infobox-link-btn, .infobox .title a,.property-card .property-card-box .property-card-title, .property-card .property-card-box .property-card-title a, .agents-corousel-item .agent-details .mail,
            body .text-color-primary ,
            .news:not(.section-parallax) .card .title a,
            .property-card .property-card-box .property-card-title, 
            .property-card .property-card-box .property-card-title a, 
            .agents-corousel-item .agent-details .mail
            {
                color: <?php _che($settings_color->primary_color);?> ;
            }
            

        </style>
    <?php endif;?>
    
    <?php if(isset($settings_color->secondary_color) and !empty($settings_color->secondary_color)):?>
        <style>
            #search-right-side .form-addittional .form-group input,
            body .pagination-carousel li a:hover,body .pagination-carousel li.active a, body .pagination li.page-item a:hover, body .pagination li.page-item a.active, .header .top-bar .pull-right,
            body .pagination li span:hover,
            body .pagination li span.active,
            body .pagination-carousel li span:hover,
            body .pagination-carousel li.active span,
            body .pagination li a:hover,
            body .pagination li a.active,
            body .pagination li.active span,
            body .pagination-carousel li a:hover,
            body .pagination-carousel li.active a,
            .header .top-bar .pull-right,
            body .color-secondary,
            body .btn.color-secondary  {
                background-color: <?php _che($settings_color->secondary_color);?>;
            }

            body .border-color-secondary {
                border-color: <?php _che($settings_color->secondary_color);?>;
            }
        </style>
    <?php endif;?>
            
    <?php if(isset($settings_color->focus_color) and !empty($settings_color->focus_color)):?>
        <style>
            .focus-color-easy  {
                background-color: <?php _che($settings_color->focus_color);?>;
            }
            
            .focus-color  {
                background-color: <?php _che($settings_color->focus_color);?> !important;
            }
        </style>
    <?php endif;?>
            
    <?php if(isset($settings_color->badges_primary_color) and !empty($settings_color->badges_primary_color)):?>
        <style>
            .badges-primary,
            .property-card .budget, .label-tag-warning {
                background-color: <?php _che($settings_color->badges_primary_color);?>;
            }
        </style>
    <?php endif;?>
            
    <?php if(isset($settings_color->badges_secondary_color) and !empty($settings_color->badges_secondary_color)):?>
        <style>
            .badges-secondary,
            .label-tag-primary  {
                background-color: <?php _che($settings_color->badges_secondary_color);?>;
            }
        </style>
    <?php endif;?>
    
    <?php if(isset($settings_color->background_image) and !empty($settings_color->background_image)):
        $background_image='';
        $pos = strrpos($settings_color->background_image, "assets/img/");
        $background_image = substr($settings_color->background_image, $pos);
    ?>
        <style>
            .section-parallax,
            body {
                background: url(<?php _che($background_image);?>);
                
                <?php if(isset($settings_color->background_image_style) and $settings_color->background_image_style=='fixed'):?>
                    background-repeat :no-repeat;
                    background-attachment: fixed;
                    background-size: cover;
                <?php elseif(isset($settings_color->background_image_style) and $settings_color->background_image_style=='repeat'):?>
                    background-repeat: repeat;
                <?php else:?>
                    background-repeat :no-repeat;
                    background-attachment: fixed;
                <?php endif;?>
            }
        </style>
    <?php elseif(isset($settings_color->background_color) and !empty($settings_color->background_color)):?>
        <style>
            body {
                background-color: <?php _che($settings_color->background_color);?>;
            }
        </style>
        
    <?php endif;?>
<?php endif;?>

<?php
/*
 *  End Custom style`s (palette)
 * 
 */
?>
{settings_tracking}