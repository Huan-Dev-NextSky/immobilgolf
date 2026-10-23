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
                    <section class="widget widget-blog-listing widget-overflow" id="news">
                        <div class="box-overflow-container box-container">
                            <div class="box-container-title">
                                <h2 class="title">{page_title}</h2> 
                                <span class="sub-title">{page_body}</span>
                            </div> <!-- /. content-header --> 
                        </div>
                    </section>
                    <?php if(file_exists(APPPATH.'controllers/admin/news.php')):?>
                    <div class="blogs-listing property_content_position">
                        <div class="properties">
                            <div class="row">
                                <?php foreach($news_module_all as $key=>$row):?> 
                                <div class="col-md-6">
                                    <div class="property-card news-card card">
                                        <div class="property-card-header image-box">
                                            <?php if(file_exists(FCPATH.'files/thumbnail/'.$row->image_filename)):?>
                                            <img src="<?php echo _simg('files/'.$row->image_filename, '570x330'); ?>" alt="<?php _che($row->title);?>" />
                                            <?php else:?>
                                                <img src="assets/img/no_image.jpg" alt="new-image">
                                            <?php endif;?>
                                            <a href="<?php echo slug_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>" class="property-card-hover">
                                                <img src="assets/img/property-hover-arrow.png" alt="" class="left-icon">
                                                <img src="assets/img/plus.png" alt="" class="center-icon">
                                                <img src="assets/img/icon-notice.png" alt="" class="right-icon">
                                            </a>
                                        </div>
                                        <div class="property-card-tasm">
                                            <div class="pull-left item-t">
                                                <span class="date">
                                                    <i class="fa fa-calendar"></i>
                                                      <?php
                                                        $timestamp = strtotime($row->date_publish);
                                                        $m = strtolower(date("F", $timestamp));
                                                        echo lang_check('cal_' . $m) . ' ' . date("j, Y", $timestamp);
                                                        ?>
                                                </span>
                                            </div>
                                            <div class="item-tag pull-right text-color-primary">
                                                <?php foreach (explode(',', $row->keywords) as $val): ?>
                                                    <span class=""><?php echo trim($val); ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="property-card-box card-box card-block">
                                            <h3 class="property-card-title"><a href="<?php echo slug_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>"><?php echo $row->title; ?></a></h3>
                                            <div class="property-card-descr"> <?php echo $row->description; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;?>
                                <nav class="text-xs-right">
                                    <div class="pagination-delimiter pagination news">
                                        <?php echo $news_pagination; ?>
                                    </div>
                                </nav>
                            </div>
                        </div>        
                    </div>
                    <?php endif;?>
                    <?php _widget('center_imagegallery');?>
                </div><!-- /.center-content -->
                <div class="col-lg-3 sidebar">
                    <?php if(file_exists(APPPATH.'controllers/admin/news.php')):?>
                    <?php if(true):?>
                    <div class="widget widget-search">
                        <form action="{page_current_url}#news">
                            <div class="input-group input-with-search color-primary clearfix">
                                <input type="text" id="search_news" value="" class="form-control" placeholder="<?php _l('Search');?>"/>
                                <button id="btn-search_news" type="submit" class="input-group-addon"><i class='fa fa-search fa-color-white'></i></button>
                            </div>
                        </form>
                    </div><!-- /.widget-search--> 
                    <?php endif;?>
                    <div class="widget widget-box box-container widget-menu-right">
                        <div class="widget-header text-uppercase">
                            <?php _l('Categories');?>
                        </div>
                        <div id="menu-right">
                            <div class="list-group panel text-color-primary border-color-primary">
                                 <?php foreach($categories as $id=>$category_name):?>
                                    <?php if($id != 0): ?>
                                        <a href="{page_current_url}?cat=<?php echo $id; ?>#news" class="list-group-item list-group-item-success" data-parent="#menu-right"><?php echo $category_name; ?></a>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div><!-- /.widget-search--> 
                    <?php endif;?>
                    <?php _widget('right_ads');?>
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
    $(document).ready(function(){
        $("#btn-search_news").click( function(e) {
            e.preventDefault();
            if($('#search_news').val().length > 2 || $('#search_news').val().length == 0)
            {
                $.post('<?php echo $ajax_news_load_url; ?>', {search: $('#search_news').val()}, function(data){
                    $('.property_content_position').html(data.print);
                    
                    reloadElements();
                }, "json");
            }
        });

    });    
</script>
</body>
</html>