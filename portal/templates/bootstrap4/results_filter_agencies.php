<div class="result-side h-side">
    <div class="float-left">
        <h2 class="h-side-title page-title text-color-primary"><?php echo _l('Results');?></h2> <span class='h-side-additional'>( <?php echo count($paginated_agents); ?>  )</span>
    </div>
</div>

<div class="properties elementor-widget-property view-grid">
    <div class="row-col">
        <?php foreach($paginated_agents as $key=>$item): ?>
            <?php _generate_results_item_agencies(array('key'=>$key, 'item'=>$item,'custom_class'=>'col-12 col-xl-3 col-md-3 mb-30')); ?>
        <?php endforeach; ?>
    </div>
</div>