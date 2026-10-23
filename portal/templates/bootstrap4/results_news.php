            <?php foreach($news_module_all as $key=>$row):?> 
            <div class="col-md-6">
                <div class="property-card news-card card">
                    <div class="property-card-header image-box">
                        <?php if(file_exists(FCPATH.'files/thumbnail/'.$row->image_filename)):?>
                        <img src="<?php echo _simg('files/'.$row->image_filename, '570x330'); ?>" alt="<?php _che($row->title);?>" />
                        <?php else:?>
                            <img src="assets/img/no_image.jpg" alt="new-image">
                        <?php endif;?>
                        <a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>" class="property-card-hover">
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
                        <h3 class="property-card-title"><a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>"><?php echo $row->title; ?></a></h3>
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