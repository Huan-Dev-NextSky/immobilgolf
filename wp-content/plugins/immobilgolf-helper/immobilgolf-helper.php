<?php
/**
 * Plugin Name: Immobilgolf Elementor
 * Plugin URI: 
 * Description:
 * Version: 1.0.2
 * Author: Immobilgolf
 * Author URI:
 * Text Domain: 
*/

if ( file_exists( plugin_dir_path( __FILE__ ). 'inc/elementor-extension.php' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'inc/elementor-extension.php' );
}

add_action( 'wp_enqueue_scripts', 'immobilgolf_register_script' );
function immobilgolf_register_script(){
	wp_enqueue_style( 'immobilgolf-style', plugin_dir_url( __FILE__ ) . 'assets/style.css', array(), '1.1.28' );
	wp_enqueue_style( 'immobilgolf-leaflet', plugin_dir_url( __FILE__ ) . 'assets/leaflet.css' );
	wp_enqueue_style( 'immobilgolf-style-noUiSlider', plugin_dir_url( __FILE__ ) . 'assets/noUiSlider.css' );
	wp_enqueue_script( 'immobilgolf-script-noUiSlider', plugin_dir_url( __FILE__ ) . 'assets/noUiSlider.js', array('jquery'), '', true );
	wp_enqueue_script( 'immobilgolf-script', plugin_dir_url( __FILE__ ) . 'assets/script.js', array('jquery'), '1.1.28', true );
	wp_localize_script( 'immobilgolf-script', 'immobilgolfAuth', array(
		'ajaxUrl'              => admin_url( 'admin-ajax.php' ),
		'portalLoginUrl'       => 'https://portal.immobilgolf.com/index.php/api/login_form/it',
		'portalCheckUrl'       => 'https://portal.immobilgolf.com/index.php/api/check_login/it',
		'portalLogoutUrl'      => 'https://portal.immobilgolf.com/index.php/api/logout_form/it',
		'portalLicensesUrl'    => 'https://portal.immobilgolf.com/index.php/api/registration_licenses/it',
		'portalPendingUrl'     => 'https://portal.immobilgolf.com/index.php/api/registration_pending/it',
		'portalStatusUrl'      => 'https://portal.immobilgolf.com/index.php/api/registration_status/it',
		'portalClaimUrl'       => 'https://portal.immobilgolf.com/index.php/api/registration_claim/it',
	) );
}

add_action( 'wp_ajax_immobilgolf_auth_login', 'immobilgolf_auth_login' );
add_action( 'wp_ajax_nopriv_immobilgolf_auth_login', 'immobilgolf_auth_login' );

function immobilgolf_auth_verify_nonce() {
	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'immobilgolf_auth_form' ) ) {
		wp_send_json_error( array( 'message' => 'Richiesta non valida.' ), 403 );
	}
}

function immobilgolf_auth_login() {
	immobilgolf_auth_verify_nonce();

	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_success( array( 'message' => 'OK' ) );
	}

	$log              = isset( $_POST['log'] ) ? sanitize_text_field( wp_unslash( $_POST['log'] ) ) : '';
	$pwd              = isset( $_POST['pwd'] ) ? (string) wp_unslash( $_POST['pwd'] ) : '';
	$remember         = ! empty( $_POST['rememberme'] );
	$redirect         = isset( $_POST['redirect'] ) ? esc_url_raw( wp_unslash( $_POST['redirect'] ) ) : '';
	$success_message  = isset( $_POST['success_message'] ) ? sanitize_text_field( wp_unslash( $_POST['success_message'] ) ) : '';

	if ( ! $log || ! $pwd ) {
		wp_send_json_error( array( 'message' => 'Inserisci email/username e password.' ), 400 );
	}

	// Allow login with email
	if ( is_email( $log ) ) {
		$user = get_user_by( 'email', $log );
		if ( $user ) {
			$log = $user->user_login;
		}
	}

	$signon = wp_signon( array(
		'user_login'    => $log,
		'user_password' => $pwd,
		'remember'      => $remember,
	), is_ssl() );

	if ( is_wp_error( $signon ) ) {
		wp_send_json_error( array( 'message' => 'Credenziali non valide.' ), 401 );
	}

	wp_send_json_success( array(
		'message'  => $success_message ? $success_message : 'Accesso effettuato correttamente.',
		'redirect' => $redirect ? $redirect : home_url( '/' ),
	) );
}
