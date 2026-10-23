<!DOCTYPE html>
<html lang="en">
<head>
    <?php _widget('head');?>
    
    <style type="text/css">
        #main-map {
            height: 100vh;
            position: sticky !important;
            top: 0;
        }
        .content-left {
            /* Imposta la larghezza base a 40% e impedisce la crescita (grow) o riduzione (shrink) */
            flex: 0 0 45%; 
            /* Metodo alternativo e più diretto: */
            /* width: 40%; */
        }
        
        .content-right {
            /* Imposta la larghezza base a 60% e impedisce la crescita (grow) o riduzione (shrink) */
            flex: 0 0 55%; 
            /* Metodo alternativo e più diretto: */
            /* width: 60%; */
        }
        .content-flex .content-right {
        max-width: 2850px;
        min-width: 150px;
        }
                
        @media (min-width: 992px) {
            .properties.view-grid .thumbnail-g {
                -webkit-box-flex: 0;
                -webkit-flex: 0 0 50%;
                -ms-flex: 0 0 50%;
                flex: 0 0 50%;
                max-width: 50%;
            }
        }
        
        <?php
        /* [START] Search background settings */
        $this->data['search_background'] = '';
        if(isset($this->data['settings']['search_background']))
        {
            if(is_numeric($this->data['settings']['search_background']))
            {
                $files_search_background = $this->file_m->get_by(array('repository_id' => $this->data['settings']['search_background']), TRUE);
                if( is_object($files_search_background) && file_exists(FCPATH.'files/thumbnail/'.$files_search_background->filename))
                {
                    $this->data['search_background'] = base_url('files/'.$files_search_background->filename);
                }
            }
        }
        ?>
        .content-right .search-form  {
            background-image: url('<?php echo $this->data['search_background']; ?>');   
        }
        <?php
        /* [END] Search background settings */
        ?>
    </style>
    
</head>

<body class="<?php _widget('custom_paletteclass');?>">
    <div class="container container-wrapper container-side-version">
    <header class="header">
        <div class="top-box" data-toggle="sticky-onscroll">
            <div class="container">
                <?php _widget('header_loginmenu');?>
                <?php _widget('header_mainmenu');?>
            </div> 
        </div>
    </header><!-- /.header--> 
    <main class="main section-color-primary">
        <div class="container">
            <div class="content-flex">
                <div class="content-left">
                    <div id="main-map"></div>
                </div><!-- /.map-listing -->
                <div class="content-right">
                    <?php _widget('custom_right_searchside');?>
                    <?php _widget('custom_right_recentproperties');?>
                </div><!-- /.center-content -->
            </div>
        </div>
    </main><!-- /.main-part--> 
    <?php _widget('bottom_agenciescarousel');?>
    <?php _widget('bottom_defaultcontent');?>
    <?php _widget('bottom_agentscarouselwide');?>
    
    <!-- footer -->
    <?php _widget('custom_footer');?>
    <!-- /.footer --> 
</div>
<?php _widget('custom_palette');?>
<?php _widget('custom_javascript');?>
<script>
var markers = new Array();
var map;
$(document).ready(function(){
    // option
    var scrollwheelEnabled = true;
    if($('#main-map').length){
        
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
        
    var myLocationEnabled = true;
    var style_map =[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}];
    var scrollwheelEnabled = false;
    
    var markers = new Array();
    var mapOptions = {
        <?php if(config_item('custom_map_center') === FALSE): ?>
        center: new google.maps.LatLng({all_estates_center}),
        <?php else: ?>
        center: new google.maps.LatLng(<?php echo config_item('custom_map_center'); ?>),
        <?php endif; ?>
        zoom: {settings_zoom},
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: scrollwheelEnabled,
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
    /*
    $(function(){
        var contentRightHeight = $('.content-right').outerHeight()+5;

        $(document).scroll(function(){
            if($(window).width()> 992){
                var topBar = $('.top-box').outerHeight();
                var scrollTop = $(window).scrollTop();

                var marginTop = scrollTop - topBar;

                if(marginTop>0) {

                    if($('#main-map').parent().outerHeight() < contentRightHeight){
                        $('#main-map').css('margin-top',marginTop+'px');
                    }else if( parseInt($('#main-map').css('margin-top')) > marginTop ) {
                        $('#main-map').css('margin-top',marginTop+'px');
                    }


                } else {
                    $('#main-map').css('margin-top', '0');
                }
            } else {
                $('#main-map').css('margin-top', '0');
            }
        })

    })
*/
</script>
</body>
</html>