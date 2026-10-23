<?php
/*
 * Right search for template page_homepage-side
 * 
 * 
 */

?>

<div class="results-properties-list" id="results_conteiner">
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
                <a href="#" class="view-type grid active" data-ref="grid"><i class="fa fa-th"></i></a>
                <a href="#" class="view-type list" data-ref="list"><i class="fa fa-list"></i></a>
            </div>
        </div>
    </div>
</div> <!-- /. content-header --> 
<div class="properties">
    <!-- PROPERTY LISTING -->
    <?php foreach($results as $key=>$item): ?>
    <?php
        if($key==0)echo '<div class="row">';
    ?>
        <?php _generate_results_item(array('key'=>$key, 'item'=>$item,'columns'=>2)); ?>
    <?php
        if( ($key+1)%2==0 )
        {
            echo '</div><div class="row">';
        }
        if( ($key+1)==sw_count($results) ) echo '</div>';
        endforeach;
    ?>
</div> <!-- /.properties-->
<nav class="text-xs-right">
    <div class="pagination properties">
        {pagination_links}
    </div>
</nav>
</div>