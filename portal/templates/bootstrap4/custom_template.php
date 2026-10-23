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
                <?php
                    foreach ($widgets_order->header as $widget_filename) {
                        _widget($widget_filename);
                    }
                ?>
            </div> 
        </div>
    </header><!-- /.header--> 
    <?php
    foreach ($widgets_order->top as $widget_filename) {
        _widget($widget_filename);
    }
    ?>
    <main class="main section-color-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <?php
                    foreach ($widgets_order->center as $widget_filename) {
                        _widget($widget_filename);
                    }
                    ?>
                </div><!-- /.center-content -->
                <div class="col-lg-3 sidebar <?php if(!file_exists(APPPATH.'controllers/admin/savesearch.php')): ?>sidebar-right<?php endif;?> sidebar-right-md">
                    <?php if(file_exists(APPPATH.'controllers/admin/savesearch.php')): ?>
                    <div class="clearfix h-side">
                        <button id="search-save" type="button" class="btn btn-primary color-primary pull-right"><i class="icon-bookmark icon-white"></i>{lang_SaveResearch}</button>
                    </div>
                    <?php endif; ?>
                    <?php
                    foreach ($widgets_order->right as $widget_filename) {
                        _widget($widget_filename);
                    }
                    ?>
                </div>
                <!-- /.right side bar -->
            </div>
        </div>
    </main><!-- /.main-part--> 
    <?php
    foreach ($widgets_order->bottom as $widget_filename) {
        _widget($widget_filename);
    }
    ?>
  
    <!-- footer -->
    <footer class="footer">
        <div class="container footer-mask">
            <div class="container footer-contant">
                <div class="row">
                    <?php
                    foreach ($widgets_order->footer as $widget_filename) {
                        _widget($widget_filename);
                    }
                    ?>
                </div>
            </div><!-- /.footer-content --> 
            <div class="footer-bottom">
                <div class="container text-md-right text-center">
                    <span class=""><a href="http://iwinter.com.hr" target="_blank">WINTER @<?php echo date('Y');?></a></span>
                </div>
            </div><!-- /.footer-bottom --> 
        </div>
    </footer>
    <!-- /.footer --> 
</div>
<?php _widget('custom_palette');?>
<?php _widget('custom_javascript');?>
</body>
</html>