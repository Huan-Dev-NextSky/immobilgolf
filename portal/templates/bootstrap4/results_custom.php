<div class="result-side h-side">
    <div class="float-left">
        <h2 class="h-side-title page-title text-color-primary"><?php echo _l('Results');?></h2> <span class='h-side-additional'>( <?php echo $total_rows; ?>  )</span>
    </div>
</div> <!-- /. content-header --> 

{has_no_results}
<div class="result-answer">
    <div class="alert alert-success">
        {lang_Noestates}
    </div>
</div>
{/has_no_results}

{has_view_grid}
<div class="properties elementor-widget-property view-grid">
    <div class="row-col">
        <!-- PROPERTY LISTING -->
        <?php foreach($results as $key=>$item): ?>
        <?php
            //if($key==0)echo '<div class="row">';
        ?>
            <?php _generate_results_item_custom(array('key'=>$key, 'item'=>$item,'custom_class'=>'col-12 col-xl-4 col-md-4', 'load'=>$first_load)); ?>
        <?php
            if( ($key+1)%3==0 )
            {
                //echo '</div><div class="row">';
            }
            //if( ($key+1)==sw_count($results) ) echo '</div>';
            endforeach;
        ?>
    </div>

{/has_view_grid}

{has_view_list}
    <div class="properties">
    <?php _widget('properties_list');?>
{/has_view_list}

    <nav class="immobilgolf-results-pagination text-center" aria-label="Pagination">
        <div class="pagination properties">
            {pagination_links}
        </div>
    </nav>
</div>