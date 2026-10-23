<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Boutique - Immobilgolf</title>
      <?php _widget('head');?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="assets/css/custom-profile.css" />
</head>
<body>
    <header>
      <div class="container container-header">
          <div class="logo-container">
              <img src="{agent_image_url}" alt="Logo Agenzia" class="logo">
          </div>
          <h1>{page_title}</h1>
          <p class="tagline">La tua casa dei sogni a portata di buca</p>
      </div>
    </header><br>
        <div class="container-about">
            <!-- Colonna sinistra (30%) con background verde -->
            <div class="left-column">
             <div class="badge-container">
                <!-- Elementi decorativi -->
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
                <!-- Logo -->
                <div class="logo-container">
                      <img src="assets/img/immobilgolf/luxury-boutique-badge.png" alt="Logo Badge" class="luxury-badge">
                </div>
             </div>
             <?php 
               if (!empty($agent_profile['file'])): 
             ?>
             <br>
             <a href="/files/user/<?php echo $agent_profile['file']; ?>" class="about-button"><i class="fas fa-download"></i> Download Company Profile</a>
             <?php 
              endif; 
             ?>
            </div>
            <!-- Colonna destra (70%) con box "Chi Siamo" -->
            <div class="right-column">
                <div class="about-box">
                    <h2 class="about-title"><img src="assets/img/immobilgolf/flag-marker.png" alt="Logo Badge" class="light-badge"> Chi Siamo</h2>
                    <div id="scroll-description-box" class="about-text">
                        <?php echo $agent_profile['description']; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-separator"></div>
    <div class="container">
        <div class="content-section">
            <div class="info-section">
                <h2 class="titolo_sezione"><img src="assets/img/immobilgolf/golfing-reverse-white.png" alt="Logo Badge" class="light-badge"> Contatti</h2>
                {has_agent}
                <div class="contact-info">
                    <?php 
                    if (!empty($agent_profile['address'])): 
                    ?>
                    <div class="contact-item">
                        <img src="assets/img/agency/agency-location.png" alt="Location" width="20px">&nbsp;&nbsp;
                        <span>{agent_address} <?php echo $agent_profile['city']; ?></span>
                    </div>
                    <?php 
                    endif; 
                    ?>
                    <?php 
                    if (!empty($agent_profile['phone'])): 
                    ?>
                    <div class="contact-item">
                        <img src="assets/img/agency/agency-phone.png" alt="Location" width="20px">&nbsp;&nbsp;
                        <span>{agent_phone}</span>
                    </div>
                    <?php 
                    endif; 
                    ?>
                    <div class="contact-item">
                        <img src="assets/img/agency/agency-email.png" alt="Location" width="20px">&nbsp;&nbsp;
                        <span>{agent_mail}</span>
                    </div>
                    <?php 
                    if (!empty($agent_profile['payment_details'])): 
                    ?>
                        <div class="contact-item">
                            <img src="assets/img/agency/agency-hours.png" alt="Location" width="20px">&nbsp;&nbsp;
                            <span><?php echo $agent_profile['payment_details']; ?></span>
                        </div>
                    <?php 
                    endif; 
                    ?>
                </div>
                {/has_agent}
                <?php
                    $list_agent = false;
                    $array_agent = [1,2,3,4,5,6];
                    foreach ($array_agent as $row_agent)
                    {
                        $agent = json_decode($agent_profile['agent_'.$row_agent.''], true);
                        if (count($agent) > 0 && $agent['image']) {
                            $list_agent = true;
                        }
                        
                    }
                ?>
                <?php if ($list_agent) { ?>
                <div class="gallery-section">
                    <h2><img src="assets/img/immobilgolf/golfing-reverse-white.png" alt="Logo Badge" class="light-badge"> Agenti</h2>
                </div>
                <div class="agents-list">
                    <div class="row">
                        <?php 
                            foreach ($array_agent as $row_agent){
                            $agent = json_decode($agent_profile['agent_'.$row_agent.''], true);
                            if (count($agent) > 0 && $agent['image']) {
                        ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="agent-item">
                                <img src="/files/user/<?= $agent['image'] ?>" alt="<?= $agent['name'] ?>">
                                <span class="name"><?= $agent['name'] ?></span>
                            </div>
                        </div>
                        <?php }} ?>
                    </div>
                </div>
                <?php } ?>
                <div class="gallery-section">
                    <h2><img src="assets/img/immobilgolf/golfing-reverse-white.png" alt="Logo Badge" class="light-badge"> Gallery</h2>
                </div>
                <?php
                    // Assumi che $agent_profile sia già disponibile nel tuo controller
                    $repositoryId = $agent_profile['repository_id'];

                    // Usa il Query Builder di CodeIgniter
                    $this->db->select('filename');
                    $this->db->from('file');
                    $this->db->where('repository_id', $repositoryId);
                    $this->db->where('order !=', 1);
                    $this->db->order_by('order', 'ASC');

                    $query = $this->db->get();

                    if ($query->num_rows() > 0) {
                    $filenames = $query->result();

                    // Contenitore principale dello slider
                    echo '<div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper">';
                    echo '<div class="swiper-wrapper">';
                    foreach ($filenames as $file) {
                    $filename = htmlspecialchars($file->filename);
                    $image_path = base_url('/files/' . $filename);
                    echo '<div class="swiper-slide"><img src="' . $image_path . '" alt="' . $filename . '"></div>';
                    }
                    echo '</div>'; // Chiusura swiper-wrapper

                    // Pulsanti di navigazione
                    echo '<div class="swiper-button-next"></div>';
                    echo '<div class="swiper-button-prev"></div>';
                    echo '</div>'; // Chiusura main swiper-container

                    // Contenitore per le miniature
                    echo '<div class="swiper mySwiper2">';
                    echo '<div class="swiper-wrapper">';
                    foreach ($filenames as $file) {
                    $filename = htmlspecialchars($file->filename);
                    $image_path = base_url('/files/' . $filename);
                    echo '<div class="swiper-slide"><img src="' . $image_path . '" alt="' . $filename . '"></div>';
                    }
                    echo '</div>'; // Chiusura swiper-wrapper
                    echo '</div>'; // Chiusura thumb swiper-container

                    } else {
                    echo "Nessun file trovato.";
                    }

                ?><br><br>
                <h2><img src="assets/img/immobilgolf/golfing-reverse-white.png" alt="Logo Badge" class="light-badge"> Video</h2>
                <div class="video-container">
                    <?php
                    if (!empty($agent_profile['embed_video_code'])) {
                        // Si presume che 'embed_video_code' contenga SOLO l'ID del video YouTube.
                        echo '<iframe width="100%" height="315" src="https://www.youtube.com/embed/' . $agent_profile['embed_video_code'] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
                        echo '<br />';
                    } else {
                        echo '<iframe src="assets/video/immobil_video.mp4" allowfullscreen></iframe>';
                    }
                    ?>
                </div>
            </div>
            <div class="media-section">
                <div class="apartments-section">
                    <div class="apartments-header">
                      <img src="{agent_image_url}" alt="Logo Agenzia" class="logo-light">
                        <h2>I Nostri Immobili</h2>
                    </div>
                    <div class="apartments-grid">
                        <div id="ajax_results">    
                            <div class="properties properties-border">
                                <!-- PROPERTY LISTING -->
                                <?php foreach($agent_estates as $key=>$item): ?>
                                    <div class="rows">
                                        <?php _generate_results_item(array('key'=>$key, 'item'=>$item)); ?>
                                    </div>
                                <?php endforeach; ?>
                                <!-- /.properties -->
                                <?/*php if(!empty($pagination_links_agent)) :?>
                                <nav class="text-center">
                                    <div class="pagination-ajax-results pagination properties" rel="ajax_results">
                                        <?php echo $pagination_links_agent; ?>
                                    </div>
                                </nav>
                                <?php endif;*/?>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php _widget('custom_footer');?>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper2", {
          loop: true,
          spaceBetween: 10,
          slidesPerView: 4,
          freeMode: true,
          watchSlidesProgress: true,
        });

        var swiper2 = new Swiper(".mySwiper", {
          loop: true,
          spaceBetween: 10,
          navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
          },
          thumbs: {
            swiper: swiper,
          },
        });
    </script>
</body>
</html>