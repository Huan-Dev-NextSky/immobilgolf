<?php
/*
Widget-title: Featured properties carousel
Widget-preview-image: /assets/img/widgets_preview/bottom_featuredproperties-carousel.jpg
*/
?>
<?php if(!empty($featured_properties)):?>
<section class="section agents section-color-primary">
        <div class="container">
            <div class="section-title">
                <h2 class="section-title text-center"><span class=""><?php echo _l('Featured');?></span></h2>
            </div>
            <div class="row-fluid clearfix">
                <div class="col-lg-12 offset-md-0  owl-corousel-box agents-corousel" id='property-corousel'>
                    <div class="owl-carousel">
                    <?php if(!empty($featured_properties))foreach($featured_properties as $key=>$item): ?>
                        <div class="item shop-corousel-item">
                            <div class="property-card card">
                                <div class="property-card-header image-box">
                                    <img src="<?php echo _simg($item['thumbnail_url'], '255x165'); ?>" alt="" class="">
                                    <?php if(($item['is_featured'])):?>
                                        <div class="budget"><i class="fa fa-star"></i></div>
                                    <?php endif;?>
                                    <a href="<?php echo $item['url']; ?>" class="property-card-hover">
                                        <img src="assets/img/property-hover-arrow.png" alt="" class="left-icon">
                                        <img src="assets/img/plus.png" alt="" class="center-icon">
                                        <img src="assets/img/icon-notice.png" alt="" class="right-icon">
                                    </a>
                                </div>

                                <div class="property-card-tags">
                                    <span class="label label-default label-tag-warning"><?php _che($item['option_4']); ?></span>
                                </div>
                                <div class="property-card-box card-box card-block">
                                    <h3 class="property-card-title"><a href="<?php echo $item['url']; ?>"><?php _che($item['option_10']); ?></a></h3>
                                    <div class="property-card-descr"><?php _che($item['option_chlimit_8']); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                    <a href="#" class="owl-btn customPrevBtn"></a>
                    <a href="#" class="owl-btn customNextBtn"></a>
                </div>     
            </div>
        </div>
    </section><!-- /.agencies -->
<?php endif;?>