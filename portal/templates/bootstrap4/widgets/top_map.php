<?php
/*
Widget-title: Map with Results
Widget-preview-image: /assets/img/widgets_preview/top_map.jpg
*/
?>
<section class="header-slider header-map">
    <h3 class="hidden-xs-up"><?php echo _l('Map');?></h3>
    <?php if(config_db_item('map_version') !='open_street'):?>
    <input id="pac-input" class="controls" type="text" placeholder="{lang_Search}">
    <?php endif;?>   
    <div class="main-map" id="main-map" style='height:500px'></div>
</section><!-- /.header-video-->

<script>

var markers = new Array();
var map;
var marker_clusterer ;
<?php if(config_db_item('map_version') !='open_street'):?>
var infowindow = new google.maps.InfoWindow({
        content: '',
        maxWidth: 275
    });
  <?php endif;?>  
$(document).ready(function(){
    // option
    if($('#main-map').length){
    var myLocationEnabled = true;
    var style_map = mapStyle;
    var scrollwheelEnabled = true;
    
    
    <?php if(config_db_item('map_version') =='open_street'):?>

        map = L.map('main-map', {
            <?php if(config_item('custom_map_center') === FALSE): ?>
            center: [{all_estates_center}],
            <?php else: ?>
            center: [<?php echo config_item('custom_map_center'); ?>],
            <?php endif; ?>
            zoom: {settings_zoom}+1,
            scrollWheelZoom: scrollwheelEnabled,
            dragging: !L.Browser.mobile,
            tap: !L.Browser.mobile
        });     
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        //var positron = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(map);

        <?php foreach($all_estates as $item): ?>
            <?php
                if(!isset($item['gps']))break;
                if(empty($item['gps']))continue;
            ?>

            var marker = L.marker(
                [<?php _che($item['gps']); ?>],
                {icon: L.divIcon({
                        html: '<img src="<?php _che($item['icon'])?>">',
                        className: 'open_steet_map_marker google_marker',
                        iconSize: [35, 45],
                        popupAnchor: [-1, -25],
                        iconAnchor: [17, 47],
                    })
                }
            )/*.addTo(map)*/;

            marker.bindPopup("<?php echo _generate_popup($item, true); ?>", jpopup_customOptions);
            clusters.addLayer(marker);
            markers.push(marker);
        <?php endforeach; ?>
        map.addLayer(clusters);    

        <?php if(config_db_item('map_fixed_position') == FALSE): ?>
        /* set center */
        if(markers.length){
            var limits_center = [];
            for (var i in markers) {
                if(typeof markers[i]['_latlng'] == 'undefined') continue;
                var latLngs = [ markers[i].getLatLng() ];
                limits_center.push(latLngs)
            };
            var bounds = L.latLngBounds(limits_center);
            <?php if(config_db_item('auto_set_zoom_disabled') != FALSE): ?>
                map.setView(bounds.getCenter());
           <?php else:?>
                map.fitBounds(bounds);
           <?php endif;?>
        }
        <?php endif;?>
                

   <?php else:?>
    var mapOptions = {
        <?php if(config_item('custom_map_center') === FALSE): ?>
        center: new google.maps.LatLng({all_estates_center}),
        <?php else: ?>
        center: new google.maps.LatLng(<?php echo config_item('custom_map_center'); ?>),
        <?php endif; ?>
        zoom: {settings_zoom},
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: scrollwheelEnabled,
        mapTypeControlOptions: {
          mapTypeIds: c_mapTypeIds,
          position: google.maps.ControlPosition.TOP_RIGHT
        },
        styles:style_map
    };
    
    map = new google.maps.Map(document.getElementById('main-map'), mapOptions);


    <?php foreach($all_estates as $item): ?>
        <?php
            if(!isset($item['gps']))break;
        ?>
                
        
    <?php 
    $price = '';
    if(config_item('prices_on_map')== TRUE):
        if(!empty($item['option_36']) || !empty($item['option_37'])):
            $price.='<span class="price">';
                if(!empty($item['option_36']))$price.= $options_prefix_36.price_format($item['option_36'], $lang_id).$options_suffix_36;
                if(!empty($item['option_37']))$price.= ' '.$options_prefix_37.price_format($item['option_37'], $lang_id).$options_suffix_37;
            $price.='</span>';
        endif;
    endif; ?>     
        
    var myLatlng = new google.maps.LatLng(<?php _che($item['gps']); ?>);
    var callback = {
                    'click': function(map, e){
                        var activemarker = e.activemarker;
                        jQuery.each(markers, function(){
                            this.activemarker = false;
                        })
                        
                        if(activemarker) {
                            infowindow.close();
                            e.activemarker = false;
                            return true;
                        }
                        
                        infowindow.setContent("<?php echo _generate_popup($item, true); ?>");
                        infowindow.open(map, e);
                        
                        e.activemarker = true;
                    }
            };
    var marker_inner ='<div class="google_marker"><img src="<?php _che($item['icon'])?>"><?php echo _jse($price);?></div>';
    var marker = new CustomMarker(myLatlng,map,marker_inner,callback);
    markers.push(marker);
    
    <?php endforeach; ?>
    
    marker_clusterer = new MarkerClusterer(map, markers, clusterConfig);
    
    if(mapSearchbox){   
        init_map_searchbox(map);
    }  
        
    if(myLocationEnabled){
        var controlDiv = document.createElement('div');
        controlDiv.index = 1;
        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);
        HomeControl(controlDiv, map)
        }
    
   
    
    
    if(rectangleSearchEnabled)
     {
         var controlDiv2 = document.createElement('div');
         controlDiv2.index = 2;
         map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv2);
         RectangleControl(controlDiv2, map)
     } 
      <?php endif;?>
    }
})

</script>