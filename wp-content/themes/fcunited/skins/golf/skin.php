<?php
/**
 * Skins support: Main skin file for the skin 'Default'
 *
 * Setup skin-dependent fonts and colors, load scripts and styles,
 * and other operations that affect the appearance and behavior of the theme
 * when the skin is activated
 *
 * @package WordPress
 * @subpackage FCUNITED
 * @since FCUNITED 1.0.46
 */


// Theme storage
//-------------------------------------------------------------------------

fcunited_storage_set('theme_demo_url', '//golf.fc-united.axiomthemes.com');


// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'fcunited_skin_theme_setup3' ) ) {
	add_action( 'after_setup_theme', 'fcunited_skin_theme_setup3', 3 );
	function fcunited_skin_theme_setup3() {
		// ToDo: Add / Modify theme options, color schemes, required plugins, etc.


        if ( fcunited_exists_woocommerce() ) {

            // Section 'WooCommerce'
            fcunited_storage_set_array_before(
                'options', 'fonts', array_merge(
                    array(
                        'shop'               => array(
                            'title'      => esc_html__( 'Shop', 'fcunited' ),
                            'desc'       => wp_kses_data( __( 'Select theme-specific parameters to display the shop pages', 'fcunited' ) ),
                            'priority'   => 80,
                            'expand_url' => esc_url( fcunited_woocommerce_get_shop_page_link() ),
                            'type'       => 'section',
                        ),

                        'products_info_shop' => array(
                            'title'  => esc_html__( 'Products list', 'fcunited' ),
                            'desc'   => '',
                            'qsetup' => esc_html__( 'General', 'fcunited' ),
                            'type'   => 'info',
                        ),
                        'shop_mode'          => array(
                            'title'   => esc_html__( 'Shop style', 'fcunited' ),
                            'desc'    => wp_kses_data( __( 'Select style for the products list. Attention! If the visitor has already selected the list type at the top of the page - his choice is remembered and has priority over this option', 'fcunited' ) ),
                            'std'     => 'thumbs',
                            'options' => array(
                                'thumbs' => esc_html__( 'Grid', 'fcunited' ),
                                'list'   => esc_html__( 'List', 'fcunited' ),
                            ),
                            'qsetup'  => esc_html__( 'General', 'fcunited' ),
                            'type'    => 'select',
                        ),
                    ),
                    ! get_theme_support( 'wc-product-grid-enable' )
                        ? array(
                        'posts_per_page_shop' => array(
                            'title' => esc_html__( 'Products per page', 'fcunited' ),
                            'desc'  => wp_kses_data( __( 'How many products should be displayed on the shop page. If empty - use global value from the menu Settings - Reading', 'fcunited' ) ),
                            'std'   => '',
                            'type'  => 'text',
                        ),
                        'blog_columns_shop'   => array(
                            'title'      => esc_html__( 'Grid columns', 'fcunited' ),
                            'desc'       => wp_kses_data( __( 'How many columns should be used for the shop products in the grid view (from 2 to 4)?', 'fcunited' ) ),
                            'dependency' => array(
                                'shop_mode' => array( 'thumbs' ),
                            ),
                            'std'        => 2,
                            'options'    => fcunited_get_list_range( 2, 4 ),
                            'type'       => 'select',
                        ),
                    )
                        : array(),
                    array(
                        'shop_hover'              => array(
                            'title'   => esc_html__( 'Hover style', 'fcunited' ),
                            'desc'    => wp_kses_data( __( 'Hover style on the products in the shop archive', 'fcunited' ) ),
                            'std'     => 'shop',
                            'options' => apply_filters(
                                'fcunited_filter_shop_hover', array(
                                    'none'         => esc_html__( 'None', 'fcunited' ),
                                    'shop'         => esc_html__( 'Icons', 'fcunited' ),
                                )
                            ),
                            'qsetup'  => esc_html__( 'General', 'fcunited' ),
                            'type'    => 'select',
                        ),

                        'single_info_shop'        => array(
                            'title' => esc_html__( 'Single product', 'fcunited' ),
                            'desc'  => '',
                            'type'  => 'info',
                        ),
                        'single_product_layout'      => array(
                            'title'      => esc_html__( 'Layout of the single product', 'fcunited' ),
                            'desc'       => wp_kses_data( __( 'Select layout of the single products page', 'fcunited' ) ),
                            'std'        => 'default',
                            'override' => array(
                                'mode'    => 'product',
                                'section' => esc_html__( 'Content', 'fcunited' ),
                            ),
                            'options'    => apply_filters(
                                'fcunited_filter_woocommerce_single_product_layouts',
                                array(
                                    'default'   => esc_html__( 'Default', 'fcunited' ),
                                    'stretched' => esc_html__( 'Stretched', 'fcunited' ),
                                )
                            ),
                            'type'       => 'hidden',
                        ),
                        'show_related_posts_shop' => array(
                            'title'  => esc_html__( 'Show related products', 'fcunited' ),
                            'desc'   => wp_kses_data( __( "Show section 'Related products' on the single product page", 'fcunited' ) ),
                            'std'    => 1,
                            'type'   => 'checkbox',
                        ),
                        'related_posts_shop'      => array(
                            'title'      => esc_html__( 'Related products', 'fcunited' ),
                            'desc'       => wp_kses_data( __( 'How many related products should be displayed on the single product page?', 'fcunited' ) ),
                            'dependency' => array(
                                'show_related_posts_shop' => array( 1 ),
                            ),
                            'std'        => 4,
                            'options'    => fcunited_get_list_range( 1, 9 ),
                            'type'       => 'select',
                        ),
                        'related_columns_shop'    => array(
                            'title'      => esc_html__( 'Related columns', 'fcunited' ),
                            'desc'       => wp_kses_data( __( 'How many columns should be used to output related products on the single product page?', 'fcunited' ) ),
                            'dependency' => array(
                                'show_related_posts_shop' => array( 1 ),
                            ),
                            'std'        => 4,
                            'options'    => fcunited_get_list_range( 1, 4 ),
                            'type'       => 'select',
                        ),
                    ),
                    fcunited_options_get_list_cpt_options( 'shop' )
                )
            );
        }

	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'fcunited_skin_tgmpa_required_plugins' ) ) {
	add_filter( 'fcunited_filter_tgmpa_required_plugins', 'fcunited_skin_tgmpa_required_plugins', 100);
	function fcunited_skin_tgmpa_required_plugins( $list = array() ) {
		// ToDo: Check if plugin is in the 'required_plugins' and add his parameters to the TGMPA-list
		//       Replace 'skin-specific-plugin-slug' to the real slug of the plugin
		if ( fcunited_storage_isset( 'required_plugins', 'sportspress' ) && fcunited_storage_get_array( 'required_plugins', 'sportspress', 'install' ) !== false ) {
			$list[] = array(
                'name'     => fcunited_storage_get_array( 'required_plugins', 'sportspress-for-golf', 'title' ),
                'slug'     => 'sportspress-for-golf',
                'required' => false,
            );
		}
		return $list;
	}
}

