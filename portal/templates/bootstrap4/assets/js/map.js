$(document).ready(function() {


/*LoadMap_main();*/
/*map_property();*/

});


function LoadMap_main() {
    
    // option
    if($('#main-map').length){
    var myLocationEnabled = true;
    var style_map =[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}];
    var scrollwheelEnabled = false;
    
    var markers = new Array();
    var mapOptions = {
        center: new google.maps.LatLng(34.015008, -118.473215),
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: scrollwheelEnabled,
        styles:style_map
    };
    var markers_map = new Array(
                     [34.05843,-118.491046, 'assets/img/markers/hause.png'],
                     [34.066673,-118.486562, 'assets/img/markers/comercial.png'],
                     [34.009714,-118.480296, 'assets/img/markers/hause.png'],
                     [34.010408,-118.473215, 'assets/img/markers/land.png'],
                     [34.01521,-118.474889, 'assets/img/markers/apartment.png'],
                     [34.022502,-118.480124, 'assets/img/markers/hause.png'],
                     [34.024423,-118.459868, 'assets/img/markers/land.png'],
                     [34.024885,-118.44871, 'assets/img/markers/comercial.png'],
                     [34.002368,-118.482828, 'assets/img/markers/apartment.png']
            );

    var map = new google.maps.Map(document.getElementById('main-map'), mapOptions);

    $.each(markers_map, function(index, marker_map) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(marker_map[0], marker_map[1]),
            map: map,
            icon: marker_map[2]
        });

	    var myOptions = {
	        content: '<div class="infobox">\n\
                            <div class="image hover-default">\n\
                                <img src="assets/img/property-3.jpg" alt="">\n\
                                <a href="property.htm" class="property-card-hover">\n\
                                    <img src="assets/img/property-hover-arrow.png" alt="" class="left-icon">\n\
                                    <img src="assets/img/plus.png" alt="" class="center-icon">\n\
                                    <img src="assets/img/icon-notice.png" alt="" class="right-icon">\n\
                                </a>\n\
                            </div>\n\
                            <div class="title">\n\
                                <a href="property.htm">Naslov nekretnina</a>\n\
                            </div>\n\
                            <div class="content clearfix">\n\
                                <div class="pull-left">\n\
                                       Ivana Ivankovića 35, <br> \n\
                                        42000 Varaždin <br>  \n\
                                        Hrvatska            \n\
                                </div>\n\
                                <div class="pull-right">\n\
                                      <a href="property.htm" class="infobox-link-btn">View details</a>                \n\
                                </div>\n\
                            </div>\n\
                                <div class="infobox-footer">\n\
                                    <div class="property-preview-f-left"> \n\
                                        <span class="property-card-value"> \n\
                                            <i class="fa fa-home"></i>House \n\
                                        </span> \n\
                                        <span class="property-card-value"> \n\
                                            <i class="fa fa-tint"></i>1 \n\
                                        </span> \n\
                                        <span class="property-card-value"> \n\
                                            <i class="fa fa-square-o"></i>200m \n\
                                        </span> \n\
                                        <span class="property-card-value"> \n\
                                            <i class="fa fa-eur"></i>60 000 \n\
                                        </span> \n\
                                    </div> \n\
                                </div>\n\
                            </div>',
	        disableAutoPan: false,
	        maxWidth: 0,
	        pixelOffset: new google.maps.Size(-138, -360),
	        zIndex: null,
	        closeBoxURL: "",
	        infoBoxClearance: new google.maps.Size(1, 1),
	        position: new google.maps.LatLng(marker_map[0], marker_map[1]),
	        isHidden: false,
	        pane: "floatPane",
	        enableEventPropagation: false
	    };
            marker.infobox = new InfoBox(myOptions);
            marker.infobox.isOpen = false;
            markers.push(marker);
                
        // action        
        google.maps.event.addListener(marker, "click", function (e) {
            var curMarker = this;

            $.each(markers, function (index, marker) {
                // if marker is not the clicked marker, close the marker
                if (marker !== curMarker) {
                    marker.infobox.close();
                    marker.infobox.isOpen = false;
                }
            });

            if(curMarker.infobox.isOpen === false) {
                curMarker.infobox.open(map, this);
                curMarker.infobox.isOpen = true;
                map.panTo(curMarker.getPosition());
            } else {
                curMarker.infobox.close();
                curMarker.infobox.isOpen = false;
            }

        });
    });
    
    mcOptions = {
            gridSize: 40,
            styles: [
                    {
                        height   : 40,
                        url      : 'assets/img/cluster/cluster.png',
                        width    : 40,
                        textColor: '#46616B'
                    }
            ]
        };
    
    var marker_clusterer = new MarkerClusterer(map, markers, mcOptions);
    if(myLocationEnabled){
        // [START gmap mylocation]

        // Construct your control in whatever manner is appropriate.
        // Generally, your constructor will want access to the
        // DIV on which you'll attach the control UI to the Map.
        var controlDiv = document.createElement('div');

        // We don't really need to set an index value here, but
        // this would be how you do it. Note that we set this
        // value as a property of the DIV itself.
        controlDiv.index = 1;

        // Add the control to the map at a designated control position
        // by pushing it on the position's array. This code will
        // implicitly add the control to the DOM, through the Map
        // object. You should not attach the control manually.
        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);

        HomeControl(controlDiv, map)

        // [END gmap mylocation]
    }
    }
}
/*
function HomeControl(controlDiv, map) {

    // Set CSS styles for the DIV containing the control
    // Setting padding to 5 px will offset the control
    // from the edge of the map.
    controlDiv.style.padding = '5px';

    // Set CSS for the control border.
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = 'white';
    controlUI.style.borderStyle = 'solid';
    controlUI.style.borderWidth = '2px';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginTop = '5px';
    controlUI.style.marginRight = '5px';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'My Location';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior.
    var controlText = document.createElement('div');
    controlText.style.fontFamily = 'Arial,sans-serif';
    controlText.style.fontSize = '12px';
    controlText.style.paddingLeft = '4px';
    controlText.style.paddingRight = '4px';
    controlText.innerHTML = '<strong>My Location</strong>';
    controlUI.appendChild(controlText);

    // Setup the click event listeners: simply set the map to Chicago.
    google.maps.event.addDomListener(controlUI, 'click', function() {
      var myloc = new google.maps.Marker({
          clickable: false,
          icon: new google.maps.MarkerImage('//maps.gstatic.com/mapfiles/mobile/mobileimgs2.png',
                                                          new google.maps.Size(22,22),
                                                          new google.maps.Point(0,18),
                                                          new google.maps.Point(11,11)),
          shadow: null,
          zIndex: 999,
          map: map
      });

      if (navigator.geolocation) navigator.geolocation.getCurrentPosition(function(pos) {
          var me = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
          myloc.setPosition(me);

          // Zoom in
          var bounds = new google.maps.LatLngBounds();
          bounds.extend(me);
          map.fitBounds(bounds);
          var zoom = map.getZoom();
          map.setZoom(zoom > zoomOnMapSearch ? zoomOnMapSearch : zoom);
      }, function(error) {
          console.log(error);
      });
    });
  }
 */ 
  
