<?php
/*
Widget-title: Image Gallery
Widget-preview-image: /assets/img/widgets_preview/center_imagegallery.jpg
*/
?>
<?php
/*  The Gallery as lightbox dialog, should be a child element of the document body 
*    use css/blueimp-gallery.min.css
*    use js/blueimp-gallery.min.js
*    use config assets/js/winter-flat.js
*   site https://github.com/blueimp/Gallery/blob/master/README.md#setup
*/
?>
<?php if(!empty($page_images)):?>
    <div class="widget widget-box box-container">
        <div class="widget-header text-uppercase">
          <?php echo _l('Image gallery');?>
        </div>
        <ul data-target="#modal-gallery" data-toggle="modal-gallery" class="images-gallery clearfix row">  
            <?php foreach ($page_images as $val):?>
            <li class="col-lg-4 col-md-6">
                <a data-gallery="gallery" href="<?php echo $val->url;?>" download="<?php echo $val->url;?>" title="<?php _che($val->filename);?>" class="preview show-icon">
                    <img src="assets/img/preview-icon.png" class="" alt="<?php echo $val->alt;?>"/>
                </a>
                <div class="preview-img"><img src="<?php echo _simg($val->thumbnail_url, '480x360');?>" data-src="<?php _che($val->url);?>" alt="<?php echo $val->alt;?>" class="" /></div>
            </li>
            <?php endforeach;?>
        </ul>
    </div><!-- /. widget-gallery -->   

    <script>
        $(document).ready(function(){
            if (!$('#blueimp-gallery').length)
            $('body').append('<div id="blueimp-gallery" class="blueimp-gallery">\n\
                                <div class="slides"></div>\n\
                                <h3 class="title"></h3>\n\
                                <a class="prev">&lsaquo;</a>\n\
                                <a class="next">&rsaquo;</a>\n\
                                <a class="close">&times;</a>\n\
                                <a class="play-pause"></a>\n\
                                <ol class="indicator"></ol>\n\
                                </div>')
        })
    </script>
<?php endif;?>