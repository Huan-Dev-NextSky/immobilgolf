<?php
/*
Widget-title: Agents carousel
Widget-preview-image: /assets/img/widgets_preview/bottom_agentscarousel.jpg
*/
?>
<?php if(!empty($paginated_agents)):?>
<section class="section agents  section-color-primary">
    <div class="container">
        <div class="section-title">
            <h2 class="section-title text-center"><span class="">{lang_Agents}</span></h2>
        </div>
        <div class="row-fluid clearfix">
            <div class="col-lg-12  owl-corousel-box agents-corousel" id='agents-corousel'>
                <div class="owl-carousel"> 
                    <?php foreach($paginated_agents as $item): ?>
                        <div class="item agents-corousel-item">
                            <div class="box-container media">
                                <div class="agent-logo media-left media-middle">
                                    <a href="<?php  _che($item['agent_url']);?>" class='img-circle-cover' title="<?php  _che($item['name_surname']);?>">
                                        <img src="<?php echo _simg($item['image_url'], '90x90'); ?>" alt="" class="img-circle">
                                    </a>
                                </div>
                                <div class="agent-details media-right media-top">
                                    <a href="<?php  _che($item['agent_url']);?>" class="agent-name text-color-primary" title="<?php  _che($item['name_surname']);?>"><?php  _che($item['name_surname']);?></a>
                                    <span class="phone" title="<?php  _che($item['phone']);?>"><?php  _che($item['phone']);?></span>
                                    <a href="mailto:<?php  _che($item['mail']);?>" title="<?php  _che($item['mail']);?>" class="mail" title="<?php  _che($item['mail']);?>"><?php  _che($item['mail']);?></a>
                                </div>
                            </div><!-- /.agent-card--> 
                        </div>
                    <?php endforeach;?>
                </div>
                <a href="#" class="owl-btn customPrevBtn"></a>
                <a href="#" class="owl-btn customNextBtn"></a>
            </div>     
        </div>
    </div>
</section><!-- /.agencies -->
<?php endif;?>
