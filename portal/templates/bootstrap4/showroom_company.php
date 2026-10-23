<!DOCTYPE html>
<html lang="en">
<head>
    <?php _widget('head');?>
</head>

<body class="<?php _widget('custom_paletteclass');?>">
<div class="container container-wrapper">
    <header class="header">
        <div class="top-box" data-toggle="sticky-onscroll">
            <div class="container">
                <?php _widget('header_loginmenu');?>
                <?php _widget('header_mainmenu');?>
            </div> 
        </div>
    </header><!-- /.header--> 
    <?php _widget('top_titlebreadcrumb2');?>
    
    <main class="main main-container section-color-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <?php if(file_exists(APPPATH.'controllers/admin/expert.php')):?>
                    <section class="widget">
                    
                        <div class="box-overflow-container box-container">
                            <div class="box-container-title">
                                <h2 class="title">{page_title}</h2> 
                            </div> <!-- /. content-header --> 
                            <div class="widget-content">
                                {page_body}
                                {has_page_documents}
                                <h5>{lang_Filerepository}</h5>
                                <ul>
                                {page_documents}
                                <li>
                                    <a href="<?php _che($url) ;?>">{filename}</a>
                                </li>
                                {/page_documents}
                                </ul>
                                {/has_page_documents}
                            </div>
                            
                        </div>
                    </section>
                    <?php endif;?>
                    <div class="widget widget-box box-container">
                        <div class="widget-header text-uppercase">
                           {lang_Locationonmap}
                        </div>
                        <div class="location-map" id='location-map' style='height: 385px;'></div>
                    </div>  <!-- /. widget-map -->   
                    <?php _widget('center_imagegallery');?>

                </div><!-- /.center-content -->
                <div class="col-lg-3 sidebar">
                    
                    <div class="widget widget-box box-container">
                        <div class="widget-header text-uppercaser">{lang_Enquireform}</div>
                        <div class="widget-body">                              
                            <p class="bottom-border"><strong>
                              {lang_Company}
                              </strong> <span>{page_title}</span>
                              <br style="clear: both;" />
                              </p>
                              <p class="bottom-border"><strong>
                              {lang_Address}
                              </strong> <span>{showroom_data_address}</span>
                              <br style="clear: both;" />
                              </p>
                              <p class="bottom-border"><strong>
                              {lang_Keywords}
                              </strong> <span>{page_keywords}</span>
                              <br style="clear: both;" />
                            </p>
                        </div>
                    </div><!-- /.widget--> 
                    
                    <div class="widget widget-form" id="form">
                        <form action="{page_current_url}#form" method="post">
                            <div class="box-container widget-box">
                                <div class="widget-header text-uppercaser">{lang_AskExpert}</div>
                                {validation_errors} {form_sent_message}
                                <div class="form-additional">
                                    {validation_errors} {form_sent_message}
                                    <!-- The form name must be set so the tags identify it -->
                                    <input type="hidden" name="form" value="contact" />
                                    
                                    <div class="form-group {form_error_firstname}">
                                        <input class="form-control" id="firstname" name="firstname" type="text" placeholder="{lang_FirstLast}" value="{form_value_firstname}" />
                                    </div>
                                    <div class="form-group {form_error_email}">
                                        <input class="form-control" id="email" name="email" type="text" placeholder="{lang_Email}" value="{form_value_email}" />
                                    </div>
                                    <div class="form-group {form_error_phone}">
                                        <input class="form-control" id="phone" name="phone" type="text" placeholder="{lang_Phone}" value="{form_value_phone}" />
                                    </div>
                                    
                                    <div class="form-group {form_error_address}">
                                        <input class="form-control" id="address" name="address" type="text" placeholder="{lang_Address}" value="{form_value_address}" />
                                    </div>
                                    
                                    <div class="form-group  {form_error_message}">
                                        <textarea id="message" name="message" rows="3" class="form-control" placeholder="{lang_Message}">{form_value_message}</textarea>
                                    </div>
                                                     
                                <?php if(config_db_item('terms_link') !== FALSE): ?>
                                <?php
                                    $site_url = site_url();
                                    $urlparts = parse_url($site_url);
                                    $basic_domain = $urlparts['host'];
                                    $terms_url = config_db_item('terms_link');
                                    $urlparts = parse_url($terms_url);
                                    $terms_domain ='';
                                    if(isset($urlparts['host']))
                                        $terms_domain = $urlparts['host'];

                                    if($terms_domain == $basic_domain) {
                                        $terms_url = str_replace('en', $lang_code, $terms_url);
                                    }
                                ?>
                                <div class="control-group control-gt-terms">
                                  <div class="controls">
                                    <?php echo form_checkbox('option_agree_terms', 'true', set_value('option_agree_terms', false), 'class="ezdisabled" id="inputOption_terms"')?>
                                  <a target="_blank" href="<?php echo $terms_url; ?>"><?php echo lang_check('I Agree To The Terms & Conditions'); ?></a>
                                    </div>
                                </div>
                                <?php endif; ?>
                                



                                <?php if(config_db_item('privacy_link') !== FALSE && sw_count($not_logged)>0): ?>
                                                            <?php

                                $site_url = site_url();
                                $urlparts = parse_url($site_url);
                                $basic_domain = $urlparts['host'];
                                $privacy_url = config_db_item('privacy_link');
                                $urlparts = parse_url($privacy_url);
                                $privacy_domain ='';
                                if(isset($urlparts['host']))
                                    $privacy_domain = $urlparts['host'];

                                if($privacy_domain == $basic_domain) {
                                    $privacy_url = str_replace('en', $lang_code, $privacy_url);
                                }
                            ?>
                                <div class="control-group control-gt-terms">
                                  
                                  <div class="controls">
                                    <?php echo form_checkbox('option_privacy_link', 'true', set_value('option_privacy_link', false), 'class="novalidate" required="required" id="inputOption_privacy_link"')?>
                                 <a target="_blank" href="<?php echo $privacy_url; ?>"><?php echo lang_check('I Agree The Privacy'); ?></a>
 </div>
                                </div>
                                <?php endif; ?>
                                    <div class="form-group form-group-submit">
                                          <input type="submit" class="btn btn-primary btn-wide color-primary btn-property" value="{lang_Send}" >
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.widget-form--> 
                </div>
                <!-- /.right side bar -->
            </div>
        </div>
    </main><!-- /.main-part--> 

    <!-- footer -->
    <?php _widget('custom_footer');?>
    <!-- /.footer --> 
