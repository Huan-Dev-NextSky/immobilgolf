<?php
// Add skin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'fcunited_skin_get_css' ) ) {
	add_filter( 'fcunited_filter_get_css', 'fcunited_skin_get_css', 10, 2 );
	function fcunited_skin_get_css( $css, $args ) {

		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS
.menu_main_nav_area>ul, .sc_layouts_row:not(.sc_layouts_row_type_narrow) .sc_layouts_menu_nav, .sc_layouts_menu_dir_vertical .sc_layouts_menu_nav{
    {$fonts['menu_font-family']}
	{$fonts['menu_font-size']}
	{$fonts['menu_line-height']}
}

CSS;
		}

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			$vars         = $args['vars'];
			$css['vars'] .= <<<CSS

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS
			
body{
    background-color: {$colors['bg_color']};
}
.top_panel{
    background-color: {$colors['alter_bg_color']};
}

.widget_search input.search-submit, 
.woocommerce.widget_product_search .search_button, 
.widget_display_search #bbp_search_submit, 
#bbpress-forums #bbp-search-form #bbp_search_submit{
     background-color:transparent!important;
}

.widget_search form:hover:after,
form.wp-block-search:after,
.woocommerce.widget_product_search form:hover:after, 
.widget_display_search form:hover:after, 
#bbpress-forums #bbp-search-form:hover:after{
    color: {$colors['text_link']};
}
.widget_search form:after,
form.wp-block-search:after,
.woocommerce.widget_product_search form:after,
.widget_display_search form:after, 
#bbpress-forums #bbp-search-form:after,
.search_wrap .search_submit:before{
    color: {$colors['inverse_bd_hover']};
}
aside .post_item + .post_item{
    border-color:{$colors['bd_color']};
}	
.wp-calendar-nav-next a:after,
.wp-calendar-nav-prev a:before{
     background-color:{$colors['alter_bg_color']};
}	
.content .wp-calendar-nav-next a:after,
.content .wp-calendar-nav-prev a:before{
     background-color:{$colors['bg_color']};
}


.elementor-progress-percentage{
    color: {$colors['text_dark']};
}

.mejs-controls .mejs-time-rail .mejs-time-total, 
.mejs-controls .mejs-time-rail .mejs-time-loaded, 
.mejs-controls .mejs-time-rail .mejs-time-hovered, 
.mejs-controls .mejs-volume-slider .mejs-volume-total, 
.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total{
     background-color:{$colors['alter_bg_color']};
}
.sc_skills_counter .sc_skills_icon{
     color: {$colors['text_hover']};
}
.sc_skills.sc_skills_counter .sc_skills_item_title{
     color: {$colors['text_light']};
}
.sc_slider_controls.slider_pagination_style_bullets .slider_pagination_bullet.swiper-pagination-bullet-active,
.sc_slider_controls.slider_pagination_style_bullets .slider_pagination_bullet:hover,
.swiper-pagination-custom .swiper-pagination-button.swiper-pagination-button-active,
.sc_slider_controls.slider_pagination_style_bullets .slider_pagination_bullet.swiper-pagination-bullet-active,
.sc_slider_controls.slider_pagination_style_bullets .slider_pagination_bullet:hover,
.slider_container .slider_pagination_wrap .swiper-pagination-bullet.swiper-pagination-bullet-active,
.slider_outer .slider_pagination_wrap .swiper-pagination-bullet.swiper-pagination-bullet-active,
.slider_container .slider_pagination_wrap .swiper-pagination-bullet:hover,
.slider_outer .slider_pagination_wrap .swiper-pagination-bullet:hover,
.sc_slider_controls.slider_pagination_style_bullets .slider_pagination_bullet, 
.sc_slider_controls.slider_pagination_style_bullets .slider_pagination_bullet, 
.slider_container .slider_pagination_wrap .swiper-pagination-bullet, 
.slider_outer .slider_pagination_wrap .swiper-pagination-bullet, 
.swiper-pagination-custom .swiper-pagination-button{
     border-color:{$colors['extra_link2']};
     background-color:{$colors['extra_link2']};
}

.sc_layouts_row_type_normal .socials_wrap .social_item .social_icon, 
.sc_layouts_row_type_normal .socials_wrap .social_item .social_icon{
      background-color:{$colors['text_hover']}!important;
}
.sc_layouts_row_type_normal .socials_wrap .social_item:hover .social_icon, 
.sc_layouts_row_type_normal .socials_wrap .social_item:hover .social_icon{
      background-color:{$colors['text_link']}!important;
      color: {$colors['extra_link2']};
}
.sc_layouts_row_fixed_on{
      background-color:{$colors['alter_bg_color']};
}
.sc_price_item .sc_price_item_title, 
.sc_price_item .sc_price_item_title a{
    color: {$colors['extra_dark']};
}
.scheme_green_default .sc_price_item .sc_price_item_price {
    color: {$colors['text_hover']};
}
.scheme_green_default .sc_button:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image) {
    background-color:{$colors['alter_hover']};
}
.scheme_green_default .sc_button:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image):hover {
    background-color:{$colors['text_link']};
}
.widget_shopping_cart .buttons a:not(.checkout),
.woocommerce .widget_price_filter .price_slider_amount .button,
.wpcf7 .align-center .wpcf7-submit,
.comments_wrap .form-submit input[type="submit"]{
    color: {$colors['input_bg_color']}!important;
	background-color: {$colors['text_link2']}!important;
}
form.mc4wp-form .mc4wp-form-fields input[type="submit"]{
	color: {$colors['input_bg_color']}!important;
	background-color: {$colors['text_link']}!important;
}
.widget_shopping_cart .buttons a:not(.checkout):hover,
.widget_shopping_cart .buttons a:not(.checkout):focus,
.woocommerce .widget_price_filter .price_slider_amount .button:hover,
.woocommerce .widget_price_filter .price_slider_amount .button:focus,
.wpcf7 .align-center .wpcf7-submit:hover,
.wpcf7 .align-center .wpcf7-submit:focus,
.comments_wrap .form-submit input[type="submit"]:hover,
.comments_wrap .form-submit input[type="submit"]:focus{
    color: {$colors['input_bg_color']}!important;
	background-color: {$colors['text_link']}!important;
}
form.mc4wp-form .mc4wp-form-fields input[type="submit"]:hover,
form.mc4wp-form .mc4wp-form-fields input[type="submit"]:focus{
	color: {$colors['input_bg_color']}!important;
	background-color: {$colors['text_link2']}!important;
}
.woocommerce .widget_shopping_cart .buttons a + a, .woocommerce.widget_shopping_cart .buttons a + a{
    color: {$colors['alter_bg_color']}!important;
	background-color: {$colors['text_dark']};
}
.woocommerce .widget_shopping_cart .buttons a + a:hover, .woocommerce.widget_shopping_cart .buttons a + a:hover{
    color: {$colors['extra_link2']}!important;
	background-color: {$colors['text_link']};
}
.widget_search .search-field,
form.wp-block-search .wp-block-search__input,
.woocommerce.widget_product_search .search_field,
.widget_display_search #bbp_search,
#bbpress-forums #bbp-search-form #bbp_search,
.sc_layouts_row_type_normal .search_wrap .search_field,
.widget_search .search-field:focus,
form.wp-block-search .wp-block-search__input:focus,
.woocommerce.widget_product_search .search_field:focus,
.widget_display_search #bbp_search:focus,
#bbpress-forums #bbp-search-form #bbp_search:focus,
.sc_layouts_row_type_normal .search_wrap .search_field:focus{
    background-color: {$colors['bg_color']};
}
.sidebar .widget .widget_title, .sidebar .widget .widgettitle{
    color: {$colors['extra_dark']};
}
.sc_title.sc_title_accent,
.widget .widget_title,
.widget .widgettitle,
.wp-block-group h1,
.wp-block-group h2,
.wp-block-group h3,
.wp-block-group h4,
.wp-block-group h5,
.wp-block-group h6 {
    background-color: {$colors['extra_bg_color']};
}
.widget ul > li:before{
    background-color: {$colors['text_hover']};
}
.post_info .post_info_item a.post_info_date{
    color: {$colors['text_hover']};
}
.post_info .post_info_item a.post_info_date:hover{
    color: {$colors['text_link']};
}

