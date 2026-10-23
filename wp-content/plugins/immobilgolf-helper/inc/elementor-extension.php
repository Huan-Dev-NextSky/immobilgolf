<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

final class Immobilgolf_Elementor_Extension {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	public function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}
	public function i18n() {
		load_plugin_textdomain( 'immobilgolf' );
	}
	public function init() {
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );
		
	}
	public function init_widgets() {
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/property.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Immobilgolf_Property_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/agencies.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Immobilgolf_Agencies_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/map-filter.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Immobilgolf_MapFilter_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/agencies-filter.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Immobilgolf_AgenciesFilter_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/auth-form.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Immobilgolf_Auth_Form_Element() );
	}
}
Immobilgolf_Elementor_Extension::instance();

function immobilgolf_add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'immobilgolf',
			[
				'title' => __( 'Immobilgolf Elements', 'immobilgolf' ),
				'icon' => 'fa fa-star',
			]
		);

	}
add_action( 'elementor/elements/categories_registered', 'immobilgolf_add_elementor_widget_categories' );