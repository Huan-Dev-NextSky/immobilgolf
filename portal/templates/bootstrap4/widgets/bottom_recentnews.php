<?php
/*
Widget-title: Recent News
Widget-preview-image: /assets/img/widgets_preview/bottom_recentnews.jpg
*/
?>
<?php if(isset($news_module_latest_5) && !empty($news_module_latest_5)):?>
<section class="section news section-color-third">
    <div class="container">
        <div class="section-title">
            <h2 class="section-title text-center"><span class="">{lang_Latestnews}</span></h2>
        </div>
        <div class="news-slide">
            <div id="news-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <?php foreach($news_module_latest_5 as $key=>$row):?> 
                        <?php
                            if($key==0)echo '<div class="carousel-item active"><div class="row">';
                        ?>
                        <div class="col-lg-6 news-item">
                            <div class="card">
                                <h3 class="title"><a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>"><?php echo $row->title; ?></a></h3>
                                <div class="row">
                                    <div class="col-lg-5 ">
                                        <div class="news-thumbnail hover-default">
                                            <img src="<?php echo _simg('files/'.$row->image_filename, '630x360'); ?>" alt="">
                                            <a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>" class="property-card-hover">
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
                        <?php
                            if( ($key+1)%4==0 )
                            {
                                echo '</div></div><div class="carousel-item"><div class="row">';
                            }
                            if( ($key+1)==sw_count($news_module_latest_5) ) echo '</div></div>';
                            endforeach;
                        ?>
                </div>
                <?php if(sw_count($news_module_latest_5)>4) :?>
                <ul class="carousel-indicators pagination-carousel">
                    <?php $_key = 0; foreach($news_module_latest_5 as $key=>$row):?> 
                        <?php if( ($key+1)%4==0 || $key==0 ): $_key++ ?>
                            <li  data-target="#news-carousel" data-slide-to="<?php echo $_key;?>" class="<?php echo ($key==0)?'active':'';?>" ><a class="" href="#"> <?php echo $_key;?> </a></li>
                        <?php endif;?>
                    <?php endforeach;?>
                </ul>
                <?php endif;?>
            </div>
        </div><!-- /.news-slider--> 
    </div>
</section><!-- /.news --> 
 <?php endif;?>