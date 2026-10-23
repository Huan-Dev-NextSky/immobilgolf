<?php
/**
 * Check if the value is a valid date
 *
 * @param mixed $value
 *
 * @return boolean
 */
if(!function_exists('isDate')){
    function isDate($value) 
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
}
?>
<?php if(isset($category_options_1) && $category_options_count_1>0): ?>
<div class="ribbon-property-vendita">{estate_data_option_4}</div>
<div class="widget widget-box box-container widget-overview price-box">
    <!--<div class="container-tipo"><span class="marker-tipo">{estate_data_option_2}</span></div>-->
    <div class="container-tipo"><span class="marker-superficie"><img src="assets/img/immobilgolf/icona-m2.png" width="30px" alt="immobilgolf"> {estate_data_option_57} m2</span></div>
    <div class="container-prezzo">
    <?/*php if(isset($category_options_1)) foreach($category_options_1 as $key=>$row): */?>
    <?/*php if(isset($row['option_value']) && (bool)strtotime( $row['option_value'])):*/ ?>
    <?/*php endif; */?>
    <?/*php 
    if (isset($row['option_id']) && $row['option_id'] == '4') {
        $option_value_lower = strtolower($row['option_value']);
        
        if ($option_value_lower == 'vendita' || $option_value_lower == 'sale') {
            echo "{estate_data_option_36}";
        } elseif ($option_value_lower == 'affitto' || $option_value_lower == 'rent') {
            echo "{estate_data_option_55} /mese";
        }
    }
    */?>
    
    <?/*php endforeach; */?>
    <?php
    // Inizializza le variabili prima del loop
    $option_4_value = null;
    $option_1062_value = null;
    
    // Prima raccogli tutti i valori che ti servono
    foreach($category_options_1 as $key=>$row) {
        if (isset($row['option_id'])) {
            if ($row['option_id'] == '4') {
                $option_4_value = strtolower($row['option_value']);
            } 
            if ($row['option_id'] == '1062') {
                $option_1062_value = strtolower($row['option_value']);
            }
        }
    }
    
    // Ora applica la logica di visualizzazione con switch
    if ($option_4_value) {
        switch ($option_4_value) {
            case 'vendita':
                if ($option_1062_value === 'true') {
                    echo "<span class='marker-riservata'>TRATTATIVA RISERVATA";
                } else {
                    echo "<span class='marker-prezzo'>€ {estate_data_option_36}";
                }
                break;
                
            case 'sale':
                if ($option_1062_value === 'true') {
                    echo "<span class='marker-riservata'>CONFIDENTIAL NEGOTIATION";
                } else {
                    echo "<span class='marker-prezzo'>€ {estate_data_option_36}";
                }
                break;
                
            case 'affitto':
                if ($option_1062_value === 'true') {
                    echo "<span class='marker-riservata'>TRATTATIVA RISERVATA";
                } else {
                    echo "<span class='marker-prezzo'>€ {estate_data_option_55} /mese";
                }
                break;
            case 'rent':
                if ($option_1062_value === 'true') {
                    echo "<span class='marker-riservata'>CONFIDENTIAL NEGOTIATION";
                } else {
                    echo "<span class='marker-prezzo'>€ {estate_data_option_55} /month";
                }
                break;
                
            default:
                // Gestione per altri valori non previsti
                echo "{estate_data_option_36}";
                break;
        }
    }
    ?>
    </span></div>
