<?php
if (!defined('ABSPATH')) {
	exit;
}

class Immobilgolf_Auth_Form_Element extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'auth-form';
	}

	public function get_title()
	{
		return __('Register / Login Form', 'immobilgolf');
	}

	public function get_icon()
	{
		return 'eicon-lock-user';
	}

	public function get_categories()
	{
		return ['immobilgolf'];
	}

	protected function _register_controls()
	{
		$this->start_controls_section(
			'general_opt',
			[
				'label' => __('General', 'immobilgolf'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'default_tab',
			[
				'label'   => __('Default tab', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'register' => __('Register', 'immobilgolf'),
					'login'    => __('Login', 'immobilgolf'),
				],
				'default' => 'register',
			]
		);

		$this->add_control(
			'tab_register_label',
			[
				'label'   => __('Register tab label', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Registrati',
			]
		);

		$this->add_control(
			'tab_login_label',
			[
				'label'   => __('Login tab label', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Accedi',
			]
		);

		$this->add_control(
			'redirect_after_login',
			[
				'label'       => __('Redirect after login', 'immobilgolf'),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => home_url('/'),
				'default'     => ['url' => ''],
			]
		);

		$this->add_control(
			'redirect_after_register',
			[
				'label'       => __('Redirect after register', 'immobilgolf'),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => home_url('/'),
				'default'     => ['url' => ''],
			]
		);

		$this->add_control(
			'el_class',
			[
				'label' => __('Extra class', 'immobilgolf'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'register_opt',
			[
				'label' => __('Register form', 'immobilgolf'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'section_heading',
			[
				'label'   => __('Property section heading', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Indica qualche informazione della tua proprietà che vorresti condividere',
			]
		);

		$this->add_control(
			'property_types',
			[
				'label'   => __('Property types (one per line)', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => "Villa\nAppartamento\nAttico\nMansarda\nVilla Bifamiliare\nVilla a Schiera\nAppartamento in Villa",
			]
		);

		$this->add_control(
			'privacy_text',
			[
				'label'   => __('Privacy text', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Accetto che i dati inviati vengano raccolti e archiviati secondo le normative sulla',
			]
		);

		$this->add_control(
			'privacy_label',
			[
				'label'   => __('Privacy link label', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Privacy Policy',
			]
		);

		$this->add_control(
			'privacy_url',
			[
				'label'   => __('Privacy Policy URL', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::URL,
				'default' => ['url' => home_url('/privacy-policy/')],
			]
		);

		$this->add_control(
			'register_submit_label',
			[
				'label'   => __('Register button', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'REGISTRATI',
			]
		);

		$this->add_control(
			'register_success',
			[
				'label'   => __('Register success message', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Registrazione completata! Ora puoi accedere.',
			]
		);

		$this->add_control('ph_name', [
			'label' => __('Nome', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Nome',
		]);
		$this->add_control('ph_surname', [
			'label' => __('Cognome', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Cognome',
		]);
		$this->add_control('ph_email', [
			'label' => __('Email', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Email',
		]);
		$this->add_control('ph_phone', [
			'label' => __('Telefono', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Telefono',
		]);
		$this->add_control('ph_password', [
			'label' => __('Password', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Password',
		]);
		$this->add_control('ph_password_confirm', [
			'label' => __('Confirm password', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Conferma Password',
		]);
		$this->add_control('ph_address', [
			'label' => __('Address', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Indirizzo',
		]);
		$this->add_control('ph_city', [
			'label' => __('City', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Città',
		]);
		$this->add_control('ph_postal_code', [
			'label' => __('Postal Code', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'CAP',
		]);
		$this->add_control('ph_codice_fiscale', [
			'label' => __('Codice Fiscale', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Codice Fiscale',
		]);
		$this->add_control('ph_tipo', [
			'label' => __('Property type', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Seleziona Il Tipo Di Proprietà',
		]);
		$this->add_control('ph_provincia', [
			'label' => __('Provincia', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Indica La Provincia',
		]);
		$this->add_control('ph_club', [
			'label' => __('Golf Club', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Indica Il Golf Club',
		]);

		$this->end_controls_section();

		$this->start_controls_section(
			'login_opt',
			[
				'label' => __('Login form', 'immobilgolf'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'login_submit_label',
			[
				'label'   => __('Login button', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'ACCEDI',
			]
		);

		$this->add_control(
			'portal_login_url',
			[
				'label'       => __('Portal login API URL', 'immobilgolf'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'https://portal.immobilgolf.com/index.php/api/login_form/it',
				'description' => __('CodeIgniter endpoint: api/login_form/{lang}', 'immobilgolf'),
			]
		);

		$this->add_control(
			'portal_check_url',
			[
				'label'       => __('Portal check login API URL', 'immobilgolf'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'https://portal.immobilgolf.com/index.php/api/check_login/it',
			]
		);

		$this->add_control(
			'logged_admin_label',
			[
				'label'   => __('Logged-in admin button', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Vai al Portale',
			]
		);

		$this->add_control(
			'logged_logout_label',
			[
				'label'   => __('Logged-in logout button', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Esci',
			]
		);

		$this->add_control(
			'logout_redirect',
			[
				'label'       => __('Redirect after logout', 'immobilgolf'),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://immobilgolf.com/home-tee-time/',
				'default'     => [
					'url' => 'https://immobilgolf.com/home-tee-time/',
				],
			]
		);

		$this->add_control(
			'portal_logout_url',
			[
				'label'   => __('Portal logout API URL', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'https://portal.immobilgolf.com/index.php/api/logout_form/it',
			]
		);

		$this->add_control(
			'logged_hello',
			[
				'label'   => __('Logged-in hello text', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Ciao',
			]
		);

		$this->add_control(
			'login_success',
			[
				'label'   => __('Login success message', 'immobilgolf'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Accesso effettuato correttamente.',
			]
		);

		$this->add_control('ph_login_email', [
			'label' => __('Login email/username', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Email o Username',
		]);
		$this->add_control('ph_login_password', [
			'label' => __('Login password', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Password',
		]);
		$this->add_control('remember_label', [
			'label' => __('Remember me label', 'immobilgolf'),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => 'Ricordami',
		]);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_opt',
			[
				'label' => __('Style', 'immobilgolf'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label'     => __('Card background', 'immobilgolf'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E3E3E3',
				'selectors' => [
					'{{WRAPPER}} .immobilgolf-auth-form__card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __('Accent color', 'immobilgolf'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#e26824',
				'selectors' => [
					'{{WRAPPER}} .immobilgolf-auth-form__heading' => 'color: {{VALUE}};',
					'{{WRAPPER}} .immobilgolf-auth-form__privacy a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .immobilgolf-auth-form__tab.is-active' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_inactive_color',
			[
				'label'     => __('Inactive tab text', 'immobilgolf'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#888888',
				'selectors' => [
					'{{WRAPPER}} .immobilgolf-auth-form__tab:not(.is-active)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_inactive_bg',
			[
				'label'     => __('Inactive tab background', 'immobilgolf'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#d0d0d0',
				'selectors' => [
					'{{WRAPPER}} .immobilgolf-auth-form__tab:not(.is-active)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_active_bg',
			[
				'label'     => __('Active tab background', 'immobilgolf'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .immobilgolf-auth-form__tab.is-active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg',
			[
				'label'     => __('Button background', 'immobilgolf'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#4b4b4b',
				'selectors' => [
					'{{WRAPPER}} .immobilgolf-auth-form__submit' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_hover',
			[
				'label'     => __('Button hover', 'immobilgolf'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .immobilgolf-auth-form__submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => __('Card padding', 'immobilgolf'),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default'    => [
					'top' => 30,
					'right' => 30,
					'bottom' => 30,
					'left' => 30,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .immobilgolf-auth-form__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$settings['ph_address'] = !empty($settings['ph_address']) ? $settings['ph_address'] : 'Indirizzo';
		$settings['ph_city'] = !empty($settings['ph_city']) ? $settings['ph_city'] : 'Città';
		$settings['ph_postal_code'] = !empty($settings['ph_postal_code']) ? $settings['ph_postal_code'] : 'CAP';
		$settings['ph_codice_fiscale'] = !empty($settings['ph_codice_fiscale']) ? $settings['ph_codice_fiscale'] : 'Codice Fiscale';
		$extra    = !empty($settings['el_class']) ? sanitize_html_class($settings['el_class']) : '';
		$default  = 'register';
		$types    = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $settings['property_types'])));
		$privacy_url = !empty($settings['privacy_url']['url']) ? $settings['privacy_url']['url'] : home_url('/privacy-policy/');
		$privacy_blank = !empty($settings['privacy_url']['is_external']) ? ' target="_blank" rel="noopener noreferrer"' : '';
		$uid = 'ig-auth-' . $this->get_id();

		$login_redirect    = !empty($settings['redirect_after_login']['url']) ? esc_url($settings['redirect_after_login']['url']) : '';
		$register_redirect = !empty($settings['redirect_after_register']['url']) ? esc_url($settings['redirect_after_register']['url']) : '';
		$portal_login_url  = !empty($settings['portal_login_url']) ? $settings['portal_login_url'] : 'https://portal.immobilgolf.com/index.php/api/login_form/it';
		$portal_check_url  = !empty($settings['portal_check_url']) ? $settings['portal_check_url'] : 'https://portal.immobilgolf.com/index.php/api/check_login/it';
		$portal_logout_url = !empty($settings['portal_logout_url']) ? $settings['portal_logout_url'] : 'https://portal.immobilgolf.com/index.php/api/logout_form/it';
		$logout_redirect   = !empty($settings['logout_redirect']['url']) ? $settings['logout_redirect']['url'] : 'https://immobilgolf.com/home-tee-time/';

		// Auth form embeds a nonce; never cache this page.
		if (!defined('DONOTCACHEPAGE')) {
			define('DONOTCACHEPAGE', true);
		}
		do_action('litespeed_control_set_nocache', 'immobilgolf auth form nonce');

?>
		<div class="immobilgolf-auth-form <?php echo esc_attr($extra); ?>"
			data-default-tab="<?php echo esc_attr($default); ?>"
			data-portal-check-url="<?php echo esc_url($portal_check_url); ?>"
			data-portal-logout-url="<?php echo esc_url($portal_logout_url); ?>"
			data-portal-licenses-url="https://portal.immobilgolf.com/index.php/api/registration_licenses/it"
			data-logout-redirect="<?php echo esc_url($logout_redirect); ?>">
			<div class="immobilgolf-auth-form__card">
				<div class="immobilgolf-auth-form__loading">
					<span class="immobilgolf-auth-form__spinner"></span>
				</div>
				<div class="immobilgolf-auth-form__logged" hidden>
					<p class="immobilgolf-auth-form__logged-hello">
						<span class="immobilgolf-auth-form__logged-hello-label"><?php echo esc_html($settings['logged_hello']); ?></span>
						<strong class="immobilgolf-auth-form__logged-name"></strong>
					</p>
					<div class="immobilgolf-auth-form__logged-actions">
						<a class="immobilgolf-auth-form__submit immobilgolf-auth-form__admin-btn" href="#">
							<?php echo esc_html($settings['logged_admin_label']); ?>
						</a>
						<a class="immobilgolf-auth-form__submit immobilgolf-auth-form__logout-btn immobilgolf-auth-form__submit--outline" href="#">
							<?php echo esc_html($settings['logged_logout_label']); ?>
						</a>
					</div>
				</div>

				<div class="immobilgolf-auth-form__guest" hidden>
				<div class="immobilgolf-auth-form__tabs" role="tablist">
					<button type="button" class="immobilgolf-auth-form__tab<?php echo $default === 'register' ? ' is-active' : ''; ?>" data-tab="register" role="tab">
						<?php echo esc_html($settings['tab_register_label']); ?>
					</button>
					<button type="button" class="immobilgolf-auth-form__tab<?php echo $default === 'login' ? ' is-active' : ''; ?>" data-tab="login" role="tab">
						<?php echo esc_html($settings['tab_login_label']); ?>
					</button>
				</div>

				<div class="immobilgolf-auth-form__panel<?php echo $default === 'register' ? ' is-active' : ''; ?>" data-panel="register" role="tabpanel">
					<form class="immobilgolf-auth-form__form" data-form="register" data-auth="portal" id="<?php echo esc_attr($uid); ?>-register" novalidate>
						<input type="hidden" name="redirect" value="<?php echo esc_attr($register_redirect); ?>">
						<input type="hidden" name="success_message" value="<?php echo esc_attr($settings['register_success']); ?>">
						<input type="text" name="website" value="" class="immobilgolf-auth-form__hp" tabindex="-1" autocomplete="off" aria-hidden="true">

						<div class="immobilgolf-auth-form__row">
							<div class="immobilgolf-auth-form__col">
								<span class="immobilgolf-auth-form__control-wrap">
									<input type="text" name="name" placeholder="<?php echo esc_attr($settings['ph_name']); ?>" required aria-required="true" autocapitalize="off" autocorrect="off">
								</span>
							</div>
							<div class="immobilgolf-auth-form__col">
								<span class="immobilgolf-auth-form__control-wrap">
									<input type="text" name="surname" placeholder="<?php echo esc_attr($settings['ph_surname']); ?>" required aria-required="true" autocapitalize="off" autocorrect="off">
								</span>
							</div>
						</div>

						<div class="immobilgolf-auth-form__row">
							<div class="immobilgolf-auth-form__col">
								<span class="immobilgolf-auth-form__control-wrap">
									<input type="email" name="email" placeholder="<?php echo esc_attr($settings['ph_email']); ?>" required aria-required="true" autocapitalize="off" autocorrect="off" spellcheck="false">
								</span>
							</div>
							<div class="immobilgolf-auth-form__col">
								<span class="immobilgolf-auth-form__control-wrap">
									<input type="tel" name="phone" placeholder="<?php echo esc_attr($settings['ph_phone']); ?>" autocapitalize="off">
								</span>
							</div>
						</div>

						<div class="immobilgolf-auth-form__row">
							<div class="immobilgolf-auth-form__col">
								<span class="immobilgolf-auth-form__control-wrap immobilgolf-auth-form__control-wrap--password">
									<input type="password" name="password" placeholder="<?php echo esc_attr($settings['ph_password']); ?>" required aria-required="true" minlength="6" autocomplete="new-password">
									<button type="button" class="immobilgolf-auth-form__password-toggle" aria-label="Mostra password" aria-pressed="false" data-password-toggle>
										<span class="immobilgolf-auth-form__password-toggle-icon immobilgolf-auth-form__password-toggle-icon--show" aria-hidden="true">
											<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
										</span>
										<span class="immobilgolf-auth-form__password-toggle-icon immobilgolf-auth-form__password-toggle-icon--hide" aria-hidden="true" hidden>
											<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
										</span>
									</button>
								</span>
							</div>
							<div class="immobilgolf-auth-form__col">
								<span class="immobilgolf-auth-form__control-wrap immobilgolf-auth-form__control-wrap--password">
									<input type="password" name="password_confirm" placeholder="<?php echo esc_attr($settings['ph_password_confirm']); ?>" required aria-required="true" minlength="6" autocomplete="new-password">
									<button type="button" class="immobilgolf-auth-form__password-toggle" aria-label="Mostra password" aria-pressed="false" data-password-toggle>
										<span class="immobilgolf-auth-form__password-toggle-icon immobilgolf-auth-form__password-toggle-icon--show" aria-hidden="true">
											<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
										</span>
										<span class="immobilgolf-auth-form__password-toggle-icon immobilgolf-auth-form__password-toggle-icon--hide" aria-hidden="true" hidden>
											<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
										</span>
									</button>
								</span>
							</div>
						</div>

						<div class="immobilgolf-auth-form__row">
							<div class="immobilgolf-auth-form__col immobilgolf-auth-form__col--full">
								<span class="immobilgolf-auth-form__control-wrap">
									<input type="text" name="address" placeholder="<?php echo esc_attr($settings['ph_address']); ?>" required aria-required="true" autocapitalize="off" autocorrect="off">
								</span>
							</div>
						</div>

						<div class="immobilgolf-auth-form__row">
							<div class="immobilgolf-auth-form__col">
								<span class="immobilgolf-auth-form__control-wrap">
									<input type="text" name="city" placeholder="<?php echo esc_attr($settings['ph_city']); ?>" required aria-required="true" autocapitalize="off" autocorrect="off">
								</span>
							</div>
							<div class="immobilgolf-auth-form__col">
								<span class="immobilgolf-auth-form__control-wrap">
									<input type="text" name="postal_code" placeholder="<?php echo esc_attr($settings['ph_postal_code']); ?>" required aria-required="true" autocapitalize="off" autocorrect="off">
								</span>
							</div>
						</div>

						<div class="immobilgolf-auth-form__row">
							<div class="immobilgolf-auth-form__col immobilgolf-auth-form__col--full">
								<span class="immobilgolf-auth-form__control-wrap">
									<input type="text" name="codice_fiscale" placeholder="<?php echo esc_attr($settings['ph_codice_fiscale']); ?>" required aria-required="true" autocapitalize="characters" autocorrect="off" spellcheck="false">
								</span>
							</div>
						</div>

						<div class="immobilgolf-auth-form__row">
							<div class="immobilgolf-auth-form__col immobilgolf-auth-form__col--full">
								<span class="immobilgolf-auth-form__heading"><?php echo esc_html($settings['section_heading']); ?></span>
							</div>
						</div>

						<div class="immobilgolf-auth-form__row">
							<div class="immobilgolf-auth-form__col immobilgolf-auth-form__col--full">
								<span class="immobilgolf-auth-form__control-wrap">
									<select name="tipo">
										<option value=""><?php echo esc_html($settings['ph_tipo']); ?></option>
										<?php foreach ($types as $type) : ?>
											<option value="<?php echo esc_attr($type); ?>"><?php echo esc_html($type); ?></option>
										<?php endforeach; ?>
									</select>
								</span>
							</div>
						</div>

						<div class="immobilgolf-auth-form__row">
							<div class="immobilgolf-auth-form__col">
								<span class="immobilgolf-auth-form__control-wrap">
									<input type="text" name="provincia" placeholder="<?php echo esc_attr($settings['ph_provincia']); ?>" autocapitalize="off" autocorrect="off">
								</span>
							</div>
							<div class="immobilgolf-auth-form__col">
								<span class="immobilgolf-auth-form__control-wrap">
									<input type="text" name="club" placeholder="<?php echo esc_attr($settings['ph_club']); ?>" autocapitalize="off" autocorrect="off">
								</span>
							</div>
						</div>

						<div class="immobilgolf-auth-form__footer">
							<span class="immobilgolf-auth-form__control-wrap immobilgolf-auth-form__control-wrap--checkbox">
								<label class="immobilgolf-auth-form__privacy">
									<input type="checkbox" name="privacy" value="1" required aria-required="true">
									<span class="immobilgolf-auth-form__privacy-text">
										<?php echo esc_html($settings['privacy_text']); ?>
										<a href="<?php echo esc_url($privacy_url); ?>" <?php echo $privacy_blank; ?>><?php echo esc_html($settings['privacy_label']); ?></a>.
									</span>
								</label>
							</span>
							<button type="submit" class="immobilgolf-auth-form__submit"><?php echo esc_html($settings['register_submit_label']); ?></button>
						</div>
						<div class="immobilgolf-auth-form__message" aria-live="polite" hidden></div>
					</form>
				</div>

				<div class="immobilgolf-auth-form__panel<?php echo $default === 'login' ? ' is-active' : ''; ?>" data-panel="login" role="tabpanel">
					<form class="immobilgolf-auth-form__form" data-form="login" data-auth="portal"
						data-portal-url="<?php echo esc_url($portal_login_url); ?>"
						id="<?php echo esc_attr($uid); ?>-login" novalidate>
						<input type="hidden" name="redirect" value="<?php echo esc_attr($login_redirect); ?>">
						<input type="hidden" name="success_message" value="<?php echo esc_attr($settings['login_success']); ?>">
						<input type="text" name="website" value="" class="immobilgolf-auth-form__hp" tabindex="-1" autocomplete="off" aria-hidden="true">

						<div class="immobilgolf-auth-form__row">
							<div class="immobilgolf-auth-form__col immobilgolf-auth-form__col--full">
								<span class="immobilgolf-auth-form__control-wrap">
									<input type="text" name="username" placeholder="<?php echo esc_attr($settings['ph_login_email']); ?>" required aria-required="true" autocomplete="username" autocapitalize="off" autocorrect="off" spellcheck="false">
								</span>
							</div>
						</div>

						<div class="immobilgolf-auth-form__row">
							<div class="immobilgolf-auth-form__col immobilgolf-auth-form__col--full">
								<span class="immobilgolf-auth-form__control-wrap immobilgolf-auth-form__control-wrap--password">
									<input type="password" name="password" placeholder="<?php echo esc_attr($settings['ph_login_password']); ?>" required aria-required="true" autocomplete="current-password">
									<button type="button" class="immobilgolf-auth-form__password-toggle" aria-label="Mostra password" aria-pressed="false" data-password-toggle>
										<span class="immobilgolf-auth-form__password-toggle-icon immobilgolf-auth-form__password-toggle-icon--show" aria-hidden="true">
											<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
										</span>
										<span class="immobilgolf-auth-form__password-toggle-icon immobilgolf-auth-form__password-toggle-icon--hide" aria-hidden="true" hidden>
											<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
										</span>
									</button>
								</span>
							</div>
						</div>

						<div class="immobilgolf-auth-form__footer">
							<label class="immobilgolf-auth-form__privacy immobilgolf-auth-form__remember">
								<input type="checkbox" name="rememberme" value="forever">
								<span><?php echo esc_html($settings['remember_label']); ?></span>
							</label>
							<button type="submit" class="immobilgolf-auth-form__submit"><?php echo esc_html($settings['login_submit_label']); ?></button>
						</div>
						<div class="immobilgolf-auth-form__message" aria-live="polite" hidden></div>
					</form>
				</div>
				</div><!-- /.immobilgolf-auth-form__guest -->
			</div>
		</div>
		<div class="immobilgolf-auth-licenses-modal" hidden>
			<div class="immobilgolf-auth-licenses-modal__backdrop" data-close-licenses-modal></div>
			<div class="immobilgolf-auth-licenses-modal__dialog" role="dialog" aria-modal="true" aria-label="Licenze registrazione">
				<button type="button" class="immobilgolf-auth-licenses-modal__close" data-close-licenses-modal aria-label="Chiudi">&times;</button>
				<iframe class="immobilgolf-auth-licenses-modal__iframe" title="Licenze registrazione" src="about:blank"></iframe>
			</div>
		</div>
<?php
	}
}