.widget_calendar th, 
.wp-block-calendar th{
     color: {$colors['text_link']};
}

.widget_calendar caption, 
.wp-block-calendar caption{
    background-color: {$colors['bg_color']};
    color: {$colors['text_link']};
}


.sc_edd_details .downloads_page_tags .downloads_page_data>a:hover, 
.widget_product_tag_cloud a:hover, 
.widget_tag_cloud a:hover, 
.wp-block-tag-cloud a:hover{
     background-color: {$colors['text_hover']};
}

.recentcomments .comment-author-link a, 
.recentcomments .comment-author-link{
    color: {$colors['text_hover']};
}
ul.trx_addons_list_dot>li:before{
    color: {$colors['text_hover']};
}
.wpcf7-form input[type="text"], 
.wpcf7-form input[type="number"], 
.wpcf7-form input[type="email"], 
.wpcf7-form input[type="url"], 
.wpcf7-form input[type="tel"], 
.wpcf7-form input[type="search"], 
.wpcf7-form input[type="password"], 
.wpcf7-form textarea, 
.wpcf7-form select{
     background-color: {$colors['input_bg_color']}!important;
}

.wpcf7-form input[type="text"], 
.wpcf7-form input[type="number"], 
.wpcf7-form input[type="email"], 
.wpcf7-form input[type="url"], 
.wpcf7-form input[type="tel"], 
.wpcf7-form input[type="search"], 
.wpcf7-form input[type="password"], 
.wpcf7-form textarea, 
.wpcf7-form select{
    color: {$colors['input_dark']}!important;
}   
form.mc4wp-form .mc4wp-form-fields input[type="submit"][disabled]{
    color: {$colors['bg_color']} !important;
    background-color: {$colors['text_light']} !important;
}
.wpcf7 .align-center .wpcf7-submit[disabled],
.comments_wrap .form-submit input[type="submit"][disabled],
button[disabled],
input[type="submit"][disabled],
input[type="button"][disabled],
button[disabled]:hover,
input[type="submit"][disabled]:hover,
input[type="button"][disabled]:hover {
	background-color: {$colors['text_dark']} !important;
	color: {$colors['bg_color']}!important;
	border-color: {$colors['text_dark']} !important;
}

table th{
     background-color: {$colors['text_link3']};
}

.woocommerce table.shop_table th{
    background-color: {$colors['extra_bg_color']};
    color: {$colors['extra_dark']};
}
.woocommerce .woocommerce-cart-form table.shop_table_responsive tr td.actions,
.woocommerce .woocommerce-cart-form table.shop_table_responsive tr.woocommerce-cart-form__cart-item td{
     background-color: {$colors['alter_bg_hover']}!important;
}
.woocommerce-cart .cart-collaterals .cart_totals table.shop_table tr td{
      background-color: {$colors['alter_bg_hover']}!important;
      color: {$colors['text_dark']}!important;
}


table th, 
table th + th, 
table td + th,
table td, 
table th + td, 
table td + td{
    border-color:{$colors['alter_bg_color_02']};
}


