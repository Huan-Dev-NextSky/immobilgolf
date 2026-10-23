<div class="widget widget-box box-container">
    <div class="widget-header text-uppercase"><span class="marker-proprieta"><img src="assets/img/immobilgolf/marker_immobilgolf.png" width="25px" alt="immobilgolf"></span>
       <?php echo _l('Property location');?>
    </div>
    <?php if(!empty($estate_data_gps)): ?>
        <div class="places_select" style="display: none;">
            <a class="btn btn-large" data-rel="hospital,health"><img src="assets/img/places_icons/hospital.png" alt='hospital,health'/> {lang_Health}</a>
            <a class="btn btn-large" data-rel="park"><img src="assets/img/places_icons/park.png" alt='park' /> {lang_Park}</a>
            <a class="btn btn-large" data-rel="atm,bank"><img src="assets/img/places_icons/atm.png" alt='atm'/> {lang_ATMBank}</a>
            <a class="btn btn-large" data-rel="gas_station"><img src="assets/img/places_icons/petrol.png" alt="gas_station"/> {lang_PetrolPump}</a>
            <a class="btn btn-large" data-rel="food,bar,cafe,restourant"><img src="assets/img/places_icons/restourant.png" alt="food" /> {lang_Restourant}</a>
            <a class="btn btn-large" data-rel="store"><img src="assets/img/places_icons/store.png" alt="store"/> {lang_Store}</a>
        </div>
        <div class="property-map" id='property-map' style='height: 385px;'></div>
    <?php else: ?>
        <p class="alert alert-success"><?php _l('Not available'); ?></p>
    <?php endif;?>
    
    <div class="route_suggestion form-additional">
        <input id="route_from" class="inputtext w360 form-control" type="text" value="" placeholder="<?php echo lang_check('Type your address');?>" name="route_from" />
        <a id="route_from_button" href="#" class="btn-second"><?php echo _l('Suggest route');?></a>
    </div>
    <br />
    <?/*php if(config_db_item('walkscore_enabled') == TRUE && !empty($estate_data_address) && !empty($estate_data_gps)): ?>
        <script type='text/javascript'>
        var ws_wsid = '';
        <?php
        if(!empty($estate_data_gps))
        {
            $GPS_DATA = explode(',', $estate_data_gps);

            if(sw_count($GPS_DATA) == 2)
            {
                echo "var ws_lat = '".trim($GPS_DATA[0])."';\n";
                echo "var ws_lon = '".trim($GPS_DATA[1])."';\n";
            }
        }
        else
        {
            echo "var ws_address = '$estate_data_address';";
        }
        ?>
        <?php
        $base_url = base_url();
        $url_protocol='http://';
        if(strpos( $base_url,'https')!== false){
            $url_protocol='https://';
        }
        ?> 
        var ws_width = '500';
        var ws_height = '336';
        var ws_layout = 'horizontal';
        var ws_commute = 'true';
        var ws_transit_score = 'true';
        var ws_map_modules = 'all';
        </script><div id='ws-walkscore-tile'><div id='ws-footer' style='position:absolute;top:318px;left:8px;width:488px'><form id='ws-form'><a id='ws-a' href='<?php echo $url_protocol;?>www.walkscore.com/' target='_blank'>What's Your Walk Score?</a><input type='text' id='ws-street' style='position:absolute;top:0px;left:170px;width:286px' /><input type='submit' id='ws-go' value="<?php echo lang_check('Go');?>" style='position:absolute;top:0px;right:0px' /></form></div></div><script type='text/javascript' src='<?php echo $url_protocol;?>www.walkscore.com/tile/show-walkscore-tile.php'></script>
    <?php endif;*/ ?>
</div>  <!-- /. widget-map and walkscore -->   
  
