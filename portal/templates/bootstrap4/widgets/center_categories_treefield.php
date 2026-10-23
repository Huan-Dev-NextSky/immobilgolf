<?php
/*
Widget-title: Treefield
Widget-preview-image: /assets/img/widgets_preview/center_categories_treefield.jpg
*/
?>
<?php
$CI = & get_instance();
$treefield_id = 64;

$CI->load->model('treefield_m');

$treefields = array();

$tree_listings = $CI->treefield_m->get_table_tree($lang_id, $treefield_id, NULL, FALSE, '.order', ',image_filename');
$_treefields = $tree_listings[0];

$treefields = array();
foreach ($_treefields as $val) {

    $options = $tree_listings[0][$val->id];
    $treefield = array();
    $field_name = 'value' ;
    $treefield['title'] = $options->$field_name;
    $treefield['title_chlimit'] = character_limiter($options->$field_name, 15);

    $field_name = 'body';
    $treefield['description'] = $options->$field_name;
    $treefield['description_chlimit'] = character_limiter($options->$field_name, 50);
    
    $treefield['url'] = '';
    
    /* link if have body */
    if(!empty($options->$field_name))
    {
        $href = slug_url('treefield/'.$lang_code.'/'.$options->id.'/'.url_title_cro($options->value), 'treefield_m');
        $treefield['url'] = $href;
    }
    /* end if have body */
    
    // Thumbnail and big image
    if(!empty($options->image_filename) and file_exists(FCPATH.'files/thumbnail/'.$options->image_filename))
    {
        $treefield['thumbnail_url'] = base_url('files/thumbnail/'.$options->image_filename);
        $treefield['image_url'] = base_url('files/'.$options->image_filename);
    }
    else
    {
        $treefield['thumbnail_url'] = 'assets/img/no_image.jpg';
        $treefield['image_url'] = 'assets/img/no_image.jpg';
    }
    
    $childs = array();
    if (isset($tree_listings[$val->id]) && sw_count($tree_listings[$val->id]) > 0)
        foreach ($tree_listings[$val->id] as $key => $_child) {
            $child = array();
            $options = $tree_listings[$_child->parent_id][$_child->id];
            $field_name = 'value';
            $child['title'] = $options->$field_name;
            $child['title_chlimit'] = character_limiter($options->$field_name, 10);

            $field_name = 'body';
            $child['description'] = $options->$field_name;
            $child['description_chlimit'] = character_limiter($options->$field_name, 50);
            
            $child['url'] = '';
            $href = slug_url($lang_code.'/6/'.url_title_cro('map', '-', TRUE), 'page_m');
            
            $child['url'] = '';
            
            /* link if have body */
                if(!empty($options->$field_name))
                {
                    // If slug then define slug link
                    $href = slug_url('treefield/'.$lang_code.'/'.$options->id.'/'.url_title_cro($options->value), 'treefield_m');
                    $child['url'] = $href;
                }
            /* end if have body */
            
            $childs[] = $child;
        }

    $treefield['childs'] = $childs;
    $treefield['childs_4'] = array_slice($childs, 0, 4);
    $treefields[] = $treefield;
}
?>

<div class="results-properties-list" id="results_conteiner">
<div class="h-side clearfix ">
    <div class="float-sm-left">
        <h2 class="h-side-title page-title text-color-primary"><?php echo _l('Results');?></h2>
    </div>
</div> <!-- /. content-header -->    
    
<div class="properties treefield-categories-1">
    <!-- PROPERTY LISTING -->
    
    <?php foreach($treefields as $key=>$item): ?>
    <?php
        if($key==0)echo '<div class="row">';
    ?>
    <div class="col-lg-4">
        <div class="property-card card  treefield-card ">
            <div class="property-card-header image-box">
                <img src="<?php echo _simg($item['thumbnail_url'], '255x165'); ?>" alt="">
                <?php if(!empty($item['url'])) : ?>
                    <a href="<?php echo $item['url']; ?>" class="property-card-hover">
                        <img src="assets/img/property-hover-arrow.png" alt="" class="left-icon">
                        <img src="assets/img/plus.png" alt="" class="center-icon">
                        <img src="assets/img/icon-notice.png" alt="" class="right-icon">
                    </a>
                <?php endif;?>
            </div>

            <div class="property-card-tags">
                <span class="label label-default label-tag-warning">rent</span>
            </div>
            <div class="property-card-box card-box card-block">
                <h3 class="property-card-title">
                    <?php if(!empty($item['url'])) : ?>
                        <a href="<?php _che($item['url']);?>"><?php _che($item['title_chlimit']); ?></a>
                    <?php else: ?> 
                         <?php _che($item['title_chlimit']); ?>   
                    <?php endif;?>
                </h3>
                
                <div class="property-card-descr"><?php _che($item['description_chlimit']); ?></div>

                <div class="treefield-categories clearfix">
                    <?php if (sw_count($item['childs_4']) > 0) foreach ($item['childs_4'] as $child): ?>
                        <?php if(!empty($child['url'])): ?>
                            <a class="treefield-box-item btn-default" href="<?php _che($child['url']); ?>"><?php _che($child['title']); ?></a>
                        <?php else:?>
                            <span class="treefield-box-item btn-default"><?php _che($child['title']); ?></span>
                        <?php endif;?>
                    <?php endforeach; ?>
                </div>
                <?php if (sw_count($item['childs']) > 0):?>
                    <span id="more_category" class="btn btn-primary btn-wide color-primary">
                        <?php echo _l('More');?>
                    </span>
                    <div class="treefield-categories treefield-categories-more clearfix">
                              <?php  end($item['childs']);
                              $lastElementKey = key($item['childs']);

                              foreach ($item['childs'] as $key_c=>$child): ?>
                            <?php if(!empty($child['url'])): ?>
                               <a href='<?php _che($child['url']); ?>'><?php _che($child['title']); ?></a>
                            <?php else:?>
                               <span><?php _che($child['title']); ?></span>
                            <?php endif;
                            if($lastElementKey != $key_c)echo ' - ';
                            ?>

                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
       if( ($key+1)%3==0 )
        {
            echo '</div><div class="row">';
        }
        if( ($key+1)==sw_count($treefields) ) echo '</div>';
    endforeach;
    ?>
</div> <!-- /.properties-->
</div>

<script>
    $('document').ready(function(){
        $('.property-card  #more_category').on('click', function(){
            $(this).closest('.property-card ').find('.treefield-categories-more').slideToggle('fast');
            $('.property-card').not($(this).closest('.property-card')).find('.treefield-categories-more').slideUp('fast')
        })
    })
</script>