.sp-view-all-link>a, 
button:not(.components-button), 
input[type="reset"], 
input[type="submit"], 
input[type="button"], 
.post_item .more-link, 
.comments_wrap .form-submit input[type="submit"], 
.wp-block-button:not(.is-style-outline)>.wp-block-button__link, 
#buddypress .comment-reply-link, 
#buddypress .generic-button a, 
#buddypress a.button, 
#buddypress button, 
#buddypress input[type="button"], 
#buddypress input[type="reset"], 
#buddypress input[type="submit"], 
#buddypress ul.button-nav li a, 
a.bp-title-button, 
.booked-calendar-wrap .booked-appt-list .timeslot .timeslot-people button, 
#booked-profile-page .booked-profile-appt-list .appt-block .booked-cal-buttons .google-cal-button>a, 
#booked-profile-page input[type="submit"], 
#booked-profile-page button, 
.booked-list-view input[type="submit"], 
.booked-list-view button, 
table.booked-calendar input[type="submit"], 
table.booked-calendar button, 
.booked-modal input[type="submit"], 
.booked-modal button, 
.sc_button_default, 
.sc_button:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image), 
.socials_share:not(.socials_type_drop) .social_icon, 
.tourmaster-tour-search-wrap input.tourmaster-tour-search-submit[type="submit"], 
#tribe-bar-form .tribe-bar-submit input[type="submit"], 
#tribe-bar-form.tribe-bar-mini .tribe-bar-submit input[type="submit"], 
#tribe-bar-form .tribe-bar-views-toggle, 
#tribe-bar-views li.tribe-bar-views-option, 
#tribe-events .tribe-events-button, 
.tribe-events-button, 
.tribe-events-cal-links a, 
.tribe-events-sub-nav li a, 
.tribe-events .tribe-events-c-search__button,
.tribe-events button.tribe-events-c-search__button,
.tribe-common .tribe-events-c-top-bar .tribe-common-c-btn-border-small,
.tribe-common .tribe-events-c-top-bar a.tribe-common-c-btn-border-small,
.edd_download_purchase_form .button, 
#edd-purchase-button, 
.edd-submit.button, 
.widget_edd_cart_widget .edd_checkout a, 
.sc_edd_details .downloads_page_tags .downloads_page_data>a, 
.mc4wp-form input[type="submit"], 
.woocommerce #respond input#submit, 
.woocommerce .button, 
.woocommerce-page .button, 
.woocommerce a.button, 
.woocommerce-page a.button, 
.woocommerce button.button, 
.woocommerce-page button.button, 
.woocommerce input.button, 
.woocommerce-page input.button, 
.woocommerce input[type="button"], 
.woocommerce-page input[type="button"], 
.woocommerce input[type="submit"], 
.woocommerce-page input[type="submit"], 
.woocommerce #respond input#submit.alt, 
.woocommerce a.button.alt, 
.woocommerce button.button.alt, 
.woocommerce input.button.alt{
    color: {$colors['input_bg_color']}!important;
}

.sp-view-all-link>a:hover, 
button:hover, 
button:focus, 
input[type="submit"]:hover, 
input[type="submit"]:focus, 
input[type="reset"]:hover, 
input[type="reset"]:focus, 
input[type="button"]:hover, 
input[type="button"]:focus, 
.post_item .more-link:hover, 
.comments_wrap .form-submit input[type="submit"]:hover, 
.comments_wrap .form-submit input[type="submit"]:focus, 
.wp-block-button:not(.is-style-outline)>.wp-block-button__link:hover, 
.wp-block-button:not(.is-style-outline)>.wp-block-button__link:focus, 
#buddypress .comment-reply-link:hover, 
#buddypress .generic-button a:hover, 
#buddypress a.button:hover, 
#buddypress button:hover, 
#buddypress input[type="button"]:hover, 
#buddypress input[type="reset"]:hover, 
#buddypress input[type="submit"]:hover, 
#buddypress ul.button-nav li a:hover, 
a.bp-title-button:hover, 
.booked-calendar-wrap .booked-appt-list .timeslot .timeslot-people button:hover, 
body #booked-profile-page .booked-profile-appt-list .appt-block .booked-cal-buttons .google-cal-button>a:hover, 
body #booked-profile-page input[type="submit"]:hover, 
body #booked-profile-page button:hover, 
body .booked-list-view input[type="submit"]:hover, 
body .booked-list-view button:hover, 
body table.booked-calendar input[type="submit"]:hover, 
body table.booked-calendar button:hover, 
body .booked-modal input[type="submit"]:hover, 
body .booked-modal button:hover, 
.sc_button_default:hover, 
.sc_button:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image):hover, 
.socials_share:not(.socials_type_drop) .social_icon:hover, 
.tourmaster-tour-search-wrap input.tourmaster-tour-search-submit[type="submit"]:hover, 
#tribe-bar-form .tribe-bar-submit input[type="submit"]:hover, 
#tribe-bar-form .tribe-bar-submit input[type="submit"]:focus, 
#tribe-bar-form.tribe-bar-mini .tribe-bar-submit input[type="submit"]:hover, 
#tribe-bar-form.tribe-bar-mini .tribe-bar-submit input[type="submit"]:focus, 
#tribe-bar-form .tribe-bar-views-toggle:hover, 
#tribe-bar-views li.tribe-bar-views-option:hover, 
#tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option.tribe-bar-active, 
#tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option.tribe-bar-active:hover, 
#tribe-events .tribe-events-button:hover, 
.tribe-events-sub-nav li a:hover, 
.tribe-events-button:hover, 
.tribe-events-cal-links a:hover, 
.tribe-events .tribe-events-c-search__button:focus,
.tribe-events .tribe-events-c-search__button:hover,
.tribe-events button.tribe-events-c-search__button:focus,
.tribe-events button.tribe-events-c-search__button:hover,
.tribe-common .tribe-events-c-top-bar .tribe-common-c-btn-border-small:focus,
.tribe-common .tribe-events-c-top-bar .tribe-common-c-btn-border-small:hover,
.tribe-common .tribe-events-c-top-bar a.tribe-common-c-btn-border-small:focus,
.tribe-common .tribe-events-c-top-bar a.tribe-common-c-btn-border-small:hover,
.edd_download_purchase_form .button:hover, 
.edd_download_purchase_form .button:active, 
.edd_download_purchase_form .button:focus, 
#edd-purchase-button:hover, 
#edd-purchase-button:active, 
#edd-purchase-button:focus, 
.edd-submit.button:hover, 
.edd-submit.button:active, 
.edd-submit.button:focus, 
.widget_edd_cart_widget .edd_checkout a:hover, 
.sc_edd_details .downloads_page_tags .downloads_page_data>a:hover, 
.mc4wp-form input[type="submit"]:hover, 
.mc4wp-form input[type="submit"]:focus, 
.woocommerce #respond input#submit:hover, 
.woocommerce .button:hover, 
.woocommerce-page .button:hover, 
.woocommerce a.button:hover, 
.woocommerce-page a.button:hover, 
.woocommerce button.button:hover, 
.woocommerce-page button.button:hover, 
.woocommerce input.button:hover, 
.woocommerce-page input.button:hover, 
.woocommerce input[type="button"]:hover, 
.woocommerce-page input[type="button"]:hover, 
.woocommerce input[type="submit"]:hover, 
.woocommerce-page input[type="submit"]:hover{
     color: {$colors['inverse_text']}!important;
}

.scheme_green_dark .sc_button_default:hover,
.scheme_green_dark .sc_button:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image):hover {
    color: {$colors['inverse_text']}!important;
}


