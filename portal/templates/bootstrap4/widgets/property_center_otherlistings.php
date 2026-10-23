<?php if(!empty($agent_estates)):?>
<div class="widget widget-box box-container widget-listings">
    <div class="widget-header text-uppercase">
       {lang_Agentestates}
    </div>
    <div id="ajax_results">    
        <div class="properties properties-border">
            <!-- PROPERTY LISTING -->
            <?php foreach($agent_estates as $key=>$item): ?>
            <?php
                if($key==0)echo '<div class="row">';
            ?>
                <?php _generate_results_item(array('key'=>$key, 'item'=>$item)); ?>
            <?php
                if( ($key+1)%3==0 )
                {
                    echo '</div><div class="row">';
                }
                if( ($key+1)==sw_count($agent_estates) ) echo '</div>';
                endforeach;
            ?>
            <!-- /.properties -->
            <?php if(!empty($pagination_links_agent)) :?>
            <nav class="text-center">
                <div class="pagination-ajax-results pagination properties" rel="ajax_results">
                    <?php echo $pagination_links_agent; ?>
                </div>
            </nav>
            <?php endif;?>  
        </div>
    </div>
</div><!-- /. widget-facebook -->  
<?php endif;?>  