</div>
<?php _widget('custom_palette');?>
<?php _widget('custom_javascript');?>
    
    <script >
 
    var map;
    $(document).ready(function(){
        
    $("#route_from_button").click(function () { 
         window.open("https://maps.google.hr/maps?saddr="+$("#route_from").val()+"&daddr={showroom_data_address}@{showroom_data_gps}&hl={lang_code}",'_blank');
         return false;
     });
        
    if($('#location-map').length){
        <?php if(config_db_item('map_version') =='open_street'):?>
        var property_map;
        property_map = L.map('location-map', {
            center: [{showroom_data_gps}],
            zoom: {settings_zoom},
            scrollWheelZoom: scrollWheelEnabled,
        });     
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(property_map);
        //var positron = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(property_map);
        var property_marker = L.marker(
            [{showroom_data_gps}]
           
        ).addTo(property_map);

        property_marker.bindPopup("{showroom_data_address}<br />{lang_GPS}: {showroom_data_gps}");
        <?php else:?>
        var myLocationEnabled = true;
        var style_map =[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}];
        var scrollwheelEnabled = false;

        var markers = new Array();
        var mapOptions = {
            center: new google.maps.LatLng({showroom_data_gps}),
            zoom: {settings_zoom},
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: scrollwheelEnabled,
            styles:style_map
        };

        var map = new google.maps.Map(document.getElementById('location-map'), mapOptions);

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng({showroom_data_gps}),
            map: map,
        });

        var myOptions = {
            content: "<div class='infobox2'>{showroom_data_address}<br />{lang_GPS}: {showroom_data_gps}</div>",
            disableAutoPan: false,
            maxWidth: 0,
            pixelOffset: new google.maps.Size(-138, -110),
            zIndex: null,
            closeBoxURL: "",
            infoBoxClearance: new google.maps.Size(1, 1),
            position: new google.maps.LatLng({showroom_data_gps}),
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
    
</body>
</html>