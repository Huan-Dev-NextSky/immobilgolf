<?php
/*
Widget-title: featured Properties
Widget-preview-image: /assets/img/widgets_preview/center_featuredproperties.jpg
*/
?>
<div class="properties">
    <div class="row">
        <!-- PROPERTY LISTING -->
        <?php foreach($featured_properties as $key=>$item): ?>
        <?php
            //if($key==0)echo '<div class="row">';
        ?>
            <?php _generate_results_item(array('key'=>$key, 'item'=>$item,'custom_class'=>'col-xl-4 col-lg-6 thumbnail-g')); ?>
        <?php
            if( ($key+1)%4==0 )
            {
                //echo '</div><div class="row">';
            }
            //if( ($key+1)==sw_count($featured_properties) ) echo '</div>';
            endforeach;
        ?>
    </div>
</div> <!-- /.properties-->