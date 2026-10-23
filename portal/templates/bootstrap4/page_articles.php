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
                    <section class="widget-blog-listing widget-overflow">
                        <div class="box-overflow-container box-container">
                            <div class="box-container-title">
                                <h2 class="title">{page_title}</h2> 
                                <span class="sub-title">{page_body}</span>
                            </div> <!-- /. content-header --> 
                            <div class="row blogs-listing">
                                <?php foreach($news_articles as $key=>$row):?> 
                                <div class="col-lg-12">
                                    <div class="card">
                                        <h3 class="title"><a href="#" class=""><?php echo $row->title; ?> </a></h3>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="news-thumbnail hover-default">
                                                        <?php if(file_exists(FCPATH.'files/thumbnail/'.$row->image_filename)):?>
                                                        <img src="<?php echo _simg('files/'.$row->image_filename, '385x220'); ?>" alt="<?php _che($row->title);?>" />
                                                        <?php else:?>
                                                            <img src="assets/img/no_image.jpg" alt="new-image">
                                                        <?php endif;?>
                                                    <a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>" class="property-card-hover">
                                                        <img src="assets/img/property-hover-arrow.png" alt="" class="left-icon">
                                                        <img src="assets/img/plus.png" alt="" class="center-icon">
                                                        <img src="assets/img/icon-notice.png" alt="" class="right-icon">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 description">
                                                 <?php echo $row->description; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </section>
                    <?php _widget('center_imagegallery');?>
                    
                    <?php _widget('center_ads');?>
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