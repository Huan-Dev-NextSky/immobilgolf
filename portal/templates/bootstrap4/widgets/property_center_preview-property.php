<div class="widget widget-box box-container widget-overview">
    <div class="widget-header text-uppercase">
        {page_title}
    </div>
    <?php if(sw_count($slideshow_property_images)>0):?>
        <div class="property-slider-box">
            <div class="property-slider-thumbnail property-slider-preview">
                <ul data-target="#modal-gallery" data-toggle="modal-gallery" class="images-gallery row">  
                <?php foreach ($page_images as $key => $val): ?>
                    <li class="col-4" data-index='<?php echo $key;?>'>
                        <div class="preview-img img-cover-box"><img src="<?php echo _simg($val->thumbnail_url, '260x160');?>" data-src="<?php _che($val->url);?>" alt="<?php echo $val->alt;?>" class="" /></div>
                    </li>
                <?php if($key>1)break; endforeach;?>
                </ul>
            </div>
        </div>
    <?php endif;?>
</div> <!-- /. widget-body --> 

                    