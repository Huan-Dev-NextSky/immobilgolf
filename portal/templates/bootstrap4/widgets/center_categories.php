<?php
/*
Widget-title: Categories
Widget-preview-image: /assets/img/widgets_preview/center_categories.jpg
*/
?>
<?php
$CI = & get_instance();
$treefield_id = 79;

$CI->load->model('treefield_m');

$treefields = array();

$check_option= $CI->option_m->get_by(array('id'=>$treefield_id));
// check if option exists
if(!$check_option)
    return false;

if($check_option[0]->type!='TREE')
    return false;

$tree_listings = $CI->treefield_m->get_table_tree($lang_id, $treefield_id, NULL, FALSE, '.order', ',image_filename');

if(empty($tree_listings) || !isset($tree_listings[0]))
    return false;

// count listing
/*SELECT `property`.id, 
`property`.`is_activated`,
`property_value`.`property_id`,
`property_value`.`value`, 
COUNT(value)
FROM `property`
LEFT JOIN `property_value` ON `property`.id = `property_value`.`property_id`
 WHERE `option_id`= 64 and `language_id`=1 and `is_activated`=1 GROUP BY `value`
*/
$this->db->select('property_value.value, COUNT(value) as count');

$this->db->join('property_value', 'property.id = property_value.property_id');

$this->db->group_by('property_value.value');  
$this->db->where('option_id', $treefield_id);
$this->db->where('language_id', $lang_id);
$this->db->where('is_activated', 1);
$this->db->where('is_visible', 1);

if(config_db_item('listing_expiry_days') !== FALSE)
{
    if(is_numeric(config_db_item('listing_expiry_days')) && config_db_item('listing_expiry_days') > 0)
    {
        $this->db->where('date_modified >', date("Y-m-d H:i:s" , time() - config_db_item('listing_expiry_days')*86400));
    }
}

$query= $this->db->get('property');

$result_count = array();

if($query){
    $result = $query->result();
    foreach ($result as $key => $value) {
        if(!empty($value->value))
            $result_count[$value->value]= $value->count;
    }
}

$_treefields = $tree_listings[0];

$treefields = array();
foreach ($_treefields as $val) {

    $options = $tree_listings[0][$val->id];
    $treefield = array();
    $field_name = 'value' ;
    $treefield['title'] = $options->$field_name;
    $treefield['title_chlimit'] = character_limiter($options->$field_name, 15);

    $field_name = 'body';
    $treefield['descriotion'] = $options->$field_name;
    $treefield['description_chlimit'] = character_limiter($options->$field_name, 50);
    
    $treefield['count'] = 0;
    if(isset($result_count[$treefield['title'].' -']))
        $treefield['count'] = $result_count[$treefield['title'].' -'];
    
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
    
    $childs_count = 0;
    $childs = array();
    if (isset($tree_listings[$val->id]) && sw_count($tree_listings[$val->id]) > 0)
        foreach ($tree_listings[$val->id] as $key => $_child) {
            $child = array();
            $options = $tree_listings[$_child->parent_id][$_child->id];
            $field_name = 'value';
            $child['title'] = $options->$field_name;
            $child['title_chlimit'] = character_limiter($options->$field_name, 10);

            $field_name = 'body';
            $child['descriotion'] = $options->$field_name;
            $child['descriotion_chlimit'] = character_limiter($options->$field_name, 50);
            
            $child['count']= 0;
            if(isset($result_count[$treefield['title'].' - '.$child['title'].' -']))
                $child['count'] = $result_count[$treefield['title'].' - '.$child['title'].' -'];
            
            $child['url'] = '';
            
            /* link if have body */
                if(!empty($options->$field_name))
                {
                    // If slug then define slug link
                    $href = slug_url('treefield/'.$lang_code.'/'.$options->id.'/'.url_title_cro($options->value), 'treefield_m');
                    $child['url'] = $href;
                }
            /* end if have body */
            $childs_count+=$child['count'];
            $childs[] = $child;
        }
        
    $treefield['count'] += $childs_count;
    $treefield['childs'] = $childs;
    $treefield['childs_more'] = array_slice($childs, 4);
    $treefield['childs_8'] = array_slice($childs, 0, 4);
    $treefields[] = $treefield;
}


?>
<?php if(search_value($treefield_id)) : ?>
    <?php _widget('center_recentproperties');?>  
<?php else: ?>
    <div class="results-properties-list" id="results_conteiner">
    <div class="h-side clearfix ">
        <div class="float-sm-left">
            <h2 class="h-side-title page-title text-color-primary"><?php echo _l('Results');?></h2>
        </div>
    </div> <!-- /. content-header -->    

    <div class="properties">
        <!-- PROPERTY LISTING -->

        <?php foreach($treefields as $key=>$item): ?>
        <?php
            if($key==0)echo '<div class="row">';
        ?>
        <div class="col-lg-4">
            <div class="property-card card  treefield-card">
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
                <div class="property-card-box card-box card-block">
                    <h3 class="property-card-title"><i class="fa fa-car color-primary"></i>
                        <?php if(!empty($item['url'])) : ?>
                            <a href="<?php _che($item['url']);?>"><?php _che($item['title_chlimit']); ?></a>
                        <?php else: ?> 
                             <?php _che($item['title_chlimit']); ?>   
                        <?php endif;?>
                    </h3>
                    <ul class="treefield-categories">
                        <?php if (sw_count($item['childs_8']) > 0) foreach ($item['childs_8'] as $child): ?>
                        <li>
                            <?php if(!empty($child['url'])): ?>
                                <a class="treefield-box-item btn-default" href="<?php _che($child['url']); ?>"><?php _che($child['title']); ?></a>
                            <?php else:?>
                                <a href='<?php echo site_url_nosuff($lang_code.'/'.$this->data['page_id'].'/?search={"v_search_option_'.$treefield_id.'":"'.rawurlencode($item['title_chlimit'].' - '.$child['title'].' - ').'"}'); ?>' class="treefield-box-item btn-default"><?php _che($child['title']); ?></a>
                            <?php endif;?>
                            <span class="count text-color-primary"><?php _che($child['count']);?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
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

<?php endif;?>