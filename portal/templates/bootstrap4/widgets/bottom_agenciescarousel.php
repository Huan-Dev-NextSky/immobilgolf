<?php
/*
Widget-title: Agencies Carousel
Widget-preview-image: /assets/img/widgets_preview/bottom_agenciescarousel.jpg
*/
?>
<?php if(!empty($all_agents)):?>
<section class="section agencies">
    <div class="container">
        <div class="section-title">
            <h2 class="section-title text-center"><span class="">{lang_Agencies}</span></h2>
        </div>
        <div class="row-fluid clearfix">
            <div class="col-lg-12 owl-corousel-box agencies-corousel">
                <div class="owl-carousel">
                    <?php foreach($all_agents as $agent): ?>
                        <?php if(isset($agent['image_sec_url'])): ?>
                            <div class="item">
                                <a href="<?php echo $agent['agent_url']; ?>"><img src="<?php echo $agent['image_sec_url']; ?>" alt=""></a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <a href="#" class="owl-btn customPrevBtn"></a>
                <a href="#" class="owl-btn customNextBtn"></a>
            </div>     
        </div>
    </div>
</section><!-- /.agencies -->    
<?php endif;?>