function map_property () {
    if($('#property-map').length){
    var myLocationEnabled = true;
    var style_map =[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}];
    var scrollwheelEnabled = false;
    
    var markers = new Array();
    var mapOptions = {
        center: new google.maps.LatLng(34.05843,-118.491046),
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: scrollwheelEnabled,
        styles:style_map
    };
    var map = new google.maps.Map(document.getElementById('property-map'), mapOptions);

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(34.05843,-118.491046),
            map: map,
            icon: 'assets/img/markers/hause.png'
        });
    
    mcOptions = {
            gridSize: 40,
            styles: [
                    {
                        height   : 40,
                        url      : 'assets/img/cluster/cluster.png',
                        width    : 40,
                        textColor: '#46616B'
                    }
            ]
        };
    
    if(myLocationEnabled){
        // [START gmap mylocation]

        // Construct your control in whatever manner is appropriate.
        // Generally, your constructor will want access to the
        // DIV on which you'll attach the control UI to the Map.
        var controlDiv = document.createElement('div');

        // We don't really need to set an index value here, but
        // this would be how you do it. Note that we set this
        // value as a property of the DIV itself.
        controlDiv.index = 1;

        // Add the control to the map at a designated control position
        // by pushing it on the position's array. This code will
        // implicitly add the control to the DOM, through the Map
        // object. You should not attach the control manually.
        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);

        HomeControl(controlDiv, map)

        // [END gmap mylocation]
    }
    } 
    
    
}  