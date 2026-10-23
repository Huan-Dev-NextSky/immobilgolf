<?php
/*
Widget-title: Contact map
Widget-preview-image: /assets/img/widgets_preview/center_contactmap.jpg
*/
?>
<div class="widget widget-box box-container">
    <div class="widget-header text-uppercase">
       <?php echo _l('Location on map');?>
    </div>
    <div class="property-map" id='contact-map' style='height: 385px;'></div>
</div>  <!-- /. widget-map  -->  

<script>
 
    $(document).ready(function(){
    var map;
        
    if($('#contact-map').length){
        
    <?php if(config_db_item('map_version') =='open_street'):?>
    var contact_map;
    contact_map = L.map('contact-map', {
        center: [{settings_gps}],
        zoom: {settings_zoom}+7,
        scrollWheelZoom: scrollWheelEnabled,
    });     
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(contact_map);
    //var positron = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(contact_map);
    var property_marker = L.marker(
        [{settings_gps}],
        {icon: L.divIcon({
                html: '<img src="assets/img/markers/house.png">',
                className: 'open_steet_map_marker google_marker',
                iconSize: [35, 45],
                popupAnchor: [-1, -35],
                iconAnchor: [17, 47],
            })
        }
    ).addTo(contact_map);

    property_marker.bindPopup("{settings_address},<br />{lang_GPS}: {settings_gps}");
    <?php else:?>
        
    var myLocationEnabled = true;
    var style_map =[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}];
    var scrollwheelEnabled = false;
    
    var markers = new Array();
    var mapOptions = {
        center: new google.maps.LatLng({settings_gps}),
        zoom: {settings_zoom},
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: scrollwheelEnabled,
        styles:style_map
    };
    
    var map = new google.maps.Map(document.getElementById('contact-map'), mapOptions);

    var myLatlng = new google.maps.LatLng({settings_gps});
    var callback = {
                'click': function(map, e){
                    var activemarker = e.activemarker;

                    if(activemarker) {
                        infowindow.close();
                        e.activemarker = false;
                        return true;
                    }

                    infowindow.setContent("<div class='infobox2'>{settings_websitetitle}<br />{lang_Address}: {settings_gps}</div>");
                    infowindow.open(map, e);

                    e.activemarker = true;
                }
        };
    var marker_inner ='<div class="google_marker"><img src="assets/img/markers/house.png"></div>';
    var marker = new CustomMarker(myLatlng,map,marker_inner,callback);
            

    if(myLocationEnabled){
        var controlDiv = document.createElement('div');
        controlDiv.index = 1;
        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);
        HomeControl(controlDiv, map)
        }
        
         <?php endif;?>
        }
    })
       
</script>