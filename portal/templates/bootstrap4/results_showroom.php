<?php foreach($showroom_module_all as $key=>$row):?> 
<div class="col-lg-12">
    <div class="card">
        <h3 class="title"><a href="<?php echo site_url('showroom/'.$row->id.'/'.$lang_code); ?>" class=""><?php echo $row->title; ?> </a><span class="title-notice"></span></h3>
        <div class="row">
            <div class="col-lg-5 ">
                <div class="news-thumbnail hover-default">
                        <?php if(file_exists(FCPATH.'files/thumbnail/'.$row->image_filename)):?>
                        <img src="<?php echo _simg('files/'.$row->image_filename, '285x165'); ?>" alt="<?php _che($row->title);?>" />
                        <?php else:?>
                            <img style="height:300px;width:185px" src="assets/img/no_image.jpg" alt="new-image">
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