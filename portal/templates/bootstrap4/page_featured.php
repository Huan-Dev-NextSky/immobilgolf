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
        <div class="top-box-mask"></div>
    </header><!-- /.header--> 
    <?php _widget('top_titlebreadcrumb2');?>
    <main class="main main-container section-color-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="clearfix">
                        <h2 class="section-title text-center"><span class="">{page_title}</span></h2>
                    </div> <!-- /. content-header --> 
                    <?php _widget('center_featuredproperties');?>  
                </div><!-- /.center-content -->
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
</body>
</html>