// Enqueue skin-specific styles and scripts
// Priority 1150 - after plugins-specific (1100), but before child theme (1200)
if ( ! function_exists( 'fcunited_skin_frontend_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'fcunited_skin_frontend_scripts', 1150 );
	function fcunited_skin_frontend_scripts() {
		$fcunited_url = fcunited_get_file_url( FCUNITED_SKIN_DIR . 'skin.css' );
		if ( '' != $fcunited_url ) {
			wp_enqueue_style( 'fcunited-skin-' . esc_attr( FCUNITED_SKIN_NAME ), $fcunited_url, array(), null );
		}
		if ( fcunited_is_on( fcunited_get_theme_option( 'debug_mode' ) ) ) {
			$fcunited_url = fcunited_get_file_url( FCUNITED_SKIN_DIR . 'skin.js' );
			if ( '' != $fcunited_url ) {
				wp_enqueue_script( 'fcunited-skin-' . esc_attr( FCUNITED_SKIN_NAME ), $fcunited_url, array( 'jquery' ), null, true );
			}
		}
	}
}

// Enqueue skin-specific responsive styles
// Priority 2050 - after theme responsive 2000
if ( ! function_exists( 'fcunited_skin_styles_responsive' ) ) {
	add_action( 'wp_enqueue_scripts', 'fcunited_skin_styles_responsive', 2050 );
	function fcunited_skin_styles_responsive() {
		$fcunited_url = fcunited_get_file_url( FCUNITED_SKIN_DIR . 'skin-responsive.css' );
		if ( '' != $fcunited_url ) {
			wp_enqueue_style( 'fcunited-skin-' . esc_attr( FCUNITED_SKIN_NAME ) . '-responsive', $fcunited_url, array(), null );
		}
	}
}

// Merge custom scripts
if ( ! function_exists( 'fcunited_skin_merge_scripts' ) ) {
	add_filter( 'fcunited_filter_merge_scripts', 'fcunited_skin_merge_scripts' );
	function fcunited_skin_merge_scripts( $list ) {
		if ( fcunited_get_file_dir( FCUNITED_SKIN_DIR . 'skin.js' ) != '' ) {
			$list[] = FCUNITED_SKIN_DIR . 'skin.js';
		}
		return $list;
	}
}

// Set theme specific importer options
if ( ! function_exists( 'fcunited_skin_importer_set_options' ) ) {
	add_filter('trx_addons_filter_importer_options', 'fcunited_skin_importer_set_options', 9);
	function fcunited_skin_importer_set_options($options = array()) {
		if ( is_array( $options ) ) {
			$rtl_url = is_rtl() ? 'rtl.' : '';
			$options['demo_type'] = 'golf';
			$options['files']['golf'] = $options['files']['default'];
			$options['files']['golf']['title'] = esc_html__('Golf Demo', 'fcunited');
			$options['files']['golf']['domain_demo'] = esc_url( fcunited_get_protocol() . '://golf.fc-united.axiomthemes.com' );   // Demo-site domain
            unset($options['files']['default']);
		}
		return $options;
	}
}


if ( ! function_exists( 'fcunited_customizer_theme_setup' ) ) {
    add_action( 'after_setup_theme', 'fcunited_customizer_theme_setup', 4 );
    function fcunited_customizer_theme_setup() {

        fcunited_storage_set(
            'load_fonts', array(
                // Google font
                array(
                    'name'   => 'Open Sans',
                    'family' => 'sans-serif',
                    'styles' => '300,300i,400,400i,500,500i,600,600i,700,700i,800',
                ),
            )
        );

        // Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
        fcunited_storage_set( 'load_fonts_subset', 'latin,latin-ext' );


        fcunited_storage_set(
            'theme_fonts', array(
                'p'       => array(
                    'title'           => esc_html__( 'Main text', 'fcunited' ),
                    'description'     => esc_html__( 'Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'fcunited' ),
                    'font-family'     => '"Open Sans",sans-serif',
                    'font-size'       => '1rem',
                    'font-weight'     => '400',
                    'font-style'      => 'normal',
                    'line-height'     => '1.75em',
                    'text-decoration' => 'none',
                    'text-transform'  => 'none',
                    'letter-spacing'  => '0px',
                    'margin-top'      => '0em',
                    'margin-bottom'   => '1.6em',
                ),
                'h1'      => array(
                    'title'           => esc_html__( 'Heading 1', 'fcunited' ),
                    'font-family'     => '"Open Sans",sans-serif',
                    'font-size'       => '5.625em',
                    'font-weight'     => '300',
                    'font-style'      => 'normal',
                    'line-height'     => '1.1em',
                    'text-decoration' => 'none',
                    'text-transform'  => '',
                    'letter-spacing'  => '0px',
                    'margin-top'      => '.57em',
                    'margin-bottom'   => '0.3em',
                ),
                'h2'      => array(
                    'title'           => esc_html__( 'Heading 2', 'fcunited' ),
                    'font-family'     => '"Open Sans",sans-serif',
                    'font-size'       => '3.4375em',
                    'font-weight'     => '300',
                    'font-style'      => 'normal',
                    'line-height'     => '1.1em',
                    'text-decoration' => 'none',
                    'text-transform'  => '',
                    'letter-spacing'  => '0px',
                    'margin-top'      => '1.1em',
                    'margin-bottom'   => '0.55em',
                ),
                'h3'      => array(
                    'title'           => esc_html__( 'Heading 3', 'fcunited' ),
                    'font-family'     => '"Open Sans",sans-serif',
                    'font-size'       => '2.5em',
                    'font-weight'     => '300',
                    'font-style'      => 'normal',
                    'line-height'     => '1.3em',
                    'text-decoration' => 'none',
                    'text-transform'  => '',
                    'letter-spacing'  => '0px',
                    'margin-top'      => '1.5em',
                    'margin-bottom'   => '0.52em',
                ),
                'h4'      => array(
                    'title'           => esc_html__( 'Heading 4', 'fcunited' ),
                    'font-family'     => '"Open Sans",sans-serif',
                    'font-size'       => '1.875em',
                    'font-weight'     => '300',
                    'font-style'      => 'normal',
                    'line-height'     => '1.06em',
                    'text-decoration' => 'none',
                    'text-transform'  => '',
                    'letter-spacing'  => '0px',
                    'margin-top'      => '2.3em',
                    'margin-bottom'   => '0.9em',
                ),
                'h5'      => array(
                    'title'           => esc_html__( 'Heading 5', 'fcunited' ),
                    'font-family'     => '"Open Sans",sans-serif',
                    'font-size'       => '1.25em',
                    'font-weight'     => '400',
                    'font-style'      => 'normal',
                    'line-height'     => '1.3em',
                    'text-decoration' => 'none',
                    'text-transform'  => '',
                    'letter-spacing'  => '0px',
                    'margin-top'      => '3.2em',
                    'margin-bottom'   => '0.7em',
                ),
                'h6'      => array(
                    'title'           => esc_html__( 'Heading 6', 'fcunited' ),
                    'font-family'     => '"Open Sans",sans-serif',
                    'font-size'       => '1em',
                    'font-weight'     => '400',
                    'font-style'      => 'normal',
                    'line-height'     => '1.375em',
                    'text-decoration' => 'none',
                    'text-transform'  => '',
                    'letter-spacing'  => '0px',
                    'margin-top'      => '4.2em',
                    'margin-bottom'   => '0.95em',
                ),
                'logo'    => array(
                    'title'           => esc_html__( 'Logo text', 'fcunited' ),
                    'description'     => esc_html__( 'Font settings of the text case of the logo', 'fcunited' ),
                    'font-family'     => '"Open Sans",sans-serif',
                    'font-size'       => '1.9em',
                    'font-weight'     => '700',
                    'font-style'      => 'normal',
                    'line-height'     => '1.1em',
                    'text-decoration' => 'none',
                    'text-transform'  => 'uppercase',
                    'letter-spacing'  => '1px',
                ),
                'button'  => array(
                    'title'           => esc_html__( 'Buttons', 'fcunited' ),
                    'font-family'     => '"Open Sans",sans-serif',
                    'font-size'       => '12px',
                    'font-weight'     => '400',
                    'font-style'      => 'normal',
                    'line-height'     => '28px',
                    'text-decoration' => 'none',
                    'text-transform'  => 'uppercase',
                    'letter-spacing'  => '1.2px',
                ),
                'input'   => array(
                    'title'           => esc_html__( 'Input fields', 'fcunited' ),
                    'description'     => esc_html__( 'Font settings of the input fields, dropdowns and textareas', 'fcunited' ),
                    'font-family'     => 'inherit',
                    'font-size'       => '1em',
                    'font-weight'     => '300',
                    'font-style'      => 'normal',
                    'line-height'     => '1.5em',
                    'text-decoration' => 'none',
                    'text-transform'  => 'capitalize',
                    'letter-spacing'  => '0px',
                ),
                'info'    => array(
                    'title'           => esc_html__( 'Post meta', 'fcunited' ),
                    'description'     => esc_html__( 'Font settings of the post meta: date, counters, share, etc.', 'fcunited' ),
                    'font-family'     => 'inherit',
                    'font-size'       => '12px',
                    'font-weight'     => '400',
                    'font-style'      => 'normal',
                    'line-height'     => '1.4em',
                    'text-decoration' => 'none',
                    'text-transform'  => 'uppercase',
                    'letter-spacing'  => '1px',
                    'margin-top'      => '0.4em',
                    'margin-bottom'   => '',
                ),
                'menu'    => array(
                    'title'           => esc_html__( 'Main menu', 'fcunited' ),
                    'description'     => esc_html__( 'Font settings of the main menu items', 'fcunited' ),
                    'font-family'     => '"Open Sans",sans-serif',
                    'font-size'       => '13px',
                    'font-weight'     => '400',
                    'font-style'      => 'normal',
                    'line-height'     => '1.5em',
                    'text-decoration' => 'none',
                    'text-transform'  => 'uppercase',
                    'letter-spacing'  => '0.18px',
                ),
                'submenu' => array(
                    'title'           => esc_html__( 'Dropdown menu', 'fcunited' ),
                    'description'     => esc_html__( 'Font settings of the dropdown menu items', 'fcunited' ),
                    'font-family'     => '"Open Sans",sans-serif',
                    'font-size'       => '14px',
                    'font-weight'     => '500',
                    'font-style'      => 'normal',
                    'line-height'     => '1.35em',
                    'text-decoration' => 'none',
                    'text-transform'  => 'none',
                    'letter-spacing'  => '0.18px',
                ),
            )
        );



        fcunited_storage_set(
            'schemes', array(

                // Color scheme: 'default'
                'default' => array(
                    'title'    => esc_html__( 'Default', 'fcunited' ),
                    'internal' => true,
                    'colors'   => array(

                        // Whole block border and background
                        'bg_color'         => '#F7F5F1', //+
                        'bd_color'         => '#D6D6D3', //+

                        // Text and links colors
                        'text'             => '#606466', //+
                        'text_light'       => '#B6B6B6', //+
                        'text_dark'        => '#152229', //+
                        'text_link'        => '#E26824', //+
                        'text_hover'       => '#7E9D10', //+
                        'text_link2'       => '#7E9D10', //+
                        'text_hover2'      => '#152229', //+
                        'text_link3'       => '#6C8811', //+
                        'text_hover3'      => '#020F17', //+

                        // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                        'alter_bg_color'   => '#ffffff', //+
                        'alter_bg_hover'   => '#EBE9E7', //+
                        'alter_bd_color'   => '#F7F5F1', //+
                        'alter_bd_hover'   => '#262F3E', //+
                        'alter_text'       => '#606466', //+
                        'alter_light'      => '#979FA3', //+
                        'alter_dark'       => '#152229', //+
                        'alter_link'       => '#E26824', //+
                        'alter_hover'      => '#7E9D10', //+
                        'alter_link2'      => '#ffffff',
                        'alter_hover2'     => '#F7F5F1', //+
                        'alter_link3'      => '#D2E19E', //+
                        'alter_hover3'     => '#77950F', //+

                        // Extra blocks (submenu, tabs, color blocks, etc.)
                        'extra_bg_color'   => '#0E1011', //+
                        'extra_bg_hover'   => '#181A1B', //+
                        'extra_bd_color'   => '#D6D6D3', //+
                        'extra_bd_hover'   => '#0A171F', //+
                        'extra_text'       => '#9d9ea1',
                        'extra_light'      => '#797e87',
                        'extra_dark'       => '#FFFFFF', //+
                        'extra_link'       => '#E26824', //+
                        'extra_hover'      => '#ffffff', //+
                        'extra_link2'      => '#ffffff', //+
                        'extra_hover2'     => '#8be77c',
                        'extra_link3'      => '#ffffff', //+
                        'extra_hover3'     => '#F7F5F1', //+

                        // Input fields (form's fields and textarea)
                        'input_bg_color'   => '#ffffff', //+
                        'input_bg_hover'   => '#ffffff', //+
                        'input_bd_color'   => '#ffffff', //+
                        'input_bd_hover'   => '#E26824', //+
                        'input_text'       => '#B6B6B6', //+
                        'input_light'      => '#797e87',
                        'input_dark'       => '#152229', //+

                        // Inverse blocks (text and links on the 'text_link' background)
                        'inverse_bd_color' => '#152229', //+
                        'inverse_bd_hover' => '#152229', //+
                        'inverse_text'     => '#ffffff', //+
                        'inverse_light'    => '#333333',
                        'inverse_dark'     => '#152229', //+
                        'inverse_link'     => '#ffffff',
                        'inverse_hover'    => '#ffffff',
                    ),
                ),
                // Color scheme: 'dark'
                'dark'    => array(
                    'title'    => esc_html__( 'Dark', 'fcunited' ),
                    'internal' => true,
                    'colors'   => array(

                        // Whole block border and background
                        'bg_color'         => '#0A171F', //+
                        'bd_color'         => '#29353C', //+

                        // Text and links colors
                        'text'             => '#979FA3', //+
                        'text_light'       => '#6f6f6f',
                        'text_dark'        => '#ffffff', //+
                        'text_link'        => '#E26824', //+
                        'text_hover'       => '#ffffff', //+
                        'text_link2'       => '#7E9D10', //+
                        'text_hover2'      => '#e26824', //+
                        'text_link3'       => '#6C8811', //+
                        'text_hover3'      => '#eec432',

                        // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                        'alter_bg_color'   => '#020F17', //+
                        'alter_bg_hover'   => '#333333',
                        'alter_bd_color'   => '#29353C', //+
                        'alter_bd_hover'   => '#262F3E',
                        'alter_text'       => '#979FA3', //+
                        'alter_light'      => '#AAB2BD', //+
                        'alter_dark'       => '#ffffff', //+
                        'alter_link'       => '#E26824', //+
                        'alter_hover'      => '#ffffff', //+
                        'alter_link2'      => '#EA592E',
                        'alter_hover2'     => '#16232B ', //+
                        'alter_link3'      => '#D2E19E', //+
                        'alter_hover3'     => '#77950F', //+

                        // Extra blocks (submenu, tabs, color blocks, etc.)
                        'extra_bg_color'   => '#F7F5F1', //+
                        'extra_bg_hover'   => '#224452',
                        'extra_bd_color'   => '#29353C', //+
                        'extra_bd_hover'   => '#4a4a4a',
                        'extra_text'       => '#979fa3', //+
                        'extra_light'      => '#6f6f6f', //+
                        'extra_dark'       => '#0E1011', //+
                        'extra_link'       => '#E26824', //+
                        'extra_hover'      => '#7E9D10', //+
                        'extra_link2'      => '#ffffff', //+
                        'extra_hover2'     => '#8be77c',
                        'extra_link3'      => '#152229', //+
                        'extra_hover3'     => '#16232B', //+

                        // Input fields (form's fields and textarea)
                        'input_bg_color'   => '#ffffff', //+
                        'input_bg_hover'   => '#FFFFFF', //+
                        'input_bd_color'   => '#262F3E',
                        'input_bd_hover'   => '#353535',
                        'input_text'       => '#0E1011', //+
                        'input_light'      => '#6f6f6f',
                        'input_dark'       => '#0E1011', //+

                        // Inverse blocks (text and links on the 'text_link' background)
                        'inverse_bd_color' => '#0A171F', //+
                        'inverse_bd_hover' => '#152229', //+
                        'inverse_text'     => '#0E1011', //+
                        'inverse_light'    => '#6f6f6f',
                        'inverse_dark'     => '#ffffff', //+
                        'inverse_link'     => '#E26824', //+
                        'inverse_hover'    => '#7E9D10', //+
                    ),
                ),

                // Color scheme: 'default'
                'green_default' => array(
                    'title'    => esc_html__( 'Green', 'fcunited' ),
                    'internal' => true,
                    'colors'   => array(

                        // Whole block border and background
                        'bg_color'         => '#F2F4F6', //+
                        'bd_color'         => '#D6D6D3', //+

                        // Text and links colors
                        'text'             => '#606466', //+
                        'text_light'       => '#B6B6B6', //+
                        'text_dark'        => '#1C3354', //+
                        'text_link'        => '#92C544', //+
                        'text_hover'       => '#A6E04E', //+
                        'text_link2'       => '#92C544', //+
                        'text_hover2'      => '#1C3354', //+
                        'text_link3'       => '#88BC3A', //+
                        'text_hover3'      => '#020F17', //+

                        // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                        'alter_bg_color'   => '#ffffff', //+
                        'alter_bg_hover'   => '#EBE9E7', //+
                        'alter_bd_color'   => '#F2F4F6', //+
                        'alter_bd_hover'   => '#262F3E', //+
                        'alter_text'       => '#606466', //+
                        'alter_light'      => '#B5B5B5', //+
                        'alter_dark'       => '#1C3354', //+
                        'alter_link'       => '#92C544', //+
                        'alter_hover'      => '#0ACAEE', //+
                        'alter_link2'      => '#ffffff',
                        'alter_hover2'     => '#F2F4F6', //+
                        'alter_link3'      => '#D2E19E', //+
                        'alter_hover3'     => '#92C544', //+

                        // Extra blocks (submenu, tabs, color blocks, etc.)
                        'extra_bg_color'   => '#0E1011', //+
                        'extra_bg_hover'   => '#181A1B', //+
                        'extra_bd_color'   => '#D6D6D3', //+
                        'extra_bd_hover'   => '#1C3354', //+
                        'extra_text'       => '#9d9ea1',
                        'extra_light'      => '#797e87',
                        'extra_dark'       => '#FFFFFF', //+
                        'extra_link'       => '#0ACAEE', //+
                        'extra_hover'      => '#ffffff', //+
                        'extra_link2'      => '#ffffff', //+
                        'extra_hover2'     => '#8be77c',
                        'extra_link3'      => '#ffffff', //+
                        'extra_hover3'     => '#F2F4F6', //+

                        // Input fields (form's fields and textarea)
                        'input_bg_color'   => '#ffffff', //+
                        'input_bg_hover'   => '#ffffff', //+
                        'input_bd_color'   => '#ffffff', //+
                        'input_bd_hover'   => '#92C544', //+
                        'input_text'       => '#B6B6B6', //+
                        'input_light'      => '#797e87',
                        'input_dark'       => '#1C3354', //+

                        // Inverse blocks (text and links on the 'text_link' background)
                        'inverse_bd_color' => '#1C3354', //+
                        'inverse_bd_hover' => '#1C3354', //+
                        'inverse_text'     => '#ffffff', //+
                        'inverse_light'    => '#333333',
                        'inverse_dark'     => '#1C3354', //+
                        'inverse_link'     => '#ffffff',
                        'inverse_hover'    => '#ffffff',
                    ),
                ),
                // Color scheme: 'dark'
                'green_dark'    => array(
                    'title'    => esc_html__( 'Green Dark', 'fcunited' ),
                    'internal' => true,
                    'colors'   => array(

                        // Whole block border and background
                        'bg_color'         => '#1C3354', //+
                        'bd_color'         => '#29353C', //+

                        // Text and links colors
                        'text'             => '#B5B5B5', //+
                        'text_light'       => '#6f6f6f',
                        'text_dark'        => '#ffffff', //+
                        'text_link'        => '#92C544', //+
                        'text_hover'       => '#ffffff', //+
                        'text_link2'       => '#0ACAEE', //+
                        'text_hover2'      => '#92C544', //+
                        'text_link3'       => '#88BC3A', //+
                        'text_hover3'      => '#eec432',

                        // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                        'alter_bg_color'   => '#020F17', //+
                        'alter_bg_hover'   => '#333333',
                        'alter_bd_color'   => '#29353C', //+
                        'alter_bd_hover'   => '#262F3E',
                        'alter_text'       => '#B5B5B5', //+
                        'alter_light'      => '#AAB2BD', //+
                        'alter_dark'       => '#ffffff', //+
                        'alter_link'       => '#92C544', //+
                        'alter_hover'      => '#ffffff', //+
                        'alter_link2'      => '#EA592E',
                        'alter_hover2'     => '#16232B ', //+
                        'alter_link3'      => '#D2E19E', //+
                        'alter_hover3'     => '#92C544', //+

                        // Extra blocks (submenu, tabs, color blocks, etc.)
                        'extra_bg_color'   => '#F2F4F6', //+
                        'extra_bg_hover'   => '#224452',
                        'extra_bd_color'   => '#29353C', //+
                        'extra_bd_hover'   => '#4a4a4a',
                        'extra_text'       => '#B5B5B5', //+
                        'extra_light'      => '#6f6f6f', //+
                        'extra_dark'       => '#0E1011', //+
                        'extra_link'       => '#92C544', //+
                        'extra_hover'      => '#A6E04E', //+
                        'extra_link2'      => '#ffffff', //+
                        'extra_hover2'     => '#8be77c',
                        'extra_link3'      => '#1C3354', //+
                        'extra_hover3'     => '#16232B', //+

                        // Input fields (form's fields and textarea)
                        'input_bg_color'   => '#ffffff', //+
                        'input_bg_hover'   => '#FFFFFF', //+
                        'input_bd_color'   => '#262F3E',
                        'input_bd_hover'   => '#353535',
                        'input_text'       => '#0E1011', //+
                        'input_light'      => '#6f6f6f',
                        'input_dark'       => '#0E1011', //+

                        // Inverse blocks (text and links on the 'text_link' background)
                        'inverse_bd_color' => '#1C3354', //+
                        'inverse_bd_hover' => '#1C3354', //+
                        'inverse_text'     => '#0E1011', //+
                        'inverse_light'    => '#6f6f6f',
                        'inverse_dark'     => '#ffffff', //+
                        'inverse_link'     => '#92C544', //+
                        'inverse_hover'    => '#7E9D10', //+
                    ),
                ),

            )
        );
        fcunited_storage_set(
            'scheme_colors_add', array(
                'alter_bg_color_02' => array(
                    'color' => 'alter_bg_color',
                    'alpha' => 0.2,
                ),
                'alter_bg_color_04' => array(
                    'color' => 'alter_bg_color',
                    'alpha' => 0.4,
                ),
                'bg_color_08' => array(
                    'color' => 'bg_color',
                    'alpha' => 0.8,
                ),
                'extra_link2_05' => array(
                    'color' => 'extra_link2',
                    'alpha' => 0.5,
                ),
                'bg_color_0'        => array(
                    'color' => 'bg_color',
                    'alpha' => 0,
                ),
                'bg_color_02'       => array(
                    'color' => 'bg_color',
                    'alpha' => 0.2,
                ),
                'input_bg_color_02'       => array(
                    'color' => 'input_bg_color',
                    'alpha' => 0.2,
                ),
                'bg_color_07'       => array(
                    'color' => 'bg_color',
                    'alpha' => 0.7,
                ),
                'bg_color_09'       => array(
                    'color' => 'bg_color',
                    'alpha' => 0.9,
                ),
                'alter_bg_color_07' => array(
                    'color' => 'alter_bg_color',
                    'alpha' => 0.7,
                ),
                'alter_bg_color_00' => array(
                    'color' => 'alter_bg_color',
                    'alpha' => 0,
                ),
                'alter_bd_color_02' => array(
                    'color' => 'alter_bd_color',
                    'alpha' => 0.2,
                ),
                'alter_link_02'     => array(
                    'color' => 'alter_link',
                    'alpha' => 0.2,
                ),
                'alter_link_07'     => array(
                    'color' => 'alter_link',
                    'alpha' => 0.7,
                ),
                'extra_bg_color_05' => array(
                    'color' => 'extra_bg_color',
                    'alpha' => 0.5,
                ),
                'extra_bg_color_07' => array(
                    'color' => 'extra_bg_color',
                    'alpha' => 0.7,
                ),
                'extra_link_02'     => array(
                    'color' => 'extra_link',
                    'alpha' => 0.2,
                ),
                'extra_link_07'     => array(
                    'color' => 'extra_link',
                    'alpha' => 0.7,
                ),
                'text_dark_07'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.7,
                ),
                'text_link_02'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.2,
                ),
                'text_link_07'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.7,
                ),
                'text_dark_04'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.4,
                ),
                'text_link_blend'   => array(
                    'color'      => 'text_link',
                    'hue'        => 2,
                    'saturation' => -5,
                    'brightness' => 5,
                ),
                'alter_link_blend'  => array(
                    'color'      => 'alter_link',
                    'hue'        => 2,
                    'saturation' => -5,
                    'brightness' => 5,
                ),
            )
        );

    }
}

