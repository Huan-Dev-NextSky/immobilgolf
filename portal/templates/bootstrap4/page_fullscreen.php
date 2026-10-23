<!DOCTYPE html>
<html lang="en">
<head>
    <?php _widget('head');?>
</head>

<body class="<?php _widget('custom_paletteclass');?>">
<div class="container container-wrapper">
    <header class="header header-hover">
        <div class="top-box" data-toggle="sticky-onscroll">
            <div class="container">
                <?php _widget('header_loginmenu');?>
                <?php _widget('header_mainmenu');?>
            </div> 
        </div>
        <div class="top-box-mask"></div>
    </header><!-- /.header--> 
    <?php _widget('top_sliderbig2');?>
    <?php _widget('top_searchvisual');?>
    <main class="main main-container section-color-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <?php _widget('center_recentproperties');?>
                </div><!-- /.center-content -->
                <div class="col-lg-3 sidebar">
                    <?php if(file_exists(APPPATH.'controllers/admin/savesearch.php')): ?>
                        <button id="search-save" type="button" class="btn btn-primary color-primary pull-right"><i class="icon-bookmark icon-white"></i>{lang_SaveResearch}</button>
                    <?php endif; ?>
                    <?php _widget('right_customfiltervisual');?>
                    <?php _widget('right_facebook');?>
                    <?php _widget('right_mortgage');?>
                </div>
                <!-- /.right side bar -->
            </div>
        </div>
    </main><!-- /.main-part--> 
    <?php _widget('bottom_ads');?>
    <?php _widget('bottom_recentnews');?>
    <?php _widget('bottom_defaultcontent');?>
    <?php _widget('bottom_agenciescarousel');?>
    <?php _widget('bottom_agentscarousel');?>
  
    <!-- footer -->
    <?php _widget('custom_footer');?>
    <!-- /.footer --> 
</div>
<?php _widget('custom_palette');?>
<?php _widget('custom_javascript');?>
</body>
</html>