</div>
<div class="widget widget-box box-container widget-specifiche">
    <div class="widget-header text-uppercase"><span class="marker-proprieta"><img src="assets/img/immobilgolf/marker_immobilgolf.png" width="25px" alt="immobilgolf"></span>
       {lang_Overview}
    </div>
    <ul class="list-overview">
        <?/*php
        <li>
            <span class="list-overview-option"><?php echo lang_check('Updated:'); ?></span>
            <span class="list-overview-value"><?php echo $estate_data_date_modified; ?></span>
        </li>
        */?>
        <div class="golf-info-wrapper">
            <li class="circolo-golf">
                <span class="list-overview-option">GOLF CLUB</span>
                <span class="list-overview-value dettagli-circolo" title="">
                    <a href="#dettagli-circolo">{estate_data_option_1000}</a>
                </span>
            </li>
            <div class="titolo-flag"> <img src="assets/img/immobilgolf/bk-flag-title.png"  alt="immobilgolf"></div>
        </div>
      
        <li>
            <span class="list-overview-option">{lang_Address}:</span>
            <span class="list-overview-value" title="{estate_data_address}">{estate_data_address}</span>
        </li>
        <?php if(isset($category_options_1)) foreach($category_options_1 as $key=>$row): ?>
            <?php if(isset($row['option_value']) && (bool)strtotime( $row['option_value'])): ?>
            <!-- /. hide field -->
            <?php elseif ($row['option_id'] === '55'): ?>
                <li>
                    <span class="list-overview-option"><?php _che($row['option_name']);?>:</span>
                    <span class="list-overview-value" title='<?php _che($row['option_value']);?>'>
                        <?php if (isDate($row['option_value']) &&  date('Y-m-d') == date('Y-m-d', strtotime($row['option_value']))):?>
                            <?php echo lang_check('Today');?>
                        <?php else:?>
                            <?php _che($row['option_prefix']);?> <?php _che($row['option_value']);?> <?php _che($row['option_suffix']);?>
                        <?php endif;?>
                    </span>
                </li><!-- /.property-detail-overview-item -->
            <?php elseif(!empty($row['is_text'])): ?>
                <?php if(filter_var($row['option_value'], FILTER_VALIDATE_URL)):?>
                    <li class="icon earth"><a href="<?php _che($row['option_value']);?>"><?php _che($row['option_value']);?></a></li>  
                <!-- /. hide field -->
                <?php elseif ($row['option_id'] === '40' || $row['option_id'] === '36'): ?>
                <?php else:?>
                    <li>
                        <span class="list-overview-option singola-specifica"><img src="assets/img/immobilgolf/<?php _che($row['option_hint']);?>.png" /> <?php _che($row['option_name']);?>:</span>
                        <span class="list-overview-value" title="<?php _che($row['option_prefix']);?> <?php _che($row['option_value']);?> <?php _che($row['option_suffix']);?>"><?php _che($row['option_prefix']);?> <?php _che($row['option_value']);?> <?php _che($row['option_suffix']);?></span>
                    </li><!-- /.property-detail-overview-item -->
                <?php endif;?>
            <?php elseif(!empty($row['is_dropdown'])): ?>
                <li>
                    <span class="list-overview-option singola-specifica"><img src="assets/img/immobilgolf/<?php _che($row['option_hint']);?>.png" /> <?php _che($row['option_name']);?>:</span>
                    <span class="list-overview-value"> <span class="label label-default label-tag-primary"><?php _che($row['option_value']);?></span></span>
                </li><!-- /.property-detail-overview-item -->
            <?php endif;?>
            <?php if(!empty($row['is_checkbox'])): ?>
                <li>
                    <span class="list-overview-option"><?php _che($row['option_name']);?>:</span>
                    <span class="list-overview-value" title="<?php _che($row['option_prefix']);?> <?php _che($row['option_value']);?> <?php _che($row['option_suffix']);?>"><img src="assets/img/checkbox_<?php _che($row['option_value']);?>.png" alt="<?php _che($row['option_value']);?>" /></span>
                </li><!-- /.property-detail-overview-item -->
            
            <?php endif;?>
        <?php endforeach;?>
                
        <?php if(!empty($estate_data_option_64) && isset($this->treefield_m)): ?>
        <li>
                <span class="list-overview-option"><?php echo $options_name_64; ?>:</span>
                <span class="list-overview-value">
                <?php
                    $nice_path = $estate_data_option_64;
                    $link_defined = false;
                    // Get treefield with language data
                    $treefield_id = $this->treefield_m->id_by_path(64, $lang_id, $nice_path);
                    if(is_numeric($treefield_id))
                    {
                        $treefield_data = $this->treefield_m->get_lang($treefield_id, TRUE, $lang_id);

                        // If no content defined then no link, just span
                        if(!empty($treefield_data->{"body_$lang_id"}))
                        {
                            // If slug then define slug link
                            $href = slug_url('treefield/'.$lang_code.'/'.$treefield_id.'/'.url_title_cro($treefield_data->{"value_$lang_id"}), 'treefield_m');
                            echo '<a href="'.$href.'" title="'.$nice_path.'">'.$nice_path.'</a>';
                            $link_defined=true;
                        }
                    }
                    if(!$link_defined) echo $nice_path;
                ?>
                </span>
        </li>
        <?php endif;?>
        <?php
            foreach($category_options_1 as $key=>$row)
            {
                if($row['option_type'] == 'UPLOAD')
                {
                    if(!empty($row['option_value']) && is_numeric($row['option_value']))
                    {
                        //Fetch repository
                        $rep_id = $row['option_value'];
                        $file_rep = $this->file_m->get_by(array('repository_id'=>$rep_id));
                        $rep_value = '';
                        if(sw_count($file_rep))
                        {
                            $rep_value.= '<ul>';
                            foreach($file_rep as $file_r)
                            {
                                $rep_value.= "<li><a target=\"_blank\" href=\"".base_url('files/'.$file_r->filename)."\">$file_r->filename</a></li>";
                            }
                            $rep_value.= '</ul>';

                            echo ' <li><span class="list-overview-option">'.$row['option_name'].':</span></li>';
                            echo $rep_value;
                        }
                    }
                }

            }
        ?>
        
        <?php
        // Controlla se la variabile esiste ed ha un valore
        if (!empty($estate_data_counter_views)) {
            // Controlla se l'utente è un amministratore
            if ($this->session->userdata('type') == 'ADMIN') {
        ?>
        <li>
            <span class="list-overview-option">{lang_ViewsCounter}:</span>
            <span class="list-overview-value" title="{estate_data_counter_views}">{estate_data_counter_views}</span>
        </li>
       <?php
            }
        }
        ?>
        <?php if(!empty($estate_data_option_56)): ?>
        <li>
            <span class="list-overview-option">{lang_Pro}:</span>
            <span class="list-overview-value" title="<?php _che($estate_data_option_56);?>">
                <?php for($i=0; $i<$estate_data_option_56; $i++):?>
                <i class="icon2-star"></i>
                <?php endfor;?>
            </span>
        </li>
        <?php endif;?>
        <?php if(!empty($avarage_stars) && file_exists(APPPATH.'controllers/admin/reviews.php') && $settings_reviews_enabled): ?>
        <li>
            <span class="list-overview-option">{lang_Users}:</span>
            <span class="list-overview-value" title="<?php _che($avarage_stars);?>">
                <?php for($i=0; $i<$avarage_stars; $i++):?>
                <i class="icon2-star"></i>
                <?php endfor;?>
            </span>
        </li>
        <?php endif;?>
    </ul>
</div><!-- /. widget-OVERVIEW -->   
<?php endif;?>