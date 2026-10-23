<div class="h-side clearfix ">
    <div class="float-sm-left">
        <h2 class="h-side-title page-title text-color-primary"><?php echo _l('Results');?></h2> <span class='h-side-additional'>( <?php echo $total_rows; ?>  )</span>
    </div>
    <div class="float-sm-right">
        <div class="properties-filter options">
            <div class="form-group">
                <select class="form-control selectpicker select-small selectpicker-small">
                    <option value="id ASC" {order_dateASC_selected}>{lang_DateASC}</option>
                    <option value="id DESC" {order_dateDESC_selected}>{lang_DateDESC}</option>
                    <option value="price ASC" {order_priceASC_selected}>{lang_PriceASC}</option>
                    <option value="price DESC" {order_priceDESC_selected}>{lang_PriceDESC}</option>
                </select>
            </div>
            <div class="grid-type">
                <a href="#" class="view-type grid <?php _che($view_grid_selected); ?>" data-ref="grid"><i class="fa fa-th"></i></a>
                <a href="#" class="view-type list <?php _che($view_list_selected); ?>" data-ref="list"><i class="fa fa-list"></i></a>
            </div>
        </div>
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
<div class="properties view-grid">
    <div class="row">
        <!-- PROPERTY LISTING -->
        <?php foreach($results as $key=>$item): ?>
        <?php
            //if($key==0)echo '<div class="row">';
        ?>
            <?php _generate_results_item(array('key'=>$key, 'item'=>$item,'custom_class'=>'col-xl-4 col-md-6 thumbnail-g')); ?>
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

    <nav class="text-center">
        <div class="pagination properties">
            {pagination_links}
        </div>
    </nav>
</div>