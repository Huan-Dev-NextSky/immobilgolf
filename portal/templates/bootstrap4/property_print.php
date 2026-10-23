<!DOCTYPE html>
<html lang="en">
<head>
    <?php _widget('head');?>
    <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/dpejes/dpe.js')): ?>
    <script src="assets/js/dpejes/dpe.js"></script>
    <?php endif; ?>
    
    <!-- Start BOOTSTRAP -->
    <link rel="stylesheet" href="assets/libraries/tether/dist/css/tether.min.css" media="all">

    <link rel="stylesheet" href="assets/libraries/bootstrap/dist/css/bootstrap.min.css" media="all">

    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css" media="all">

    <link rel="stylesheet" href="assets/libraries/bootstrap-colorpicker-master/dist/css/bootstrap-colorpicker.min.css" media="all">
    <!-- End Bootstrap -->

    <!-- Start Template files -->
    <link rel="stylesheet" href="assets/css/winter-flat.css" media="all">
    <link rel="stylesheet" href="assets/css/custom.css" media="all">
    <!-- End  Template files -->

    <!-- Start owl-carousel -->
    <link rel="stylesheet" href="assets/libraries/owl.carousel/assets/owl.carousel.css" media="all">
    <!-- End owl-carousel -->

    <!-- Start palette -->
    <link rel="stylesheet" href="assets/css/palette.css" media="all">
    <!-- End palette -->

    <!-- Start blueimp  -->
    <link rel="stylesheet" href="assets/css/blueimp-gallery.min.css" media="all">
    <!-- End blueimp  -->
    
    <!-- Start kevalbhatt-worldmapgenerator http://kevalbhatt.github.io/WorldMapGenerator/ -->
    <script src="assets/libraries/kevalbhatt-worldmapgenerator/worldmapgenerator.js" type="text/javascript"></script>
    <!-- End kevalbhatt-worldmapgenerator  -->
    
    
    
    <link rel="stylesheet" href="assets/css/print.css"  media="print"/>
    
     <style type="text/css">
        @media screen {

        }

        @media print {
          .print_hidden{
              display:none;
          }
          
          #google_my_location,
          .popup-with-form-report,
          .route_suggestion,
          .favorite {
            display:none !important;
          }
          
          .property-map {
              max-height:inherit; 
          }
          
         a:after {content:" " !important; }
         .widget {
            margin-bottom: 0;
        }
    }
    
        .widget {
          page-break-inside: avoid;
      }
      </style>
    
</head>

<body class="<?php _widget('custom_paletteclass');?>">
<div class="container container-wrapper">
    <div class="container container-wrapper">
    
    <main class="main section-color-primary">
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <?php _widget('property_center_preview-property');?>
                    <?php _widget('property_center_description');?>
                    <?php _widget('property_center_amenities_indoor');?>
                    <?php _widget('property_center_amenities_outdoor');?>
                    <?php _widget('property_center_distances');?>
                    <?php _widget('property_center_map-walkscore');?>
                </div><!-- /.center-content -->
                <div class="col-3 sidebar">
                    <?php _widget('property_right_overview');?>
                    <p style="text-align:right;">
                        <button class="print_hidden" onclick="myFunction()"><?php echo lang_check('Print'); ?></button> <script> function myFunction() { window.print(); } </script>
                    </p>
                    <?php _widget('property_right_property_energygas');?>
                    <?php _widget('property_right_agent-details');?>
                    <?php _widget('property_right_qrcode');?>
                </div>
                <!-- /.right side bar -->
            </div>
        </div>
    </main><!-- /.main-part--> 
</div>
</div>
    
<?php _widget('custom_javascript');?>
</body>
</html>