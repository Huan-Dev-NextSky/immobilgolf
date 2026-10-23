<div class="widget widget-box box-container widget-property">
    <?php if(sw_count($slideshow_property_images)>0):?>
        <?php if(sw_count($slideshow_property_images) == 1):?>
            <div class="property-slider-box">
                <div id="property-slider" class="property-slider carousel slide" data-ride="carousel">
                    <!-- Content -->
                    <div class="carousel-inner" role="listbox">
                        <?php foreach($slideshow_property_images as $file): ?>
                        <!-- Slide 1 -->
					    <div class="carousel-item <?php echo  $file['first_active'];?>" data-link="<?php _che($file['url']);?>">
                            <img src="<?php echo _simg($file['url'], '800x450', true);?>" alt="<?php echo _ch($file['alt'], '');?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php else:?>
            <div class="property-slider-box">
                <div id="property-slider" class="property-slider carousel slide" data-ride="carousel">
                    <!-- Content -->
                    <div class="carousel-inner" role="listbox">
                        <?php foreach($slideshow_property_images as $file): ?>
                        <!-- Slide 1 -->
                         <div class="carousel-item <?php echo  $file['first_active'];?>" data-link="<?php _che($file['url']);?>">
                            <img src="<?php echo _simg($file['url'], '800x450', true);?>" alt="<?php echo _ch($file['alt'], '');?>">
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Previous/Next controls -->
                    <a class="left carousel-control" href="#property-slider" role="button" data-slide="prev">
                        <span class="icon-prev" aria-hidden="true"></span>
                        <span class="sr-only"><?php echo _l('Previous');?></span>
                    </a>
                    <a class="right carousel-control" href="#property-slider" role="button" data-slide="next">
                        <span class="icon-next" aria-hidden="true"></span>
                        <span class="sr-only"><?php echo _l('Next');?></span>
                    </a>
                </div>
                <?/*php<div class="property-slider-thumbnail">
                    <ul data-target="#modal-gallery" data-toggle="modal-gallery" class="images-gallery row">  
                    <?php foreach ($page_images as $key => $val): ?>
                        <li class="col-md-2 col-4" data-index='<?php echo $key;?>'>
                            <div class="preview-img img-cover-box"><img src="<?php echo _simg($val->thumbnail_url, '240x140');?>" data-src="<?php _che($val->url);?>" alt="<?php echo $val->alt;?>" class="" /></div>
                        </li>
                    <?php endforeach;?>
                    </ul>
                </div>*/?>
            </div>
        <?php endif;?>
    
    <?php endif;?>
    <div class="widget-box">
        <div class="clearfix" style="margin-bottom: 40px;">
        <?php if(file_exists(APPPATH.'controllers/admin/favorites.php')):?>
            <?php
                $favorite_added = false;
                if(sw_count($not_logged) == 0)
                {
                    $CI =& get_instance();
                    $CI->load->model('favorites_m');
                    $favorite_added = $CI->favorites_m->check_if_exists($this->session->userdata('id'), 
                                                                        $estate_data_id);
                    if($favorite_added>0)$favorite_added = true;
                }
            ?>
            <div class="pull-left favorite clearfix" >
                <a class="btn btn-warning" id="add_to_favorites" href="#" style="<?php echo ($favorite_added)?'display:none;':''; ?>"><i class="fa fa-star fa-color-white"></i> <?php echo lang_check('Add to favorites'); ?> <i class="load-indicator"></i></a>
                <a class="btn btn-success" id="remove_from_favorites" href="#" style="<?php echo (!$favorite_added)?'display:none;':''; ?>"><i class="fa fa-star fa-color-white"></i> <?php echo lang_check('Remove from favorites'); ?> <i class="load-indicator"></i></a>
            </div>
            <?php endif; ?>
            <?php _widget('custom_property_center_reports');?>
        </div>
        <div class="widget-header widget-title text-uppercase"><span class="marker-proprieta"><img src="assets/img/immobilgolf/marker_immobilgolf.png" width="25px" alt="immobilgolf"></span>

            {lang_Description}
        </div>
        <div class="widget-content">
            <p>
            <?php _che($estate_data_option_17, '<p class="alert alert-success">'.lang_check('Not available').'</p>'); ?>
           </p>
        </div>
    </div> 
</div> <!-- /. widget-body --> 

<script>
    
$(document).ready(function(){
        
    $(document).on('click', '#property-slider .carousel-inner .carousel-item', function () {
        var myLinks = new Array();
        var current_link = $(this).attr('data-link');
        var curIndex=0;
        $('#property-slider .carousel-inner .carousel-item').each(function (i) {
            var img_link = $(this).attr('data-link');
            myLinks[i] = img_link;
            if(current_link == img_link)
                curIndex = i;
        });
        options = {index: curIndex};
        blueimp.Gallery(myLinks,options);
        
        return false;
    });   
    
    if (!$('#blueimp-gallery').length)
    $('body').append('<div id="blueimp-gallery" class="blueimp-gallery">\n\
                     <div class="slides"></div>\n\
                     <h3 class="title"></h3>\n\
                     <a class="prev">&lsaquo;</a>\n\
                     <a class="next">&rsaquo;</a>\n\
                     <a class="close">&times;</a>\n\
                     <a class="play-pause"></a>\n\
                     <ol class="indicator"></ol>\n\
                     </div>');
})
    
</script>                 
                    