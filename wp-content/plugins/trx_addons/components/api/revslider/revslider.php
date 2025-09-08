<?php
/**
 * Plugin support: Revolution Slider
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if RevSlider installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_addons_exists_revslider' ) ) {
	function trx_addons_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}
*/

// Return RevSliders list, prepended inherit (if need)
if ( !function_exists( 'trx_addons_get_list_revsliders' ) ) {
	function trx_addons_get_list_revsliders($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = array();
			if (trx_addons_exists_revslider()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT alias, title FROM " . esc_sql($wpdb->prefix) . "revslider_sliders" );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->alias] = $row->title;
					}
				}
			}
		}
		return $prepend_inherit ? array_merge(array('inherit' => esc_html__("Inherit", 'trx_addons')), $list) : $list;
	}
}

// Allow loading RevSlider scripts and styles
// if it present in the content of the current page
if (!function_exists('trx_addons_check_revslider_in_content')) {
	add_filter( 'revslider_include_libraries', 'trx_addons_check_revslider_in_content' );
	function trx_addons_check_revslider_in_content($load, $post_id=-1) {
		if ( ! $load ) {
			// Load if current page is builder preview
			$load = ( function_exists('trx_addons_elm_is_preview') && trx_addons_elm_is_preview() )
					||
				 	( function_exists('trx_addons_gutenberg_is_preview') && trx_addons_gutenberg_is_preview() );
			if ( ! $load ) {
				if ( $post_id < 0 ) {
					$post_id = trx_addons_get_the_ID();
				}
				if ( $post_id > 0 ) {
					$post = get_post( $post_id );
					$content = ! empty( $post->post_content ) ? $post->post_content : '';
					// Check shortcode
					$load = is_string($content)
								&& strpos($content, '[rev_slider') !== false; 				// Shortcode rev_slider
					// Check in Gutenberg
					if ( trx_addons_exists_gutenberg() ) {
						$load = is_string($content)
									&& strpos($content, 'wp:trx-addons/slider') !== false 	// Our widget slider with param "engine" == "revo"
										&& strpos($content, '"engine":"revo"') !== false;
					}
					// Check in VC
					if ( ! $load && trx_addons_exists_vc() ) {
						$load = is_string($content)
									&& strpos($content, '[trx_widget_slider') !== false 	// Our widget slider with param "engine" == "revo"
										&& strpos($content, 'engine="revo"') !== false;	
					}
					// Check in Elementor
					if ( ! $load && trx_addons_exists_elementor() ) {
						$cur_page_built_with_elementor = trx_addons_is_built_with_elementor( $post_id );
						if ( $cur_page_built_with_elementor ) {
							$meta = get_post_meta( $post_id, "_elementor_data", true );
							$load = is_string($meta)
										&& (
											( strpos($meta, '"widgetType":"trx_widget_slider"') !== false 			// Our widget slider with param "engine" == "revo"
												&& strpos($meta, '"engine":"revo"') !== false
											)
											||
											strpos($meta, '"widgetType":"wp-widget-rev-slider-widget"') !== false 	// WordPress widget "RevSlider"
										);
						}
					}
				}
			}
		}
		return $load;
	}
}

if ( ! function_exists( 'trx_addons_revslider_disable_welcome_screen' ) ) {
	add_action( 'admin_init', 'trx_addons_revslider_disable_welcome_screen', 0 );
	/**
	 * Disable welcome screen for the RevSlider plugin while the demo data is importing or plugins are installing
	 * 
	 * @hooked admin_init
	 */
	function trx_addons_revslider_disable_welcome_screen() {
		if ( trx_addons_exists_revslider() && class_exists( 'RevSliderAdmin' )
			&& (
				trx_addons_check_url( 'admin.php' ) && trx_addons_get_value_gp( 'page' ) == 'trx_addons_theme_panel'
				||
				(int) trx_addons_get_value_gp( 'admin-multi' ) == 1
				||
				trx_addons_get_value_gp( 'page' ) == 'tgmpa-install-plugins'
			) 
		) {
			//remove_action( 'admin_init', array( 'RevSliderAdmin', 'open_welcome_page' ) );
			trx_addons_remove_filter( 'admin_init', 'open_welcome_page' );
		}
	}
}

// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Gutenberg
if ( trx_addons_exists_revslider() && trx_addons_exists_gutenberg() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'revslider/revslider-sc-gutenberg.php';
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'revslider/revslider-demo-importer.php';
}

// OCDI support
if ( is_admin() && trx_addons_exists_revslider() && trx_addons_exists_ocdi() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'revslider/revslider-demo-ocdi.php';
}
