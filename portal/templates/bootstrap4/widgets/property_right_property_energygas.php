 <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/dpejes/dpe.js')): ?>
    <?php if(!empty($options_name_59)): ?>
      <?php

        $values_chars = array(  'A'=>'40',
                                'B'=>'80',
                                'C'=>'140',
                                'D'=>'220',
                                'E'=>'320',
                                'F'=>'440',
                                'G'=>'460');

        if(isset($estate_data_option_59) && !is_numeric($estate_data_option_59))
        {
            if(isset($values_chars[$estate_data_option_59]))
                $estate_data_option_59 = $values_chars[$estate_data_option_59];
        }
      ?>
    <div class="widget widget-box box-container widget-energy-eff">
        <div class="widget-header text-uppercase"><span class="marker-proprieta"><img src="assets/img/immobilgolf/marker_immobilgolf.png" width="25px" alt="immobilgolf"></span>
            {options_name_59}
        </div>
        <!--energy version full -->
        <div class="divider"></div>

        <div title="energie:<?php _che($estate_data_option_59); ?>" style="margin-top: 5px;" class='energy-eff-box'>
          <div class="alert alert-warning"><?php _l('No Efficiency');?></div>
        </div>
      <!--energy --> 
    </div><!-- /. widget-energy -->   
    <?php endif; ?>
    
    <?php if(!empty($options_name_60)): ?>
    <?php
        $values_chars = array(  'A'=>'4',
                                'B'=>'9',
                                'C'=>'19',
                                'D'=>'34',
                                'E'=>'54',
                                'F'=>'79',
                                'G'=>'81');

        if(isset($estate_data_option_60) && !is_numeric($estate_data_option_60))
        {
            if(isset($values_chars[$estate_data_option_60]))
                $estate_data_option_60 = $values_chars[$estate_data_option_60];
        }
    ?>
    
    <div class="widget widget-box box-container widget-energy-eff">
        <div class="widget-header text-uppercase"><span class="marker-proprieta"><img src="assets/img/immobilgolf/marker_immobilgolf.png" width="25px" alt="immobilgolf"></span>
            {options_name_60}
        </div>
        <!--energy version full -->
        <div class="divider"></div>

        <div title="ges:<?php _che($estate_data_option_60); ?>" style="margin-top: 5px;" class='energy-eff-box'>
          <div class="alert alert-warning"> <?php _l('No Gas');?> </div>
        </div>
      <!--energy --> 
    </div><!-- /. widget-energy-gas -->     
    <?php endif; ?>
    
    <script type="text/javascript">
    /* start impl�ment dpe-->   */
        var IMG_FOLDER = "assets/js/dpejes";
        dpe.show_numbers = true;
        dpe.energy_title1 = "Energy efficient";
            dpe.energy_title2 = "80 kWh EP ";
            dpe.energy_title3 = "";
        dpe.gg_title2 = "30 kg CO2 ";
            dpe.gg_title1 = "Gas emission";

        if(!dpe.show_numbers)
        {
            dpe.energy_title2 = "";
            dpe.gg_title2 = "";
        }

            /* adjusts the height of the large thumbnails (the width is automatically adjusted proportionally)
             * possible values: de 180 a 312 
             */
            dpe.canvas_height = 210;
            /*not to display the unit gas emissions greenhouse in the right column: */
            dpe.gg_unit = '';
            /*  adjusts the height of the small thumbnails
             * possible values: 35
             */
            dpe.sticker_height = 35;
            /* can change the attribute of div tags that indicates it is a tag */
            dpe.tag_attribute = 'attributdpe';
            dpe.tag_attribute = 'title';
            /* Launches replacing the contents of the div right by good vignettes */
            dpe.all();
            
   $(document).ready(function(){
       setTimeout(function(){
       if($('.energy-eff-box > .alert.alert-warning').length) {
           $('.energy-eff-box > .alert.alert-warning').each(function(){
               $(this).closest('.widget').remove();
           })
       }
       },5000)
   })
    /* end implement dpe-->   */
    </script>
<?php endif; ?>