// Check if WooCommerce installed and activated
if ( ! function_exists( 'fcunited_exists_skins_woocommerce' ) ) {
    function fcunited_exists_skins_woocommerce() {
        return class_exists( 'Woocommerce' );
    }
}

if ( fcunited_exists_skins_woocommerce() ) {

    // Add qty label
    add_action( 'woocommerce_before_add_to_cart_quantity', 'fcunited_woocommerce_add_qty_text');


    // Move raiting
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
    add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 1 );


    // Add Qty label
    function fcunited_woocommerce_add_qty_text() { ?>
        <label class="qty-label"><?php echo esc_html__( 'Qty.:', 'fcunited' ) ?> </label><?php
    }
}

// Unset required plugins for current skin
if ( ! function_exists( 'fcunited_skin_unset_plugins' ) ) {
    add_action( 'after_setup_theme', 'fcunited_skin_unset_plugins', -1 );
    function fcunited_skin_unset_plugins() {
        unset ($GLOBALS['FCUNITED_STORAGE']['required_plugins']['joomsport-sports-league-results-management']);
    }
}

// Deactivate unused plugins of current skin
if ( ! function_exists( 'fcunited_skin_plugin_off_in_theme' ) ) {
	add_action( 'admin_init', 'fcunited_skin_plugin_off_in_theme' );
	function fcunited_skin_plugin_off_in_theme() {
		if ( (int) get_option( 'fcunited_off_plugins_count' ) > 0 ) {
			return;
		}

        deactivate_plugins( 'sportspress-for-basketball/sportspress-for-basketball.php' );
        deactivate_plugins( 'sportspress-for-soccer/sportspress-for-soccer.php' );
        deactivate_plugins( 'joomsport-sports-league-results-management/joomsport-sports-league-results-management.php' );
        deactivate_plugins( 'joomsport-sports-league-results-management/joomsport.php' );

		update_option( 'fcunited_off_plugins_count', 1 );
	}
}
if ( ! function_exists( 'fcunited_skin_reset_off_plugins_count' ) ) {
    add_action( 'fcunited_action_skin_switched', 'fcunited_skin_reset_off_plugins_count' );
    function fcunited_skin_reset_off_plugins_count() {
        update_option( 'fcunited_off_plugins_count', 0 );
    }
}

// Add skin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'fcunited_load_skin_styles' ) ) {
	add_action( 'after_setup_theme', 'fcunited_load_skin_styles', -1 );
	function fcunited_load_skin_styles() {
        require_once FCUNITED_THEME_DIR . FCUNITED_SKIN_DIR . 'skin-styles.php';
    }
}