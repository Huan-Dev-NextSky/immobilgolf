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
                  <div class="col-lg-12">
                    
                    <section class="widget widget-agents-listing widget-overflow">
                    
                        <div class="box-overflow-container box-container">
                            <div class="box-container-title">
                                    <h2 class="title">{page_title}</h2> 
                            </div> <!-- /. content-header --> 
                            <div class="widget-content">
                                {page_body}
                                {has_page_documents}
                                <h2>{lang_Filerepository}</h2>
                                <ul>
                                {page_documents}
                                <li>
                                    <a href="{url}">{filename}</a>
                                </li>
                                {/page_documents}
                                </ul>
                                {/has_page_documents}
                            </div>
                        </div>
                    </section>
                      <?php _widget('center_imagegallery');?>
                </div><!-- /.center-content -->
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