<?php
/*
Widget-title: Recent News
Widget-preview-image: /assets/img/widgets_preview/footer_recentnews.jpg
*/
?>
<?php if (!empty($news_module_latest_5)) :?>
    <div class="col-lg-3 col-md-6 hidden-md-down">
        <div class="title">{lang_Latestnews}</div>
        <ul class="list list-news">
            <?php foreach($news_module_latest_5 as $key=>$row):?> 
            <?php
            $timestamp = strtotime($row->date_publish);
            $m = strtolower(date("F", $timestamp));
            ?>
            <li>
                <a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>"  class="title"><?php echo $row->title; ?></a>
                <span class="description"> <?php echo lang_check('cal_' . $m) . ' ' . date("j, Y", $timestamp); ?> </span>
            </li> 
            <?php endforeach; ?>
        </ul>
    </div>
<?php else: ?>
    <?php

    $CI =& get_instance();

    if(file_exists(APPPATH.'controllers/admin/news.php'))
    {
        $news_module_latest_5 = $CI->page_m->get_lang(NULL, FALSE, $lang_id, 
                                                          array('type'=>'MODULE_NEWS_POST'), 
                                                          5, 0, 'date_publish DESC');
    }
    else
    {
        $news_module_latest_5 = $CI->page_m->get_lang(NULL, FALSE, $lang_id, 
                                                          array('type'=>'ARTICLE'), 
                                                          5, 0, 'date DESC');
    }

    ?>
    <div class="col-lg-3 col-md-6 hidden-md-down">
        <div class="title">{lang_Latestnews}</div>
        <ul class="list list-news">
            <?php foreach($news_module_latest_5 as $key=>$row):?> 
            <?php
            $timestamp = strtotime($row->date_publish);
            $m = strtolower(date("F", $timestamp));
            ?>
            <li>
                <a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>"  class="title"><?php echo $row->title; ?></a>
                <span class="description"> <?php echo lang_check('cal_' . $m) . ' ' . date("j, Y", $timestamp); ?> </span>
            </li> 
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif;?>