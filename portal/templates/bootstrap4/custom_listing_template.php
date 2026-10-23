<!DOCTYPE html>
<html lang="it">
<head>
    <?php _widget('head');?>
    
    <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/dpejes/dpe.js')): ?>
    <script src="assets/js/dpejes/dpe.js"></script>
    <?php endif; ?>
    
    <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/places.js')): ?>
    <script src="assets/js/places.js"></script>
    <?php endif; ?>
</head>

<body class="<?php _widget('custom_paletteclass');?>">
    
<?php if (!empty($settings_facebook_jsdk) && (config_db_item('appId') == '' || !file_exists(FCPATH . 'templates/' . $settings_template . '/assets/js/like2unlock/js/jquery.op.like2unlock.min.js'))): ?>
<?php
if (!empty($lang_facebook_code))
   $settings_facebook_jsdk = str_replace('en_EN', $lang_facebook_code, $settings_facebook_jsdk);
?>
<?php echo $settings_facebook_jsdk; ?>
<?php endif; ?>   
    
<div class="container container-wrapper">
    <header class="header">
        <div class="top-box" data-toggle="sticky-onscroll">
            <div class="container">
                <?/*php _widget('header_loginmenu');*/?>
                <?php _widget('header_mainmenu');?>
            </div> 
        </div>
    </header><!-- /.header--> 
    <?php _widget('top_titlebreadcrumb');?>
    <main class="main section-color-primary">
        <div class="container container-immobilgolf">
            <div class="row">
                <div class="col-lg-8">
                    <?/*php
                    foreach ($widgets_order->center as $widget_filename) {
                        _widget('property_'.$widget_filename);
                    }
                    */?>
                    <?php
                    foreach ($widgets_order->center as $widget_filename) {
                        if ($widget_filename !== 'center_otherlistings') {
                            _widget('property_' . $widget_filename);
                        }
                    }
                    ?>
                </div><!-- /.center-content -->
                <div class="col-lg-4 sidebar">
                    <?php
                    foreach ($widgets_order->right as $widget_filename) {
                        _widget('property_'.$widget_filename);
                    }
                    ?>
                </div>
                <!-- /.right side bar -->
            </div>
        <?php _widget('property_center_otherlistings');?>        
        </div>
    </main><!-- /.main-part--> 
    <?/*php _widget('bottom_ads');*/?>
    <?php _widget('custom_footer');?>
</div>
<script type="text/javascript">
    $(document).ready(function() {

    <?php if(file_exists(APPPATH.'controllers/admin/favorites.php')):?>
        // [START] Add to favorites //  

        $("#add_to_favorites").click(function(){

            var data = { property_id: {estate_data_id} };

            var load_indicator = $(this).find('.load-indicator');
            load_indicator.css('display', 'inline-block');
            $.post("{api_private_url}/add_to_favorites/{lang_code}", data, 
                   function(data){

                ShowStatus.show(data.message);

                load_indicator.css('display', 'none');

                if(data.success)
                {
                    $("#add_to_favorites").css('display', 'none');
                    $("#remove_from_favorites").css('display', 'inline-block');
                }
            });

            return false;
        });

        $("#remove_from_favorites").click(function(){

            var data = { property_id: {estate_data_id} };

            var load_indicator = $(this).find('.load-indicator');
            load_indicator.css('display', 'inline-block');
            $.post("{api_private_url}/remove_from_favorites/{lang_code}", data, 
                   function(data){

                ShowStatus.show(data.message);

                load_indicator.css('display', 'none');

                if(data.success)
                {
                    $("#remove_from_favorites").css('display', 'none');
                    $("#add_to_favorites").css('display', 'inline-block');
                }
            });

            return false;
        });

        // [END] Add to favorites //  
    <?php endif; ?>
    });
</script>
<?/*php _widget('custom_palette');*/?>
<?php _widget('custom_javascript');?>
</body>
</html>