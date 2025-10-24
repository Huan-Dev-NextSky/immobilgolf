<?php
/**
 * Plugin Name: Immobilgolf Elementor
 * Plugin URI: 
 * Description:
 * Version: 1.0.0
 * Author: Immobilgolf
 * Author URI:
 * Text Domain: 
*/

if ( file_exists( plugin_dir_path( __FILE__ ). 'inc/elementor-extension.php' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'inc/elementor-extension.php' );
}
add_action( 'wp_enqueue_scripts', 'immobilgolf_register_script' );
function immobilgolf_register_script(){
	wp_enqueue_style( 'immobilgolf-style', plugin_dir_url( __FILE__ ) . 'assets/style.css' );
	wp_enqueue_style( 'immobilgolf-leaflet', plugin_dir_url( __FILE__ ) . 'assets/leaflet.css' );
	wp_enqueue_style( 'immobilgolf-style-noUiSlider', plugin_dir_url( __FILE__ ) . 'assets/noUiSlider.css' );
	wp_enqueue_script( 'immobilgolf-script-noUiSlider', plugin_dir_url( __FILE__ ) . 'assets/noUiSlider.js', array('jquery'), '', true );
	wp_enqueue_script( 'immobilgolf-script', plugin_dir_url( __FILE__ ) . 'assets/script.js', array('jquery'), '', true );
}