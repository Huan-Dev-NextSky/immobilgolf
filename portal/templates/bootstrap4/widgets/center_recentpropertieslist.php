<?php
/*
Widget-title: Properties Result List
Widget-preview-image: /assets/img/widgets_preview/center_recentpropertieslist.jpg
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
                <a href="#" class="view-type grid" data-ref="grid"><i class="fa fa-th"></i></a>
                <a href="#" class="view-type list active" data-ref="list"><i class="fa fa-list"></i></a>
            </div>
        </div>
    </div>
</div> <!-- /. content-header --> 
<div class="properties">
    <div class="">
        <?php _widget('properties_list');?>
    </div>
    <nav class="text-center">
        <div class="pagination properties">
            {pagination_links}
        </div>
    </nav>
</div> <!-- /.properties-->
</div>