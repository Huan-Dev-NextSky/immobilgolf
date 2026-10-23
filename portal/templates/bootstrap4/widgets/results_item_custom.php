<?php
$col_sm = '4';
if(isset($columns) && $columns == 3)
{
    $col_sm = '4';
}

if(isset($columns) && $columns == 4)
{
    $col_sm = '3';
}
if(isset($columns) && $columns == 2)
{
    $col_sm = '6';
}

if(isset($columns) && $columns == 12)
{
    $col_sm = '12';
}
$class='';
if(isset($custom_class) && !empty($custom_class))
{
    $class = $custom_class;
} else {
    $class = 'col-lg-'.$col_sm;
}
?>

<div class="<?php echo $class;?>">
    <div class="immobilgolf-property">
        <div class="property-card card">
            <div class="property-card-header image-box">
                <div class="ribbon-immobilgolf"><?php echo _ch($item['option_4']); ?></div>
                <a href="<?php echo $item['url']; ?>" class="property-card-hover">
                    <img src="<?php echo _simg($item['thumbnail_url'], '510x330'); ?>" alt="" class="">
                </a>
            </div>
            <div class="property-card-tags">
                <?php if ($load) { ?>
                    <span class="golf-club"><img src="<?= base_url('templates/bootstrap4/assets/img/immobilgolf/golf-flag-green.png') ?>" alt="golf flag">
                <?php } else { ?>
                    <span class="golf-club"><img src="assets/img/immobilgolf/golf-flag-green.png" alt="golf flag">
                <?php } ?>
                <?php
                    $valore_completo = $item['option_1000'];
                    $parte_desiderata = '';
                    
                    // Cerca l'ultima occorrenza del trattino
                    $pos_ultimo_trattino = strrpos($valore_completo, '-');
                    
                    if ($pos_ultimo_trattino !== false) {
                        // Estrai la sottostringa partendo dalla posizione dopo il trattino
                        // e lo spazio (quindi +2)
                        $parte_desiderata = substr($valore_completo, $pos_ultimo_trattino + 2);
                        // Rimuovi eventuali spazi bianchi all'inizio o alla fine
                        $parte_desiderata = trim($parte_desiderata);
                    
                        // Stampa il risultato
                        echo $parte_desiderata;
                    }
                ?>
                </span>
                <span class="golf-label">
                    <span class="badge-superficie"><i class="fas fa-ruler-combined"></i> <span><?php _che($item['option_57']); ?> m²</span></span>
                    <?php if ($load) { ?>
                        <span class="glifo"><img src="<?= base_url('templates/bootstrap4/assets/img/immobilgolf/glifo-bianco-green.png') ?>" alt="glifo"></span>
                    <?php } else { ?>
                        <span class="glifo"><img src="assets/img/immobilgolf/glifo-bianco-green.png" alt="glifo"></span>
                    <?php } ?>
                </span>
            </div>
            <div class="property-card-box card-box card-block">
                <div class="property-card-title"><a href="<?php echo $item['url']; ?>"><?php _che($item['option_10']); ?></a></div>
                <div class="property-card-descr"><?php _che($item['option_chlimit_8']); ?>
                </div>        
            </div>
        </div>
    </div>
</div>