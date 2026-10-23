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
    
    <?php _widget('top_slider');?>
    <?php _widget('top_searchvisual');?>
    
    <main class="main main-container section-color-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="results-properties-list" id="results_conteiner">
                        <?php _widget('center_defaultcontent');?>
                        <?php _widget('center_imagegallery');?>
                    </div>
                </div><!-- /.center-content -->
                <div class="col-lg-3 sidebar">
                    <?php _widget('right_facebook');?>
                    <?php _widget('right_customfilter');?>
                </div>
                <!-- /.right side bar -->
            </div>
        </div>
    </main><!-- /.main-part--> 
    <?php _widget('bottom_ads');?>
    <?php _widget('bottom_agentscarousel');?>
    <!-- footer -->
    <?php _widget('custom_footer');?>
    <!-- /.footer --> 
</div>
<?php _widget('custom_palette');?>
<?php _widget('custom_javascript');?>
</body>
</html>