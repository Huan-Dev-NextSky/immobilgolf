<?php
/*
Widget-title: Slider
Widget-preview-image: /assets/img/widgets_preview/top_slider.jpg
*/
?>
<section class="header-slider">
    <h3 class="hidden-xs-up"><?php echo _l('Slider');?></h3>
    <!-- Carousel container -->
    <div id="header-slider" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
        <?php foreach($slideshow_images as $item): ?>
            <li data-target="#header-slider" data-slide-to="0" class="<?php _che($item['first_active']);?>"></li>
        <?php endforeach;?>
        </ol>

        <!-- Content -->
        <div class="carousel-inner" role="listbox">
            <!-- Slide 1 -->
            <?php foreach($slideshow_images as $key=>$file): ?>
                <div class="carousel-item <?php _che($file['first_active']);?>">
                    <img src="<?php echo _simg($file['url'], '2000x750'); ?>" alt="<?php _che($file['alt']);?>">
                    <?php if(config_item('property_slider_enabled')===TRUE&&!empty($file['property_details'])):?>
                        <div class="carousel-caption">
                            <h3 class="carousel-caption-title"><span><?php _che($file['property_details']['title']);?></span><i class="line-bottom color-primary"></i></h3>
                            <?php if(!empty($file['property_details']['option_chlimit_8'])):?>
                            <div class="s-description"><p><?php _che($file['property_details']['option_chlimit_8']);?></p></div>
                            <?php endif;?>
                            <a href="<?php _che($file['property_details']['link']);?>" class="btn btn-primary color-primary"><span><?php echo _l('Click to show');?></span></a>
                        </div>
                    <?php elseif(!empty($file['title'])): ?>
                        <div class="carousel-caption">
                            <h3 class="carousel-caption-title"><span><?php _che($file['title']);?></span><i class="line-bottom color-primary"></i></h3>
                            <?php if(!empty($file['description'])):?>
                            <div class="s-description"><p><?php _che($file['description']);?></p></div>
                            <?php endif; ?>
                            <?php if(!empty($file['link'])):?>
                                <a href="<?php _che($file['link']);?>" class="btn btn-primary color-primary"><span><?php echo _l('Click to show');?></span></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div> 
            <?php endforeach;?>
        </div>

        <!-- Previous/Next controls -->
        <a class="left carousel-control" href="#header-slider" role="button" data-slide="prev">
            <span class="icon-prev" aria-hidden="true"></span>
            <span class="sr-only"><?php echo _l('Previous');?></span>
        </a>
        <a class="right carousel-control" href="#header-slider" role="button" data-slide="next">
            <span class="icon-next" aria-hidden="true"></span>
            <span class="sr-only"><?php echo _l('Next');?></span>
        </a>
    </div>
    <!-- Carousel container -->
</section><!-- /.header-slider-->