.scheme_green_dark .sc_button_default.color_style_link3,
.scheme_green_dark .sc_button.color_style_link3:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image) {
	color: {$colors['alter_hover']};
    background-color: {$colors['text_link2']};
}
.scheme_green_dark .sc_button_default.color_style_link3:hover,
.scheme_green_dark .sc_button.color_style_link3:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image):hover {
	background-color: {$colors['alter_hover2']};
    color: {$colors['alter_hover']}!important;
}


.trx_addons_scroll_to_top, 
.trx_addons_cv .trx_addons_scroll_to_top,
.trx_addons_accent_bg,
.trx_addons_dropcap_style_1,
 blockquote,  .wp-block-pullquote:not(.is-style-solid-color),
.widget_calendar td#today,  .wp-block-calendar td#today,
.widget_twitter .widget_content .sc_twitter_list li:before{
    color: {$colors['input_bg_color']}!important;
}

blockquote:before{
    color: {$colors['input_bg_color']}!important; 
}

.trx_addons_video_player.with_cover .video_hover, 
.format-video .post_featured.with_thumb .post_video_hover, 
.sc_layouts_blog_item_featured .post_featured.with_thumb .post_video_hover{
    color: {$colors['input_bg_color']}!important; 
}
.trx_addons_video_player.with_cover .video_hover:hover, 
.format-video .post_featured.with_thumb .post_video_hover:hover, 
.sc_layouts_blog_item_featured .post_featured.with_thumb .post_video_hover:hover{
    color: {$colors['input_dark']}!important; 
}

.scheme_green_dark .format-video .post_featured.with_thumb .post_video_hover {
    background-color: {$colors['alter_hover']};
}

.sc_layouts_menu_nav>li>a:hover, 
.sc_layouts_menu_nav>li.sfHover>a,
.sc_layouts_menu_nav>li.current-menu-item>a, 
.sc_layouts_menu_nav>li.current-menu-parent>a, 
.sc_layouts_menu_nav>li.current-menu-ancestor>a{
     color: {$colors['text_link2']}!important; 
}

.scheme_green_dark .sc_layouts_menu_nav>li>a:hover,
.scheme_green_dark .sc_layouts_menu_nav>li.sfHover>a,
.scheme_green_dark .sc_layouts_menu_nav>li.current-menu-item>a,
.scheme_green_dark .sc_layouts_menu_nav>li.current-menu-parent>a,
.scheme_green_dark .sc_layouts_menu_nav>li.current-menu-ancestor>a {
    color: {$colors['alter_hover']}!important;  
}

.scheme_green_dark .sc_layouts_menu_nav>li.current-menu-parent>a,
.scheme_green_dark .sc_layouts_menu_nav>li.current-menu-ancestor>a {
    color: {$colors['text_link2']}!important; 
}
.scheme_green_default .top_panel:not(.scheme_dark) .sc_layouts_row_type_normal:not(.scheme_dark) .search_wrap .search_submit:before {
    color: {$colors['inverse_link']}!important;
}
.sc_layouts_menu_popup .sc_layouts_menu_nav>li>a:hover, 
.sc_layouts_menu_popup .sc_layouts_menu_nav>li.sfHover>a, 
.sc_layouts_menu_nav>li li>a:hover, 
.sc_layouts_menu_nav>li li.sfHover>a{
     color: {$colors['text_link3']}!important; 
}
.sc_layouts_menu_mobile_button .sc_layouts_item_icon{
    color: {$colors['extra_link2']}!important; 
    background-color:{$colors['text_link']}!important;
    
}

.post_featured.with_thumb .mejs-playpause-button>button:hover, 
.with_cover .mejs-playpause-button>button:hover{
    color: {$colors['text_link']}!important; 
}

.sticky{
    background-color:{$colors['text_link2']}!important;
    color: {$colors['extra_link2']}!important; 
}
.sticky .post_meta_item.post_date a,
.sticky .post_title a *, 
.sticky .post_title a, 
.sticky .post_title{
    color: {$colors['extra_link2']}!important; 
}
.sticky .post_meta_item.post_date a:hover,
.sticky .post_title a:hover, 
.sticky .post_title:hover{
    color: {$colors['alter_dark']}!important; 
}
.scheme_green_default .post_meta_item.post_date,
.scheme_green_default .post_meta_item.post_date a {
    color: {$colors['alter_hover']}; 
}
.sticky .post_content_inner{
    color: {$colors['alter_link3']}!important; 
}

.single-post .post_item_single, 
.post_layout_excerpt:not(.sticky){
  background-color:{$colors['alter_bg_color']}!important;
}
.sticky .post_meta_item.post_categories a{
    background-color:{$colors['text_dark']}!important;
    color: {$colors['bg_color']}!important; 
}
.sticky .post_meta_item.post_categories a:hover{
    background-color:{$colors['text_link']}!important;
    color: {$colors['bg_color']}!important; 
}
.post_meta_item.post_categories a{
     background-color:{$colors['text_link2']}!important;
     color: {$colors['extra_link2']}!important; 
}
.post_meta_item.post_categories a:hover{
     background-color:{$colors['text_link']}!important;
}

.esg-filters div.esg-navigationbutton, 
.woocommerce nav.woocommerce-pagination ul li a, 
.page_links>a, 
.comments_pagination .page-numbers, 
.nav-links .page-numbers{
    background-color:{$colors['alter_bg_color']};
    color: {$colors['alter_light']}; 
}

.esg-filters div.esg-navigationbutton:hover, 
.esg-filters div.esg-navigationbutton.selected, 
.woocommerce nav.woocommerce-pagination ul li a:hover, 
.woocommerce nav.woocommerce-pagination ul li span.current, 
.page_links>a:hover, 
.page_links>span:not(.page_links_title), 
.comments_pagination a.page-numbers:hover, 
.comments_pagination .page-numbers.current, 
.nav-links a.page-numbers:hover, 
.nav-links .page-numbers.current{
    background-color:{$colors['text_link']};
    color: {$colors['extra_link2']}; 
}

.post_featured.with_thumb .mejs-playpause-button>button:hover, 
.with_cover .mejs-playpause-button>button:hover{
    color: {$colors['alter_dark']}!important;   
}

