<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Immobilgolf_Property_Element extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'property';
	}

	public function get_title()
	{
		return __('List Property', 'immobilgolf');
	}
	public function get_icon()
	{
		return 'eicon-gallery-group';
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
			'type',
			[
				'label' => __('Type', 'immobilgolf'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'eagle'		=> esc_html__('Eagle Selection', 'immobilgolf'),
					'par' 	=> esc_html__('Par Selection', 'immobilgolf'),
					'birdie' 			=> esc_html__('Birdie Selection', 'immobilgolf')
				),
				'default' => 'eagle'
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
				'label' => __('Carousel Columns', 'immobilgolf'),
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
				'label' => __('Screen width tablet < 1024px', 'immobilgolf'),
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
				'label' => __('Screen width mobile < 767px', 'immobilgolf'),
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
		$type = (($settings['type'] != '') ? $settings['type'] : 'eagle');
		$number = (($settings['number'] != '') ? $settings['number'] : 4);
		$el_class = (($settings['el_class'] != '') ? $settings['el_class'] : '');
		$columns = (($settings['columns'] != '') ? $settings['columns'] : 4);
		$tablet = (($settings['tablet'] != '') ? $settings['tablet'] : 2);
		$mobile = (($settings['mobile'] != '') ? $settings['mobile'] : 1);
		$margin = (($settings['margin'] != '') ? $settings['margin'] : 20);
		$rows = (($settings['rows'] != '') ? $settings['rows'] : 1);
		$random = (($settings['random'] != '') ? $settings['random'] : 'no');
		$uid = 'ig-prop-' . $this->get_id();
		?>
		<div class="widget_area sc_widget_slider <?= esc_attr($number) ?> <?= esc_attr($type) ?>"
			id="<?= esc_attr($uid) ?>"
			data-type="<?= esc_attr($type) ?>"
			data-number="<?= esc_attr($number) ?>"
			data-order="<?= esc_attr($random) ?>"
			data-columns="<?= esc_attr($columns) ?>"
			data-tablet="<?= esc_attr($tablet) ?>"
			data-mobile="<?= esc_attr($mobile) ?>"
			data-margin="<?= esc_attr($margin) ?>"
			data-rows="<?= esc_attr($rows) ?>"
			data-el-class="<?= esc_attr($el_class) ?>">
			<aside class="widget widget_slider <?= esc_attr($el_class) ?>">
				<div class="slider_wrap slider_engine_swiper">
					<div class="slider_outer slider_swiper_outer slider_style_default slider_outer_direction_horizontal slider_outer_multi slider_outer_nopagination slider_outer_controls slider_outer_controls_side slider_outer_nocentered slider_outer_overflow_hidden slider_outer_titles_lb">
						<div class="slider_container slider_swiper swiper-slider-container slider_controls slider_controls_side slider_nocentered slider_overflow_hidden slider_titles_lb slider_swipe slider_direction_horizontal slider_multi slider_type_images" data-interval="7000" data-effect="slide" data-pagination="progressbar" data-direction="horizontal" data-slides-per-view="<?= esc_attr($columns) ?>" data-slides-table="<?= esc_attr($tablet) ?>" data-slides-mobile="<?= esc_attr($mobile) ?>" data-slides-row="<?= esc_attr($rows) ?>" data-slides-space="<?= esc_attr($margin) ?>" data-slides-centered="0" data-slides-overflow="1" data-mouse-wheel="0" data-autoplay="0">
							<div class="slider-wrapper swiper-wrapper immobilgolf-property-slides">
								<div class="immobilgolf-property-loading" style="padding:24px;text-align:center;width:100%;">Loading…</div>
							</div>
						</div>
					</div>
				</div>
			</aside>
		</div>
		<script>
		(function ($) {
			var $root = $("#<?= esc_js($uid) ?>");
			if (!$root.length) return;
			$.ajax({
				url: "https://portal.immobilgolf.com/index.php/frontend/property/it",
				type: "POST",
				dataType: "json",
				cache: false,
				xhrFields: { withCredentials: true },
				crossDomain: true,
				data: {
					type: $root.data("type"),
					number: $root.data("number"),
					order: $root.data("order"),
					_: Date.now()
				}
			}).done(function (res) {
				var $slides = $root.find(".immobilgolf-property-slides");
				if (res && res.total_results > 0 && res.results) {
					$slides.html(res.results);
					if (window.jQuery && typeof window.trx_addons_init_sliders === "function") {
						window.trx_addons_init_sliders($root);
					} else if (window.jQuery && $root.find(".slider_swiper").length && typeof Swiper !== "undefined") {
						// Theme may auto-init; trigger resize as fallback.
						$(window).trigger("resize");
					}
				} else {
					$slides.html("");
					$root.hide();
				}
			}).fail(function () {
				$root.find(".immobilgolf-property-slides").html("");
			});
		})(jQuery);
		</script>
		<?php
	}
}
