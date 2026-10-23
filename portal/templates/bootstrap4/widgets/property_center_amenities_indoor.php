<?php if(isset($category_options_21) && $category_options_count_21>0): ?>
<div class="widget widget-box box-container">
    <div class="widget-header text-uppercase"><span class="marker-proprieta"><img src="assets/img/immobilgolf/marker_immobilgolf.png" width="25px" alt="immobilgolf"></span>
       {options_name_21}
    </div>
    <ul class="amenities clearfix amenities-interni">
        {category_options_21}
        {is_checkbox}
        <li>
        <i class="icon2-checked"></i>{icon}&nbsp;&nbsp;{option_name}&nbsp;&nbsp;
        </li>
        {/is_checkbox}
        {/category_options_21}
    </ul>
        <?php if(isset($category_options_21) && $category_options_count_21>0)foreach ($category_options_21 as $key => $value):?>
        <?php
        if($value['option_type']!='UPLOAD') continue;
        ?> 
        <?php
        //Fetch repository
        $file_rep = array();

        if(!empty($value['option_value']) && is_numeric($value['option_value'])){
            $rep_id = $value['option_value'];
            $file_rep = $this->file_m->get_by(array('repository_id'=>$rep_id));
        }

        // If not defined in this language
        if(sw_count($file_rep) == 0)
        {
            //Fetch option for default language
            $def_lang_id = $this->language_m->get_default_id();
            if(!empty($def_lang_id))
            {
                $def_lang_rep_id = $this->option_m->get_property_value($def_lang_id, $estate_data_id, 65);

                if(!empty($def_lang_rep_id))
                $file_rep = $this->file_m->get_by(array('repository_id'=>$def_lang_rep_id));
            }
        }

        $rep_value = '';
        if(sw_count($file_rep))
        {
            $rep_value.= '<ul data-target="#modal-gallery" data-toggle="modal-gallery" class="images-gallery amn clearfix row"> ';
            foreach($file_rep as $file_r)
            {
                if(file_exists(FCPATH.'/files/thumbnail/'.$file_r->filename))
                {
                    $rep_value.=
                    '<li class="col-lg-4 col-md-6">'.
                    '    <a data-gallery="gallery" href="'.base_url('files/'.$file_r->filename).'" title="'.$file_r->filename.'" download="'.base_url('files/'.$file_r->filename).'" class="preview show-icon">'.
                    '        <img src="assets/img/preview-icon.png" class=""  alt=""/>'.
                    '    </a>'.
                    '    <div class="preview-img"><img src="'.base_url('files/thumbnail/'.$file_r->filename).'" data-src="'.base_url('files/'.$file_r->filename).'" alt="'.$file_r->filename.'" class="" /></div>'.
                    '</li>';
                }
                else if(file_exists(FCPATH.'/templates/'.$settings_template.'/assets/img/icons/filetype/'.get_file_extension($file_r->filename).'.png'))
                {
                    $rep_value.=
                    '<li class="col-lg-4 col-md-6">'.
                    '    <a target="_blank" href="'.base_url('files/'.$file_r->filename).'" title="'.$file_r->filename.'" download="'.base_url('files/'.$file_r->filename).'" class="preview skip show-icon direct-download">'.
                    '        <img src="assets/img/preview-icon.png" class="" alt=""/>'.
                    '    </a>'.
                    '    <div class="preview-img type-file"><img src="assets/img/icons/filetype/'.get_file_extension($file_r->filename).'.png" data-src="'.base_url('files/'.$file_r->filename).'" alt="'.$file_r->filename.'" class="" /></div>'.
                    '</li>';
                }
            }
            $rep_value.= '</ul>';
            echo $rep_value;
        }
        ?>
        <?php endforeach;?>
</div> <!-- /. widget-amenities -->    
<?php endif; ?>