.sc_slider_controls .slider_controls_wrap>a{
    color: {$colors['extra_link']};  
    background-color: {$colors['extra_link2']};  
} 
.slider_container.slider_controls_side .slider_controls_wrap>a:hover, 
.slider_outer_controls_side .slider_controls_wrap>a:hover{
   color: {$colors['extra_link2']};   
}
 .post_item_single .post_content .post_meta .post_share .socials_type_block .social_item .social_icon{
     color: {$colors['text_link2']}!important;   
}
 .post_item_single .post_content .post_meta .post_share .socials_type_block .social_item:hover .social_icon{
     color: {$colors['text_link']}!important;   
}
.author_info{
    background-color:{$colors['alter_bg_color']};
    color: {$colors['text']}; 
}
.screen-reader-text:hover, .screen-reader-text:active, .screen-reader-text:focus,
.nav-links-single .nav-links .nav-previous, 
.nav-links-single .nav-links .nav-next{
  background-color:{$colors['bg_color']};
}
.comments_list_wrap .comment_reply a{
    color: {$colors['text_link']};
}
.comments_list_wrap .comment_reply a:hover{
    color: {$colors['text_dark']};
}
.author_info .author_title{
     color: {$colors['text_dark']};
}
.author_info a:hover{
    color: {$colors['text_dark']};
}
.post_item_single .post_content .post_meta_single .post_tags a:hover{
     color: {$colors['extra_link2']};
      background-color:{$colors['text_link2']};
}
.nav-links-single .screen-reader-text{
    color: {$colors['text_link2']};
}

.shop_mode_thumbs .fcunited_shop_mode_buttons a.woocommerce_thumbs, 
.shop_mode_list .fcunited_shop_mode_buttons a.woocommerce_list{
    color: {$colors['text_link']};
}

.woocommerce .widget_price_filter .ui-slider .ui-slider-range, 
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle{
    background-color:{$colors['text_link2']};
}
.woocommerce .widget_price_filter .price_slider_amount span{
     color: {$colors['text_link']};
}
.woocommerce.widget_shopping_cart .total,
.woocommerce .widget_shopping_cart .total,
.woocommerce-page.widget_shopping_cart .total,
.woocommerce-page .widget_shopping_cart .total{
    background-color:{$colors['bg_color']};
}
.woocommerce ul.cart_list li > .amount,
.woocommerce ul.product_list_widget li > .amount,
.woocommerce-page ul.cart_list li > .amount,
.woocommerce-page ul.product_list_widget li > .amount,
.woocommerce ul.cart_list li span .amount,
.woocommerce ul.product_list_widget li span .amount,
.woocommerce-page ul.cart_list li span .amount,
.woocommerce-page ul.product_list_widget li span .amount,
.woocommerce ul.cart_list li ins .amount,
.woocommerce ul.product_list_widget li ins .amount,
.woocommerce-page ul.cart_list li ins .amount,
.woocommerce-page ul.product_list_widget li ins .amount{
     color: {$colors['text_link2']};
}

.woocommerce #review_form #respond label:before{
    border-color:{$colors['text_light']}!important; 
}
.woocommerce .woocommerce-product-rating .star-rating span, 
.woocommerce .woocommerce-product-rating .star-rating:before, 
.woocommerce-page .woocommerce-product-rating .star-rating span, 
.woocommerce-page .woocommerce-product-rating .star-rating:before{
    color: {$colors['text_link']};
}
.woocommerce div.product form.cart div.quantity span,
.woocommerce-page div.product form.cart div.quantity span,
.woocommerce .shop_table.cart div.quantity span,
.woocommerce-page .shop_table.cart div.quantity span,
.woocommerce div.product form.cart div.quantity span:hover,
.woocommerce-page div.product form.cart div.quantity span:hover,
.woocommerce .shop_table.cart div.quantity span:hover,
.woocommerce-page .shop_table.cart div.quantity span:hover{
     background-color:{$colors['input_bg_color']};
}
.woocommerce span.onsale,
.single-product div.product .woocommerce-tabs .wc-tabs li:not(.active) a:hover,
.single-product div.product .woocommerce-tabs .wc-tabs li.active a{
    color:{$colors['extra_link2']};
}
.qty-label,
.woocommerce div.product form.cart .variations label{
    color: {$colors['text_dark']};   
}

.woocommerce div.product .product_meta .tagged_as a:hover{
    color: {$colors['text_link']};
}
.woocommerce-tabs.wc-tabs-wrapper:before{
    background-color:{$colors['alter_bg_color']};
}
.woocommerce-page #review_form #respond input[type="text"],
.woocommerce-page #review_form #respond input[type="email"],
.woocommerce #review_form #respond textarea, .woocommerce-page #review_form #respond textarea{
    border-color:{$colors['text_dark']};
}
.woocommerce div.product .woocommerce-tabs ul.tabs{
     background-color:{$colors['text_dark']};
}
.woocommerce table.shop_attributes tr:nth-child(2n+1)>*{
    background-color:{$colors['alter_bg_color']};
    color: {$colors['text_dark']};
}
.woocommerce table.shop_attributes tr:nth-child(2n)>*{
    color: {$colors['text_dark']};
    background-color:{$colors['alter_bg_color']};
}
.woocommerce table.shop_table .second_row td.product-subtotal:before{
      color: {$colors['text_dark']};
}

.woocommerce-orders-table .woocommerce-orders-table__cell a,
.woocommerce-orders-table .woocommerce-orders-table__cell a:hover {
    color: {$colors['inverse_link']};
}

