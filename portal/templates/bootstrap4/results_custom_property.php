<?php foreach($results as $key=>$item): ?>
    <?php _generate_results_item_custom_property(array('key'=>$key, 'item'=>$item,'custom_class'=>'slider-slide swiper-slide', 'load'=>true)); ?>
<?php endforeach; ?>