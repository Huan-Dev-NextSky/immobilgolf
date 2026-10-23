<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Immobilgolf_MapFilter_Element extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'mapfilter';
	}

	public function get_title()
	{
		return __('Map Filter', 'immobilgolf');
	}
	public function get_icon()
	{
		return 'eicon-google-maps';
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
		$this->end_controls_section();
	}

	/**
	 * Fetch filter form HTML from portal (structure/options only).
	 * Estate results stay client-side so WP page cache cannot freeze listings.
	 */
	private function fetch_filter_form_html()
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://portal.immobilgolf.com/index.php/frontend/filter_map/it?form_only=1&_=' . time(),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array('Cache-Control: no-cache'),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$data = json_decode($response, true);
		if (!is_array($data) || empty($data['html'])) {
			return '';
		}
		return $data['html'];
	}

	protected function render()
	{
		$form_html = $this->fetch_filter_form_html();
		?>
		<div class="widget_area immobilgolf-mapfilter" data-portal-filter-map="https://portal.immobilgolf.com/index.php/frontend/filter_map/it" data-portal-ajax="https://portal.immobilgolf.com/index.php/frontend/ajax/it/178/">
			<div class="row-col">
				<div class="col-12 col-lg-6">
					<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
					<script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>
					<div id="main-map" class="realestatemap"></div>
					<script type="text/javascript">
						(function ($) {
							var $root = $('.immobilgolf-mapfilter').first();
							var filterMapUrl = $root.data('portal-filter-map');
							var ajaxBaseUrl = $root.data('portal-ajax');
							var scrollWheelEnabled = true;
							var mapRefresh = true;
							var selectorResults = '.widget-results';
							var markers = [];
							var map = null;
							var clusters = L.markerClusterGroup({
								spiderfyOnMaxZoom: true,
								showCoverageOnHover: false,
								zoomToBoundsOnClick: true,
							});
							var jpopup_customOptions = {
								maxWidth: 'initial',
								width: 'initial',
								className: 'popupCustom',
							};

							function ensureMap(center) {
								if (map || !$('#main-map').length) return;
								var c = (center && center.length === 2) ? center : [45.0, 9.0];
								map = L.map('main-map', {
									center: [c[0], c[1]],
									zoom: 9,
									scrollWheelZoom: scrollWheelEnabled,
									dragging: !L.Browser.mobile,
									tap: !L.Browser.mobile
								});
								L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
									attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
								}).addTo(map);
								map.addLayer(clusters);
							}

							function applyMapMarkers(listings, center) {
								ensureMap(center);
								if (!map) return;

								for (var i = 0; i < markers.length; i++) {
									clusters.removeLayer(markers[i]);
								}
								markers = [];

								if (!listings || !listings.length) return;

								$.each(listings, function (index, listing) {
									if (typeof listing.latLng === 'undefined') return;
									var iconUrl = (listing.options && listing.options.icon) ? listing.options.icon : '';
									var marker = L.marker(
										[listing.latLng[0], listing.latLng[1]],
										{
											icon: L.divIcon({
												html: '<img src="' + iconUrl + '">',
												className: 'open_steet_map_marker google_marker',
												iconSize: [35, 45],
												popupAnchor: [-1, -25],
												iconAnchor: [17, 47],
											})
										}
									);
									marker.bindPopup(listing.data, jpopup_customOptions);
									clusters.addLayer(marker);
									markers.push(marker);
								});

								if (markers.length) {
									var limits_center = [];
									for (var j in markers) {
										if (typeof markers[j]['_latlng'] === 'undefined') continue;
										limits_center.push([markers[j].getLatLng()]);
									}
									if (limits_center.length) {
										map.fitBounds(L.latLngBounds(limits_center));
									}
								} else if (center && center.length === 2) {
									map.setView([center[0], center[1]], 9);
								}
							}

							function initFilterWidgets() {
								// Price range slider (noUiSlider) — runs after form is in DOM.
								if (typeof scale_range === 'function' && $('.widget-filter .sw_scale_range').length) {
									$('.widget-filter .sw_scale_range').each(function () {
										var th_scale = $(this);
										var th_scale_id = th_scale.attr('id');
										if (!th_scale_id) return;
										if (th_scale.find('.nonlinear.noUi-target').length) return;
										var $config = th_scale.find('.config-range');
										if (!$config.length) return;
										scale_range(
											'#' + th_scale_id,
											$config.attr('data-min') || 0,
											$config.attr('data-max') || '',
											$config.attr('data-prefix') || '',
											$config.attr('data-sufix') || '',
											$config.attr('data-infinity') || 'false',
											$config.attr('data-predifinedMin') || '',
											$config.attr('data-predifinedMax') || ''
										);
									});
								}
							}

							function manualSearch(v_pagenum) {
								var data = {
									order: 'id DESC',
									view: 'grid',
									page_num: v_pagenum
								};
								$('#search-start').addClass('loading');
								if ($('#booking_date_from').length && $('#booking_date_from').val() !== '') {
									data['v_booking_date_from'] = $('#booking_date_from').val();
								}
								if ($('#booking_date_to').length && $('#booking_date_to').val() !== '') {
									data['v_booking_date_to'] = $('#booking_date_to').val();
								}

								$('.search-form input:not(.skip), .search-form select:not(.skip)').each(function () {
									if ($(this).attr('type') === 'checkbox') {
										if (this.checked) data['v_' + $(this).attr('id')] = $(this).val();
									} else if ($(this).attr('type') === 'radio') {
										if (this.checked) data['v_' + $(this).attr('name')] = $(this).attr('rel');
									} else if ($(this).hasClass('tree-input')) {
										if ($(this).val() !== '') {
											var tre_id_split = $(this).attr('id').split('_');
											if (data['v_search_option_' + tre_id_split[2]] === undefined) {
												data['v_search_option_' + tre_id_split[2]] = '';
											}
											data['v_search_option_' + tre_id_split[2]] += $(this).find('option:selected').text() + ' - ';
										}
									} else if (typeof $(this).attr('id') !== 'undefined' && $(this).val() !== '' && $(this).val() !== 'NULL' && $(this).val() != null) {
										data['v_' + $(this).attr('id')] = $(this).val();
									}
								});
								$('.form-additional input:not(.skip), .form-additional select:not(.skip)').each(function () {
									if ($(this).hasClass('tree-input') && $(this).val() !== '') {
										var tre_id_split = $(this).attr('id').split('_');
										if (data['v_search_option_' + tre_id_split[2]] === undefined) {
											data['v_search_option_' + tre_id_split[2]] = '';
										}
										data['v_search_option_' + tre_id_split[2]] += $(this).find('option:selected').text() + ' - ';
									}
								});

								$.ajax({
									url: ajaxBaseUrl + v_pagenum,
									type: 'POST',
									data: data,
									dataType: 'json',
									cache: false,
									xhrFields: { withCredentials: true },
									crossDomain: true
								}).done(function (res) {
									if (mapRefresh && $('#main-map').length > 0) {
										applyMapMarkers(res.results || [], res.results_center);
									}
									$(selectorResults).html(res.print || '');
								}).always(function () {
									$('#search-start').removeClass('loading');
								});
							}

							function loadLiveResults() {
								$(selectorResults).html('<div class="immobilgolf-property-loading" style="padding:24px;text-align:center;">Loading…</div>');

								$.ajax({
									url: filterMapUrl,
									type: 'GET',
									data: { _: Date.now() },
									dataType: 'json',
									cache: false,
									xhrFields: { withCredentials: true },
									crossDomain: true
								}).done(function (res) {
									if (!res) return;
									// Do not replace form HTML — keep SSR form (scripts/slider/tree work).
									if (res.results) {
										$(selectorResults).html(res.results);
									}
									applyMapMarkers(res.results_map || [], res.results_center);
								}).fail(function () {
									$(selectorResults).html('<p style="padding:24px;text-align:center;">Unable to load listings.</p>');
									ensureMap([45.0, 9.0]);
								});
							}

							$(document).on('click', '#search-start', function () {
								manualSearch(0);
								return false;
							});

							// Portal page-1 links omit offset (/ajax/it/178), page-2+ append offset (/ajax/it/178/9).
							// Do not treat the page_id segment as offset.
							function offsetFromPaginationHref(href) {
								href = String(href || '').split('#')[0];
								var base = String(ajaxBaseUrl || '').replace(/\/$/, '');
								if (base && href.indexOf(base) === 0) {
									var rest = href.slice(base.length).replace(/^\//, '');
									if (!rest) return 0;
									var n = parseInt(rest, 10);
									return isNaN(n) ? 0 : n;
								}
								var m = href.match(/\/(?:index\.php\/)?frontend\/ajax\/[^/]+\/\d+(?:\/(\d+))?\/?$/i);
								if (m) return m[1] ? (parseInt(m[1], 10) || 0) : 0;
								return 0;
							}

							// Pagination links from portal HTML → AJAX page load (offset).
							$(document).on('click', '.widget-results .pagination a, .widget-results .immobilgolf-pagination a', function (e) {
								e.preventDefault();
								var offset = offsetFromPaginationHref($(this).attr('href'));
								manualSearch(offset);
								var $target = $(selectorResults);
								if ($target.length && $target.offset()) {
									$('html, body').stop(true).animate({ scrollTop: Math.max(0, $target.offset().top - 90) }, 350);
								}
								return false;
							});

							$(function () {
								initFilterWidgets();
								loadLiveResults();
							});
						})(jQuery);
					</script>
				</div>
				<div class="col-12 col-lg-6">
					<div class="widget-filter">
						<?= $form_html ?>
					</div>
				</div>
			</div>
		</div>
		<div class="widget-results"></div>
		<?php
	}
}