/* Events */
.sc_events_default .sc_events_item{
    background-color:{$colors['alter_bg_color']};
}
.sc_events_default .sc_events_item_button a {
     background-color:{$colors['text_link2']}!important;
}
.sc_events_default .sc_events_item_button a:hover {
     background-color:{$colors['text_link']}!important;
}
.tribe-common .tribe-common-c-btn-border,
.tribe-events .tribe-events-c-ical__link{
    color: {$colors['extra_link2']}!important;
    background-color:{$colors['text_link2']}!important;
    border-color:{$colors['text_link2']}!important;
}
.tribe-events .tribe-events-c-ical__link:hover,
.tribe-common .tribe-common-c-btn-border:hover {
    color: {$colors['extra_link2']}!important;
    background-color:{$colors['text_link']}!important;
    border-color:{$colors['text_link']}!important;
}
.tribe-events .tribe-events-calendar-month__multiday-event-bar-inner{
    background-color:{$colors['text_link']}!important;
}
.tribe-events .tribe-events-calendar-month__multiday-event-bar-title{
    color: {$colors['extra_link2']}!important;
}
.tribe-common--breakpoint-medium.tribe-events .tribe-events-calendar-month__day-date{
    background-color:{$colors['alter_bg_color']}!important;
}
.tribe-events .tribe-events-calendar-month__events{
    background-color:{$colors['alter_bg_hover']};
}
.tribe-events .tribe-events-calendar-month__week,
.tribe-events .tribe-events-calendar-month__day{
    border-color:{$colors['bg_color']}!important;
}
.tribe-events .tribe-events-calendar-month__header-column{
    background-color:{$colors['text_dark']};
}
.tribe-events-calendar-month__header-row .tribe-events-calendar-month__header-column .tribe-events-calendar-month__header-column-title{
    color:{$colors['alter_bg_color']};
}
.tribe-events .tribe-events-calendar-month__day-date-link{
     color: {$colors['text_link']};
}
.tribe-events .tribe-events-calendar-month__day--current .tribe-events-calendar-month__day-date-link{
      color: {$colors['text_link2']};
}
.tribe-events .tribe-events-c-nav__prev:disabled,
.tribe-events .tribe-events-c-nav__next:disabled{
     color: {$colors['alter_bg_color']}!important;
}
.tribe-common .tribe-events-calendar-list__event-date-tag-daynum.tribe-common-h5{
     color: {$colors['text_dark']};
}
.tooltipster-base.tribe-events-tooltip-theme{
     background-color:{$colors['alter_bg_color']};
}
.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-description{
    color: {$colors['text']};
}
.tribe-events .tribe-events-calendar-month__header-column,
.tribe-events-calendar-month__header-column+.tribe-events-calendar-month__header-column{
    border-color:{$colors['alter_bd_hover']};
}
.datepicker table tr td.active:hover, .datepicker table tr td span.active:hover{
    color: {$colors['extra_link2']}!important;
}
.tribe-events-c-messages__message-list-item,
.tribe-events .tribe-events-calendar-day__event-description,
.tribe-events .tribe-events-calendar-list__event-description{
    color: {$colors['text']};
}
.tribe-common .tribe-events-c-day-marker__date,
.tribe-common .tribe-common-h5, 
.tribe-common .tribe-common-h6,
.tribe-events .tribe-events-calendar-day__event-venue,
.tribe-common .tribe-common-h6--min-medium,
.tribe-events .tribe-events-calendar-list__event-venue{
     color: {$colors['text_dark']};
}
.tribe-events .tribe-events-c-events-bar__search-filters-container{
     background-color:{$colors['extra_bg_color']};
}
.tribe-events .tribe-events-header{
    background-color:{$colors['extra_link2']};
}
.tribe-events .tribe-events-c-view-selector__content{
     background-color:{$colors['alter_bg_color']};
}
.tribe-events .tribe-events-c-events-bar__search-button-icon:hover:before{
    color: {$colors['text_link']};
}
.single-tribe_events a.tribe-events-gcal,
.single-tribe_events a.tribe-events-ical,
.single-tribe_events .tribe-events-button.tribe-events-ics{
    color: {$colors['extra_link2']}!important;
    background-color:{$colors['text_link2']}!important;
    border-color:{$colors['text_link2']}!important;
}
.single-tribe_events a.tribe-events-gcal:hover,
.single-tribe_events a.tribe-events-ical:hover,
.single-tribe_events .tribe-events-button.tribe-events-ics:hover{
    color: {$colors['extra_link2']}!important;
    background-color:{$colors['text_link']}!important;
    border-color:{$colors['text_link']}!important;
}

.tribe-common .tribe-events-c-nav__list-item.tribe-events-c-nav__list-item--prev .tribe-events-c-nav__prev,
.tribe-common .tribe-events-c-nav__list-item.tribe-events-c-nav__list-item--next .tribe-events-c-nav__next {
	color: {$colors['inverse_text']};
	background-color: {$colors['text_link']} ;
}

.tribe-common .tribe-events-c-nav__list-item.tribe-events-c-nav__list-item--prev .tribe-events-c-nav__prev:hover,
.tribe-common .tribe-events-c-nav__list-item.tribe-events-c-nav__list-item--next .tribe-events-c-nav__next:hover {
	color: {$colors['inverse_text']};
	background-color: {$colors['text_dark']};
}

div.esg-filter-wrapper .esg-filterbutton.selected>span, 
.mptt-navigation-tabs li.active a, 
.fcunited_tabs .fcunited_tabs_titles li.ui-state-active a{
    color: {$colors['extra_link2']}!important;
    background-color:{$colors['text_link2']}!important;
    border-color:{$colors['text_link2']}!important;
}
div.esg-filter-wrapper .esg-filterbutton.selected>span:hover, 
.mptt-navigation-tabs li.active a:hover, 
.fcunited_tabs .fcunited_tabs_titles li.ui-state-active a:hover{
    color: {$colors['extra_link2']}!important;
    background-color:{$colors['text_link']}!important;
    border-color:{$colors['text_link']}!important;
}

.slider_container .swiper-pagination-progressbar .swiper-pagination-progressbar-fill, 
.slider_outer .swiper-pagination-progressbar .swiper-pagination-progressbar-fill{
     background-color:{$colors['text_link']}!important;
}

.scheme_self.sc_blogger_line_default .swiper-pagination-progressbar{
    background-color:{$colors['extra_bd_hover']}!important;
}


.swiper-pagination-progressbar{
    background-color:{$colors['alter_bg_color']}!important;
}


.slider_line_accents_bg .slider_container .swiper-pagination-progressbar .swiper-pagination-progressbar-fill, 
.slider_line_accents_bg .slider_outer .swiper-pagination-progressbar .swiper-pagination-progressbar-fill{
     background-color:{$colors['text_link2']}!important;
}

.slider_line_accents_bg .swiper-pagination-progressbar{
    background-color:{$colors['bg_color']}!important;
}


.elementor-shortcode .woocommerce ul.products li.product .post_data,
.elementor-shortcode .woocommerce-page ul.products li.product .post_data{
    background-color:{$colors['alter_bg_color']};
}
.scheme_green_default .woocommerce ul.products li.product .post_header .post_tags a {
    color: {$colors['alter_hover']};
}
.scheme_green_default .woocommerce ul.products li.product .post_header .post_tags a:hover {
    color: {$colors['text_link']};
}
.sp-template-event-blocks .sp-event-date a{
     color: {$colors['text_link']}!important;
}
.sp-template-event-blocks .sp-event-date a:hover{
     color: {$colors['text_dark']}!important;
}

