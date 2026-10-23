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
                    <?php if(file_exists(APPPATH.'controllers/admin/showroom.php')):?>
                    <section class="widget-blog-listing widget-overflow"  id="showroom">
                        <div class="box-overflow-container box-container">
                            <div class="box-container-title">
                                <h2 class="title">{page_title}</h2> 
                                <span class="sub-title">{page_body}</span>
                            </div> <!-- /. content-header --> 
                            <div class="row blogs-listing property_content_position">
                                <?php foreach($showroom_module_all as $key=>$row):?> 
                                <div class="col-lg-12">
                                    <div class="card">
                                        <h3 class="title"><a href="<?php echo site_url('showroom/'.$row->id.'/'.$lang_code); ?>" class=""><?php echo $row->title; ?> </a><span class="title-notice"></span></h3>
                                        <div class="row">
                                            <div class="col-lg-5 ">
                                                <div class="news-thumbnail hover-default">
                                                        <?php if(file_exists(FCPATH.'files/thumbnail/'.$row->image_filename)):?>
                                                        <img src="<?php echo _simg('files/'.$row->image_filename, '315x185'); ?>" alt="<?php _che($row->title);?>"/>
                                                        <?php else:?>
                                                            <img src="assets/img/no_image.jpg" alt="new-image">
                                                        <?php endif;?>
                                                    <a href="<?php echo site_url('showroom/'.$row->id.'/'.$lang_code); ?>" class="property-card-hover">
                                                        <img src="assets/img/property-hover-arrow.png" alt="" class="left-icon">
                                                        <img src="assets/img/plus.png" alt="" class="center-icon">
                                                        <img src="assets/img/icon-notice.png" alt="" class="right-icon">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 description">
                                                 <?php echo $row->description; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;?>
                                <nav class="text-xs-right">
                                    <div class="pagination-delimiter">
                                        <?php echo $showroom_pagination; ?>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        
                    </section>
                    <?php _widget('center_imagegallery');?>
                    <?php endif;?>
                    
                </div><!-- /.center-content -->
                <div class="col-lg-3 sidebar sidebar-right-md">
                    <div class="widget widget-search">
                        <form>
                            <div class="input-group input-with-search color-primary clearfix">
                                <input type="text" id="search_showroom" value="" class="form-control" placeholder="<?php _l('Search');?>"/>
                                <button id="btn-search_showroom" type="submit" class="input-group-addon"><i class='fa fa-search fa-color-white'></i></button>
                            </div>
                        </form>
                    </div><!-- /.widget-search--> 
                    <div class="widget widget-box box-container widget-menu-right">
                        <div class="widget-header text-uppercase">
                            <?php _l('Categories');?>
                        </div>
                        <div id="menu-right">
                            <div class="list-group panel text-color-primary border-color-primary">
                                 <?php foreach($categories_showroom as $id=>$category_name):?>
                                    <?php if($id != 0): ?>
                                        <a href="{page_current_url}?cat=<?php echo $id; ?>#showroom" class="list-group-item list-group-item-success" data-parent="#menu-right"><?php echo $category_name; ?></a>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div><!-- /.widget-search--> 
                    
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
        $("#btn-search_showroom").click( function(e) { 
            e.preventDefault();
            if($('#search_showroom').val().length > 2 || $('#search_showroom').val().length == 0)
            {
                $.post('<?php echo $ajax_showroom_load_url; ?>', {search: $('#search_showroom').val()}, function(data){
                    $('.property_content_position').html(data.print);
                    
                    reloadElements();
                }, "json");
            }
        });

    });    
</script>
</body>
</html>