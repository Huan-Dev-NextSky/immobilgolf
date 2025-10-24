<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Immobilgolf_Agencies_Element extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'agencies';
	}

	public function get_title()
	{
		return __('List agencies', 'immobilgolf');
	}
	public function get_icon()
	{ 
		return 'eicon-gallery-grid';
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
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'number',
			[
				'label' => __('Maximum Products', 'immobilgolf'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'default' => '20'
			]
		);
		$this->add_control(
			'el_class',
			[
				'label' => __('Extra class', 'immobilgolf'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
			]
		);
		$this->add_control(
			'random',
			[
				'label' => __( 'Random list', 'immobilgolf' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'grid_columns',
			[
				'label' => __('Grid/Carousel Columns', 'immobilgolf'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'columns',
			[
				'label' => __('Default Columns', 'immobilgolf'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
					'6'	=> '6',
				],
				'default' => '4'
			]
		);
		$this->add_control(
			'rows',
			[
				'label' => __('Default Rows', 'immobilgolf'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3'
				],
				'default' => '1'
			]
		);
		$this->add_control(
			'tablet',
			[
				'label' => __('Screen width tablet', 'immobilgolf'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
				],
				'default' => '2'
			]
		);
		$this->add_control(
			'mobile',
			[
				'label' => __('Screen width mobile', 'immobilgolf'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
				],
				'default' => '1'
			]
		);
		$this->add_control(
			'margin',
			[
				'label' => __('Spacing', 'immobilgolf'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'default' => '20'
			]
		);
		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$number = (($settings['number'] != '') ? $settings['number'] : 4);
		$el_class = (($settings['el_class'] != '') ? $settings['el_class'] : '');
		$columns = (($settings['columns'] != '') ? $settings['columns'] : 4);
		$tablet = (($settings['tablet'] != '') ? $settings['tablet'] : 2);
		$mobile = (($settings['mobile'] != '') ? $settings['mobile'] : 1);
		$margin = (($settings['margin'] != '') ? $settings['margin'] : 20);
		$rows = (($settings['rows'] != '') ? $settings['rows'] : 1);
		$random = (($settings['random'] != '') ? $settings['random'] : 'no');
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://portal.exileart.it/index.php/frontend/agencies/it',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'number='.$number.'&order='.$random.'',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/x-www-form-urlencoded',
				'Accept: application/json',
				'Authorization: ••••••',
				'Cookie: cisession=Uz1RNwA3VzpSfgspBTlWZwM0VGwEL1UiD2oHd1QgVTwLYVQ8C1tWP1A7AX8JM1F1VTgHZVVhWmBVcAkzVGoDP1ZkADtXY1o8UWVRb102BmRTalE4AGdXZVI1Cz8FYlZiAzBUZwQ8VWIPPQcxVGJVZws3VGMLYVYyUG0BfwkzUXVVOAdnVWNaYFVwCWJULQNYVjcAZ1c0WihRMVEkXSEGJFNnUX4AO1cxUjcLYAUhVmMDMFR4BDVVZw8hBzFUY1V7Cz9UYQs9VnRQZAEuCTJRN1UyB2xVcVovVSEJblQvA1hWNwBkVzVaNFEgUXVdaQZ1U2ZRPwAwVzpSJwsKBWxWJQNwVDsEbFU%2FD10HcVQ9VSELZ1Q%2FC2FWeVBoAXMJPFE%2BVSwHZlVxWmFVIQkxVGwDNFZsACFXPFo7USdRI10NBmdTP1F5AGhXdlJsCy4FelZ0Az9UPwQ3VWAPOAcxVGpVYQs2VGQLM1ZlUG8BZgl7UTxVOwdsVXFaL1UhCW5ULwNYVjIAYlckWjtRdlFsXSEGPFNsUTcAI1ciUj4LKQU5VmcDNlRsBC9VMg9uB3RUJ1U2C2ZUMwtbVj5QPgEuCWBRJFU5ByVVaVpvVWgJKVQ%2BAzBWYwAxVzJaeFFvUSo%3D'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		$total_results = $response['total_results'];
		$results = $response['results'];
		?>
		<div class="widget_area sc_widget_slider">
			<?php if ($total_results > 0) { ?>
			<aside class="widget widget_slider <?= $el_class ?>">
				<div class="slider_wrap slider_engine_swiper">
					<div class="slider_outer slider_swiper_outer slider_style_default slider_outer_direction_horizontal slider_outer_multi slider_outer_nopagination slider_outer_controls slider_outer_controls_side slider_outer_nocentered slider_outer_overflow_hidden slider_outer_titles_lb">
						<div class="slider_container slider_swiper swiper-slider-container slider_controls slider_controls_side slider_nocentered slider_overflow_hidden slider_titles_lb slider_swipe slider_direction_horizontal slider_multi slider_type_images swiper-grid" data-interval="7000" data-effect="slide" data-slides-per-view="<?= $columns ?>" data-slides-table="<?= $tablet ?>" data-slides-mobile="<?= $mobile ?>" data-slides-row="<?= $rows ?>" data-slides-space="<?= $margin ?>" data-slides-centered="0" data-slides-overflow="1" data-mouse-wheel="0" data-autoplay="0">
							<div class="slider-wrapper swiper-wrapper">
								<?= $results ?>
							</div>
							<div class="slider_controls_wrap">
								<a class="slider_prev swiper-button-prev" href="#"></a>
								<a class="slider_next swiper-button-next" href="#"></a>
							</div>
						</div>
					</div>
				</div>
			</aside>
			<?php } ?>
		</div>
		<?php
	}
}