.sp-league-table.sp-sortable-table.sp-data-table.sp-scrollable-table tbody tr td:first-child,
.sp-league-table.sp-sortable-table.sp-data-table.sp-scrollable-table thead tr th{
    background-color:{$colors['text_link3']}!important;
    color: {$colors['extra_link2']}!important;
}
.sp-league-table.sp-sortable-table.sp-data-table.sp-scrollable-table  tbody tr td{
    background-color:{$colors['alter_hover3']}!important;
    color: {$colors['extra_link2']}!important;
}
.sp-league-table tbody tr td a{ 
    color: {$colors['extra_link2']}!important; 
}
.sp-league-table tbody tr td a:hover{
    color: {$colors['extra_link2_05']}!important; 
}
.sportspress .sp-data-table.sp-sortable-table thead tr:last-child,
.sportspress .sp-data-table.sp-sortable-table tr + tr{
     border-color:{$colors['text_hover']}!important;
}

div.sp-section-content.sp-section-content-performance tbody tr + tr,
div.sp-section-content.sp-section-content-details tbody tr + tr,
div.sp-section-content.sp-section-content-results tbody tr + tr,
div.sp-section-content.sp-section-content-officials tbody tr + tr,
div .sp-template-event-venue .sp-event-venue tbody tr + tr,
.sp-template-event-logos-block .sp-table-wrapper .sp-data-table tbody tr + tr{
     border-color:{$colors['bd_color']}!important;
}


.sc_recent_news_style_news-plain .post_item:not(.post_size_small) .post_featured .post_info, 
.sc_recent_news_style_news-plain .post_size_small{
     background-color:{$colors['alter_bg_color']}!important;
}
.sc_blogger.sc_blogger_line .sc_blogger_item_content{
      background-color:{$colors['extra_bd_hover']};
}
.sc_blogger.sc_blogger_line .sc_blogger_item_content .sc_blogger_item_title a {
      color: {$colors['extra_link2']};
}
.sc_blogger.sc_blogger_line .sc_blogger_item_content .sc_blogger_item_title a:hover {
      color: {$colors['text_link']};
}
.scheme_green_default .sc_blogger_line .meta-role-wrap span {
      color: {$colors['alter_hover']};
}
.extra-countdown .sp-countdown-wrapper .countdown.sp-countdown time span small{
    color: {$colors['text_link2']}!important;
}
.sp-template-event-blocks:not(.sp-template-event-logos-block) .sp-data-table.sp-event-blocks  tbody td{
    background-color:{$colors['bg_color']}!important;
}
.bg_color{
    background-color:{$colors['bg_color']}!important;
}
.sc_promo.sc_promo_default .sc_promo_text .sc_promo_text_inner .sc_item_button .sc_button{
    background-color:{$colors['text_link2']}!important;
}
.sc_promo.sc_promo_default .sc_promo_text .sc_promo_text_inner .sc_item_button .sc_button:hover{
    background-color:{$colors['text_link']}!important;
}
.sc_item_filters{
    background-color:{$colors['alter_dark']}!important;
}
.sc_item_filters_header *{
     color: {$colors['alter_bg_color']}!important;
}
.sc_item_filters_tabs{
    background-color:{$colors['text_hover3']}!important; 
}
.sc_item_filters + .sc_item_posts_container:before {
    background-color:{$colors['alter_bg_color']}!important;
}

.extra-table .sc_table table>tbody>tr:nth-child(2n)>td,
.extra-table .sc_table table>tbody>tr:nth-child(2n+1)>td{
    background-color:{$colors['bg_color']}!important;
    color: {$colors['text']}!important;
    border-color:{$colors['alter_bg_color']}!important;
}
.extra-table table tr td:first-child h5 + p {
    color: {$colors['text_link']}!important;
}
.extra-table .sc_table table tr h4 + p{
    color: {$colors['text_link2']}!important;
}

.sc_layouts_row_type_normal .sc_layouts_item a:not(.sc_button):not(.button):not(.elementor-button), 
.scheme_self.sc_layouts_row_type_normal .sc_layouts_item a:not(.sc_button):not(.button):not(.elementor-button){
     color: {$colors['text_dark']};
}
.sc_icons .sc_icons_icon{
     color: {$colors['text_link2']}!important;
}
.event_custom_bg  .sc_events_default .sc_events_item {
     background-color:{$colors['bg_color']}!important;
}
.sc_icons_default .sc_icons_columns_wrap>[class*="trx_addons_column-"] .sc_icons_item{
    background-color:{$colors['extra_link2']}!important;
}
.sc_icons_default .sc_icons_item_title{
    color: {$colors['text_hover2']};
}
.scheme_self.sc_promo .sc_promo_text_inner{
    background-color:{$colors['extra_link3']}!important; 
}
.scheme_self.sc_promo .sc_promo_title{
     color: {$colors['text_dark']}!important;
}
.scheme_self.elementor-widget-trx_sc_icons .sc_icons_default .sc_icons_item_title{
     color: {$colors['text_dark']}!important;
}

.scheme_self.elementor-widget-trx_sc_icons  .sc_icons_default .sc_icons_columns_wrap>[class*="trx_addons_column-"] .sc_icons_item{
     background-color:{$colors['extra_hover3']}!important; 
}
ul[class*="trx_addons_list_success"] > li:before{
     color: {$colors['text_link2']};
}
.scheme_self.white_bg:before,
.white_bg:before{
     background-color:{$colors['alter_bg_color']}!important; 
}
.green_bg:before{
     background-color:{$colors['text_link2']}!important; 
}
.dark_bg:before{
     background-color:{$colors['inverse_bd_hover']}!important; 
}
.dark_bg .post_meta_item.post_date,
.dark_bg .sc_item_subtitle,
.green_bg .post_meta_item.post_date,
.green_bg .sc_item_subtitle{
    color:{$colors['extra_link2']}!important; 
}

.green_bg .sc_blogger_item_content .sc_blogger_item_title a:hover{
     color:{$colors['text_dark']}!important; 
}

