<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Immobilgolf_AgenciesFilter_Element extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'agenciesfilter';
	}

	public function get_title()
	{
		return __('Agencies Filter', 'immobilgolf');
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

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		?>
		<div class="widget_area">
			<div class="row-col">
				<div class="col-12 col-lg-6">
					<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
					<script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>
					<div id="main-map" class="realestatemap"></div>
					<script type="text/javascript">
						(function ($) {
							var timerMap;
							var ad_galleries;
							var firstSet = false;
							var mapRefresh = true;
							var loadOnTab = true;
							var zoomOnMapSearch = 9;
							var clusterConfig = null;
							var markerOptions = null;
							var mapDisableAutoPan = false;
							var mapStyle = [
								{
									featureType: "administrative",
									elementType: "labels.text.fill",
									stylers: [{ color: "#444444" }],
								},
								{
									featureType: "landscape",
									elementType: "all",
									stylers: [{ color: "#f2f2f2" }],
								},
								{
									featureType: "poi",
									elementType: "all",
									stylers: [{ visibility: "off" }],
								},
								{
									featureType: "road",
									elementType: "all",
									stylers: [{ saturation: -100 }, { lightness: 45 }],
								},
								{
									featureType: "road.highway",
									elementType: "all",
									stylers: [{ visibility: "simplified" }],
								},
								{
									featureType: "road.arterial",
									elementType: "labels.icon",
									stylers: [{ visibility: "off" }],
								},
								{
									featureType: "transit",
									elementType: "all",
									stylers: [{ visibility: "off" }],
								},
								{
									featureType: "water",
									elementType: "all",
									stylers: [{ color: "#46bcec" }, { visibility: "on" }],
								},
							];
							var rent_inc_id = "55";
							var scrollWheelEnabled = true;
							var myLocationEnabled = true;
							var rectangleSearchEnabled = true;
							var mapSearchbox = true;
							var mapRefresh = true;
							var map_main;
							var styles;
							var timerMap;
							var firstSet = false;
							var selectorResults = ".widget-results";
							var markers = [];
							var map = "";
							var clusters = "";
							clusters = L.markerClusterGroup({
								spiderfyOnMaxZoom: true,
								showCoverageOnHover: false,
								zoomToBoundsOnClick: true,
							});
							var jpopup_customOptions = {
								maxWidth: "initial",
								width: "initial",
								className: "popupCustom",
							};
							var markers = new Array();
							var map;
							var marker_clusterer;
							if ($("#main-map").length) {
								manualSearch(true);
							}
							$(document).on('click','#search-start',function(){
								manualSearch();
								return false;
							});
							$(document).on('change','#search_country',function(){
								var data = {
									country: $(this).val()
								};
								$.getJSON( "https://portal.immobilgolf.com/index.php/api/get_city/", data, function( data ) {
									
									$('#search_city').html(
											$('<option></option>')
												.val('')
												.text('Select City')
										);
									if(data.city.length > 0)
										{
											$.each(data.city, function(index, item) {
												$('#search_city').append(
													$('<option></option>')
														.val(item)
														.text(item)
												);
											})
										}
									
								})
							});
							function manualSearch(first=false){
								var data = {
									view: 'grid'
								};
								$('#search-start').addClass('loading');
								var data = {
									view: 'grid'
								};
								$('#search-start').addClass('loading');
								if($('#search_area').val() != ''){
									data['area'] = $('#search_area').val();
								}
								if($('#search_country').val() != ''){
									data['country'] = $('#search_country').val();
								}
								if($('#search_city').val() != ''){
									data['city'] = $('#search_city').val();
								}
								$.post("https://portal.immobilgolf.com/index.php/frontend/filter_agencies/it", data,
								function(data){
									if(mapRefresh && $('#main-map').length > 0)
									{
										if(!map) {
											map = L.map('main-map', {
												center: [data.results_center[0], data.results_center[1]],
												zoom: 8+1,
												scrollWheelZoom: scrollWheelEnabled,
												dragging: !L.Browser.mobile,
												tap: !L.Browser.mobile
											});     
											L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
												attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
											}).addTo(map);
											//var positron = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(map);
										} else {
											for (var i = 0; i < markers.length; i++) {
												clusters.removeLayer(markers[i]);
											}
										}
										markers = [];

										if(data.results.length > 0)
										{
											$.each(data.results, function(index, listing) {
												if(typeof listing.latLng == 'undefined'){
													return;
												}
												var marker = L.marker(
													[listing.latLng[0], listing.latLng[1]],
													{icon: L.divIcon({
															//html: '<img src="'+listing.options.icon+'">',
															html: '<img src="https://immobilgolf.com/wp-content/uploads/2025/10/glifo-dorato.png">',
															className: 'open_steet_map_marker google_marker',
															iconSize: [35, 45],
															popupAnchor: [-1, -25],
															iconAnchor: [17, 47],
														})
													}
												)
												marker.bindPopup(listing.data, jpopup_customOptions);
												clusters.addLayer(marker);
												markers.push(marker);
											})
											map.addLayer(clusters);
											if(markers.length){
												var limits_center = [];
												for (var i in markers) {
													if(typeof markers[i]['_latlng'] == 'undefined') continue;
													var latLngs = [ markers[i].getLatLng() ];
													limits_center.push(latLngs)
												};
												var bounds = L.latLngBounds(limits_center);
												map.fitBounds(bounds);
											}
										}
									}
									if (first) {
										$('#search_country').append(
											$('<option></option>')
												.val('')
												.text('Seleziona nazione...')
										);
										$('#search_city').append(
											$('<option></option>')
												.val('')
												.text('Seleziona città...')
										);
										if(data.country.length > 0)
										{
											$.each(data.country, function(index, item) {
												$('#search_country').append(
													$('<option></option>')
														.val(item)
														.text(item)
												);
											})
										}
									}
									$(selectorResults).html(data.print);
								}, "json").success(function(){
									$('#search-start').removeClass('loading');
								});
							}
						})(jQuery);
					</script>
				</div>
				<div class="col-12 col-lg-6">
					<div class="widget-filter">
						<section class="search-form color-primary parallax" id="main-search">
							<div class="container-form">
								<form action="" class="form-horisontal">
            						<div class="row-col">
										<div class="col-md-12" style="">
											<div class="row clearfix">
												<div class="col-xl-12">
												    <label>Seleziona l'area in cui cerchi un'agenzia di riferimento</label>
													<div class="form-group form-group-lg field_select">
														<input id="search_area" name="area" type="text" class="form-control noavtoWidth color-secondary fill_inited" value="" placeholder="ex. Veneto, Circolo Pinetina, Versilia... " autocomplete="nope">
													</div>
												</div>
											</div>
										</div>
										<div class=" col-md-12" style="margin-bottom:20px;color:#E26824;font-wieght:700;">Oppure cerca per </div>
										<div class=" col-md-6" style="">
											<label><?= __('Nazione', 'immobilgolf') ?></label>
											<div class="form-group form-group-lg field_select">
												<div class="select_container">
													<select id="search_country" name="country" class="form-control select_styled base no-padding color-secondary fill_inited">
													</select>
												</div>
											</div>
										</div>
										<div class=" col-md-6" style="">
											<label><?= __('Città', 'immobilgolf') ?></label>
											<div class="form-group form-group-lg field_select">
												<div class="select_container">
													<select id="search_city" name="city" class="form-control select_styled base no-padding color-secondary fill_inited">
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-1" style="margin-top:20px;">
											<button type="submit" id="search-start" class="btn btn-search focus-color"><i class="fa fa-search fa-color-white hide_on_ajax"></i><i class="fa fa-spinner fa-spin ajax_v fa-ajax-indicator hidden"></i> Filtra i Risultati</button>
										</div>
									</div>
								</form>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
		<div class="widget-results">
		</div>
		<?php
	}
}
