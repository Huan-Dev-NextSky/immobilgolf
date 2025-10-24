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

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://portal.exileart.it/index.php/frontend/filter_map/it',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'Cookie: cisession=B2lWMA45BWhTfwclAj5TYldgAzsDKFcgB2IDc1UhWjMDaQZuCFhUPQVuAnwKMFF1AWwHZQk9ADoAJQE1Bz5XNVFgVzBXYwMxCzdUYw8zADYHOFY%2BDmwFZ1M1BzICM1NqVzQDNgM4V2cHMANhVTZaOQNnBmEINFRgBT0CfAowUXUBbAdnCT8AOgAlAWoHflcMUTBXMFc0A3ELa1QhD3MAIgczVnkONQVjUzYHbAImU2ZXZAMvAzJXZQcpAzVVYlp0AzcGMwg%2BVHYFMQItCjFRNwFmB2wJLQB1AHQBZgd8VwxRMFczVzUDbQt6VHAPOwBzBzJWOA4%2BBWhTJgcGAmtTIFckA2wDa1c9B1UDdVU8Wi4DbwZtCGJUewU9AnAKP1ExAXgHZwktADsAdAE5Bz9XYFFrV3ZXPANiC31UJg9fAGEHa1Z%2BDmYFJFNtByICfVNxV2sDaAMwV2IHMAM1VWpabAM2BjAINVRtBTMCZQp4UTwBbwdsCS0AdQB0AWYHfFcMUTVXNVckA2ILLFRpD3MAOgc4VjAOLQVwUz8HJQI%2BU2JXYgM7AyhXMAdmA3BVJlo5A24GYQhYVDwFawItCmNRJAFtByUJNQA1AD0BIQdrV2VRYFc2VzEDIQs1VC8%3D'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response, true);
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
								setTimeout(function() { 
									map = L.map('main-map', {
										center: [<?= $response['results_center'][0] ?>, <?= $response['results_center'][1] ?>],
										zoom: 8+1,
										dragging: !L.Browser.mobile,
										tap: !L.Browser.mobile
									});     
									L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
										attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
									}).addTo(map);

									var positron = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(map);
									<?php foreach($response['results_map'] as $item): ?>
										var marker = L.marker(
											[<?= isset($item['latLng'][0]) ? $item['latLng'][0] : '' ?>, <?= isset($item['latLng'][1]) ? $item['latLng'][1] : '' ?>],
											{icon: L.divIcon({
													html: '<img src="<?= $item['options']['icon'] ?>">',
													className: 'open_steet_map_marker google_marker',
													iconSize: [35, 45],
													popupAnchor: [-1, -25],
													iconAnchor: [17, 47],
												})
											}
										)
										<?php
											$preview = str_replace("'", "\'", isset($item['data']) ? $item['data'] : '');
											$preview = str_replace('"', '\"', $preview);
											$preview = str_replace(array("\n", "\r"), '', $preview);
										?>
										marker.bindPopup('<?= $preview; ?>', jpopup_customOptions);
										clusters.addLayer(marker);
										markers.push(marker);
									<?php endforeach; ?>
									map.addLayer(clusters);    

									/* set center */
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
								}, 2000);
							}
							$(document).on('click','#search-start',function(){
								manualSearch(0);
								return false;
							});
							function manualSearch(v_pagenum){
								var data = {
									order: 'id DESC',
									view: 'grid',
									page_num: v_pagenum
								};
								$('#search-start').addClass('loading');
								if($('#booking_date_from').length > 0)
								{
									if($('#booking_date_from').val() != '')
										data['v_booking_date_from'] = $('#booking_date_from').val();
								}
								
								if($('#booking_date_to').length > 0)
								{
									if($('#booking_date_to').val() != '')
										data['v_booking_date_to'] = $('#booking_date_to').val();
								}

								$('.search-form  input:not(.skip), .search-form  select:not(.skip)').each(function (i) {
									if($(this).attr('type') == 'checkbox')
									{
										if ($(this)[0].checked)
										{
											data['v_'+$(this).attr('id')] = $(this).val();
										}
									}
									else if($(this).attr('type') == 'radio')
									{   
										if ($(this)[0].checked)
										{
											data['v_'+$(this).attr('name')] = $(this).attr('rel');
										}
									}
									else if($(this).hasClass('tree-input'))
									{
										if($(this).val() != '')
										{
											var tre_id_split = $(this).attr('id').split('_');
											if(data['v_search_option_'+tre_id_split[2]] == undefined)
												data['v_search_option_'+tre_id_split[2]] = '';
											data['v_search_option_'+tre_id_split[2]]+= $(this).find("option:selected").text()+' - ';
										}
									}
									else
									{
										if(typeof $(this).attr('id') !='undefined' && $(this).attr('id') !='undefined' && $(this).val() != '' && $(this).val() != 'NULL' && $(this).val() != null){
											data['v_'+$(this).attr('id')] = $(this).val();
										}
									}
								});
								$('.form-additional input:not(.skip), .form-additional select:not(.skip)').each(function (i) {
									if($(this).hasClass('tree-input'))
									{
										if($(this).val() != '')
										{
											var tre_id_split = $(this).attr('id').split('_');
											if(data['v_search_option_'+tre_id_split[2]] == undefined)
												data['v_search_option_'+tre_id_split[2]] = '';
											
											data['v_search_option_'+tre_id_split[2]]+= $(this).find("option:selected").text()+' - ';
										}
									}
								});
								$.post("https://portal.exileart.it/index.php/frontend/ajax/it/178/"+v_pagenum, data,
								function(data){
									if(mapRefresh && $('#main-map').length > 0)
									{
										if(map=="init") {
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
											var positron = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(map);
											map.addLayer(clusters);
										}
										for (var i = 0; i < markers.length; i++) {
											clusters.removeLayer(markers[i]);
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
															html: '<img src="'+listing.options.icon+'">',
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
						<?= $response['html'] ?>
					</div>
				</div>
			</div>
		</div>
		<div class="widget-results">
			<?= $response['results'] ?>
		</div>
		<?php
	}
}