.sc_recent_news_style_news-excerpt .post_item  .post_content{
    color:{$colors['alter_light']}; 
}
.sc_layouts_row_type_normal .custom_color .sc_layouts_item_icon{
    background-color:{$colors['text_link']}!important; 
    color:{$colors['extra_link2']}; 
}
.sc_layouts_row_type_normal .custom_color .sc_layouts_item_icon:hover{
    background-color:{$colors['extra_link2']}!important; 
    color:{$colors['text_link']}; 
}
.sc_layouts_cart_items_short,
.scheme_self.sc_layouts_item .sc_layouts_cart_items_short{
	background-color: {$colors['alter_bg_color']};
	color: {$colors['text_dark']};
}
.sc_layouts_row_type_normal .custom_input_bg .search_wrap .search_field{
    background-color: {$colors['input_bg_color_02']};
    color:{$colors['extra_link2']};
}
.sc_layouts_row_type_normal .custom_input_bg .search_wrap .search_submit:before{
    color: {$colors['input_bg_color']};
}
.sc_layouts_row_type_normal .custom_input_bg .search_wrap .search_submit:hover:before{
    color: {$colors['text_link']};
}
.sc_layouts_row_type_normal .custom_input_bg .search_wrap .search_field::placeholder{
    color:{$colors['extra_link2']};
}
.price_info_title{
    background-color: {$colors['inverse_bd_color']}; 
}
.sc_price_item .sc_price_item_title{
    color: {$colors['extra_link2']};
}
.scheme_self.elementor-widget-trx_sc_price .sc_price_item_info{
     border-color: {$colors['alter_bg_color']}; 
}

.sc_price_item_info{
    border-color: {$colors['alter_hover2']}; 
    background-color: {$colors['alter_hover2']}; 
}

.sc_price_item .sc_price_item_description, 
.sc_price_item .sc_price_item_details{
     color: {$colors['alter_light']};
}
.product .post_featured .mask,
.post_item:hover .post_featured.hover_shop .mask,
.post_item:hover .post_featured.hover_shop:hover .mask,
.woocommerce ul.products li.product .post_featured > a:before{
     background-color: {$colors['alter_bg_color_07']}; 
}
.scheme_green_default .woocommerce ul.products li.product .price,
.scheme_green_default .woocommerce-page ul.products li.product .price,
.scheme_green_default .woocommerce ul.products li.product .price ins,
.scheme_green_default .woocommerce-page ul.products li.product .price ins {
    color: {$colors['alter_hover']};
}
.woocommerce-table__product-name.product-name a,
.woocommerce-table__product-name.product-name a:hover {
    color: {$colors['extra_link2']};
}
.scheme_green_default ul.products p.amount,
.scheme_green_default ul.products span.amount {
    color: {$colors['alter_hover']};
}
.post_featured.hover_shop .icons a{
    background-color: {$colors['text_dark']}!important; 
}
.post_featured.hover_shop .icons a:hover{
    background-color: {$colors['text_link']}!important; 
}
.sportspress .sp-data-table.sp-player-list thead tr:last-child,
.sportspress .sp-data-table.sp-event-blocks tr + tr,
.sportspress .sp-data-table.sp-player-list tr + tr{
     border-color: {$colors['bd_color']}!important; 
}
[class*="sc_input_hover_"].sc_input_hover_iconed input[type="text"],
[class*="sc_input_hover_"].sc_input_hover_iconed input[type="number"],
[class*="sc_input_hover_"].sc_input_hover_iconed input[type="email"],
[class*="sc_input_hover_"].sc_input_hover_iconed input[type="password"],
[class*="sc_input_hover_"].sc_input_hover_iconed input[type="search"], 
[class*="sc_input_hover_"].sc_input_hover_iconed textarea{
     border-color: {$colors['text_dark']}; 
}
[class*="sc_input_hover_"].sc_input_hover_iconed input[type="text"]:focus,
[class*="sc_input_hover_"].sc_input_hover_iconed input[type="number"]:focus,
[class*="sc_input_hover_"].sc_input_hover_iconed input[type="email"]:focus,
[class*="sc_input_hover_"].sc_input_hover_iconed input[type="password"]:focus,
[class*="sc_input_hover_"].sc_input_hover_iconed input[type="search"]:focus, 
[class*="sc_input_hover_"].sc_input_hover_iconed textarea:focus{
     border-color: {$colors['text_link']}; 
}
.trx_addons_popup button.mfp-close{
    color: {$colors['text_link']}!important; 
}

input[type="checkbox"]+.wpcf7-list-item-label:before,
.trx_addons_popup_form_field_agree input[type="checkbox"] + label:before,
.trx_addons_popup_form_login input[type="checkbox"] + label:before{
    border-color: {$colors['text_light']}!important; 
}
.sp-template.sp-template-player-statistics .data-team a:hover {
    color: {$colors['extra_dark']} !important;
}

.slider_outer.slider_outer_pagination_pos_bottom_outside .swiper-pagination-bullets .swiper-pagination-bullet{
    border-color: {$colors['text_dark']}; 
    background-color: {$colors['text_dark']}; 
}

.slider_outer.slider_outer_pagination_pos_bottom_outside .slider_pagination_wrap .swiper-pagination-bullet.swiper-pagination-bullet-active{
    border-color: {$colors['alter_link']}; 
    background-color: {$colors['alter_link']};
}

.scheme_green_default .sc_testimonials_item_content:before {
    color: {$colors['alter_hover']};
}
.scheme_green_default .sc_price_item_details ul li + li {
    border-color: {$colors['input_bg_color']};
}

#elegro-reset-wrapper .elegro-widget__button,
#elegro-reset-wrapper .elegro-widget__button--instant{
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
	border-color: {$colors['text_link']};
}

#elegro-reset-wrapper .elegro-widget__button:hover,
#elegro-reset-wrapper .elegro-widget__button--instant:hover{
	color: {$colors['inverse_hover']};
	background-color: {$colors['text_dark']}!important;
	border-color: {$colors['text_dark']}!important;
}

.woocommerce .quantity input.qty, 
.woocommerce #content .quantity input.qty, 
.woocommerce-page .quantity input.qty, 
.woocommerce-page #content .quantity input.qty,
.select_container select {
	color: {$colors['text']};
}

p > a[rel=magnific]:has(> img):after {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}

table > tbody > tr:nth-child(2n+1) > td,
table > tbody > tr:nth-child(2n+1) > td strong,
.woocommerce table.shop_table > tbody > tr:nth-child(2n+1) > td span.amount { 
    color: {$colors['extra_link2']};
}

CSS;
		}

		return $css;
	}
}

