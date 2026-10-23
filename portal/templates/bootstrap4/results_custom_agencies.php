<?php foreach($paginated_agents as $key=>$item): ?>
    <div  class="slider-slide swiper-slide">
        <a href="<?php  _che($item['agent_url']);?>" class="agencies-card">
            <div class="card mx-auto">
                <div class="card-image">
                    <img src="<?php echo _simg($item['image_url'], '90x90'); ?>" alt="<?php  _che($item['name_surname']);?>" class="card-img-top">
                </div>
                <div class="card-body">
                    <div class="card-text"><?php  _che($item['name_surname']);?></div>
                    <div class="address"><?php  _che($item['address']);?></div>
                </div>
            </div>
        </a>
    </div>
<?php endforeach; ?>