<?php if(!empty($estate_data_gps)): ?>
<script>
    
     
<?php if(config_db_item('map_version') =='open_street'):?>
$(document).ready(function(){
    var property_map;
    if($('#property-map').length){
        property_map = L.map('property-map', {
            center: [{estate_data_gps}],
            zoom: {settings_zoom}+5,
            scrollWheelZoom: scrollWheelEnabled,
            dragging: !L.Browser.mobile,
            tap: !L.Browser.mobile
        });     
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(property_map);
        //var positron = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(property_map);
        var property_marker = L.marker(
            [{estate_data_gps}],
            {icon: L.divIcon({
                    html: '<img src="{estate_data_icon}">',
                    className: 'open_steet_map_marker google_marker',
                    iconSize: [35, 45],
                    popupAnchor: [-1, -35],
                    iconAnchor: [17, 47],
                })
            }
        ).addTo(property_map);

        property_marker.bindPopup("{estate_data_address}<br />{lang_GPS}: {estate_data_gps}");
    }
})
<?php else:?>    
     
    var IMG_FOLDER = "assets/js/dpejes";
    var map;
    $(document).ready(function(){

        // map init    
        if($('#property-map').length){
            var myLocationEnabled = true;
            var style_map =[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}];
            var scrollwheelEnabled = false;

            var markers1 = new Array();
            var mapOptions1 = {
                center: new google.maps.LatLng({estate_data_gps}),
                zoom: {settings_zoom}+6,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: scrollwheelEnabled,
                styles:style_map
            };

            map = new google.maps.Map(document.getElementById('property-map'), mapOptions1);
            map_propertyLoc = map  

                var myLatlng = new google.maps.LatLng({estate_data_gps});
                var callback = {
                            'click': function(map, e){
                                var activemarker = e.activemarker;
                                jQuery.each(markers1, function(){
                                    this.activemarker = false;
                                })

                                if(activemarker) {
                                    infowindow.close();
                                    e.activemarker = false;
                                    return true;
                                }

                                infowindow.setContent("<div class='infobox2'><?php _jse($estate_data_address); ?> <br />{lang_GPS}: {estate_data_gps}</div>");
                                infowindow.open(map, e);

                                e.activemarker = true;
                            }
                    };
                var marker_inner ='<div class="google_marker"><img src="assets/img/markers/house.png"></div>';
                var marker = new CustomMarker(myLatlng,map_propertyLoc,marker_inner,callback);

                markers1.push(marker);

            if(myLocationEnabled){
                var controlDiv = document.createElement('div');
                controlDiv.index = 1;
                map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);
                HomeControl(controlDiv, map)
            }

        } 

        <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/places.js')): ?>       
        // init_gmap_searchbox();
        if (typeof swplaces_init_directions == 'function')
         {
             $(".places_select a").click(function(){
                 init_places($(this).attr('data-rel'), $(this).find('img').attr('src'));
             });

             var selected_place_type = 4;

             swplaces_init_directions();
             directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});


             directionsDisplay.setMap(map);
             init_places($(".places_select a:eq("+selected_place_type+")").attr('data-rel'), $(".places_select a:eq("+selected_place_type+") img").attr('src'));

         }
        <?php endif;?>
    }); 

    <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/places.js')): ?>  
    var map_propertyLoc;
    var markers = [];
    var generic_icon;

    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var placesService;

    function init_places(places_types, icon) {
        var pyrmont = new google.maps.LatLng({estate_data_gps});

        setAllMap_near(null);

        generic_icon = icon;


        var places_type_array = places_types.split(','); 

        var request = {
            location: pyrmont,
            radius: 2000,
            types: places_type_array
        };

        infowindow = new google.maps.InfoWindow();
        placesService = new google.maps.places.PlacesService(map);
        placesService.nearbySearch(request, callback);

    }

    function callback(results, status) {
      if (status == google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
          createMarker(results[i]);
        }
      }
    }

    function setAllMap_near(map) {
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
      }
    }

    function calcRoute(source_place, dest_place) {
      var selectedMode = 'WALKING';
      var request = {
          origin: source_place,
          destination: dest_place,
          // Note that Javascript allows us to access the constant
          // using square brackets and a string value as its
          // "property."
          travelMode: google.maps.TravelMode[selectedMode]
      };

      directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
          directionsDisplay.setDirections(response);
          //console.log(response.routes[0].legs[0].distance.value);
        }
      });
    }

    function createMarker(place) {
      var placeLoc = place.geometry.location;
      var propertyLocation = new google.maps.LatLng({estate_data_gps});

        if(place.icon.indexOf("generic") > -1)
        {
            place.icon = generic_icon;
        }

        var image = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25)
        };

      var marker = new google.maps.Marker({
        map: map,
        icon: image,
        position: place.geometry.location
      });

      markers.push(marker);

      var distanceKm = (calcDistance(propertyLocation, placeLoc)*1.2).toFixed(2);
      var walkingTime = parseInt((distanceKm/5)*60+0.5);

      google.maps.event.addListener(marker, 'click', function() {

            //drawing route
            calcRoute(propertyLocation, placeLoc);

        // Fetch place details
        placesService.getDetails({ placeId: place.place_id }, function(placeDetails, statusDetails){



            //open popup infowindow
            infowindow.setContent(place.name+'<br />{lang_Distance}: '+distanceKm+'{lang_Km}'+
                                  '<br />{lang_WalkingTime}: '+walkingTime+'{lang_Min}'+
                                  '<br /><a target="_blank" href="'+placeDetails.url+'">{lang_Details}</a>');
            infowindow.open(map_propertyLoc, marker);
        });

      });
    }

    //calculates distance between two points
    function calcDistance(p1, p2){
      return (google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
    }
    <?php endif;?>
    
<?php endif;?>   
$("#route_from_button").click(function () { 
    window.open("https://maps.google.hr/maps?saddr="+$("#route_from").val()+"&daddr={estate_data_address}@{estate_data_gps}&hl={lang_code}",'_blank');
    return false;
}); 
       
</script>
<?php endif;?>

