<?php
/*
Widget-title: Custom Filter
Widget-preview-image: /assets/img/widgets_preview/right_customfilter.jpg
*/
?>
<div class="widget widget-box  box-container widget-rightcustomfilter">
    <div class="widget-header text-uppercaser">{lang_CustomFilters}</div>
    <form class="form-additional">

        <?php if(config_db_item('secondary_disabled') === TRUE): ?>
        <?php if(isset($options_name_19)): ?>
            <div class="form-group">
                <input type="text" name='search_option_19' data-option_id="19" id="search_option_19" class="form-control input_am id_19" placeholder="{options_name_19}">
            </div>
        <?php endif; ?>
        <?php if(isset($options_name_20)): ?>
            <div class="form-group">
                <input type="text" name="options_name_20" data-option_id="20" class="form-control input_am id_20" placeholder="{options_name_20}">
            </div>
        <?php endif; ?>
        <?php if(isset($options_name_36)): ?>
            <div class="form-group">
                <input type="text" name="id_36_from" data-option_id="36" rel="from" class="form-control input_am_from id_36_from DECIMAL" placeholder="{lang_Fromprice} ({options_prefix_36}{options_suffix_36})">
            </div>
            <div class="form-group">
                    <input type="text" name='id_36_to' data-option_id="36" rel="to" class="form-control input_am_from id_36_to DECIMAL" placeholder="{lang_Toprice} ({options_prefix_36}{options_suffix_36})">
            </div>
        <?php endif; ?>
        <?php if(isset($options_name_59)): ?>
            <?php if(config_db_item('search_energy_efficient_enabled') === TRUE): ?>
            <div class="form-group">
                <select data-option_id="59" rel="to" name="id_59_to" class="form-control input_am_to id_59_to">
                <option value="">{options_name_59}</option>
                <option value="50">A</option>
                <option value="90">B</option>
                <option value="150">C</option>
                <option value="230">D</option>
                <option value="330">E</option>
                <option value="450">F</option>
                <option value="999999">G</option>
            </select>
            </div>
            <?php endif; ?>
        <?php endif; ?>
            <?php if(isset($options_name_11)): ?> 
            <div class="col-md-12 secondary-checkbox">
            <label class="checkbox">
            <input data-option_id="11" class="checkbox_am" type="checkbox" value="true{options_name_11}" />{options_name_11}<span></span>
            </label>
            </div>
            <?php endif; ?>
            <?php if(isset($options_name_22)): ?>
            <div class="col-md-12 secondary-checkbox">
            <label class="checkbox">
            <input data-option_id="22" class="checkbox_am" type="checkbox" value="true{options_name_22}" />{options_name_22}<span></span>
            </label>
            </div>
            <?php endif; ?>
            <?php if(isset($options_name_25)): ?>
            <div class="col-md-12 secondary-checkbox">
            <label class="checkbox">
            <input data-option_id="25" class="checkbox_am" type="checkbox" value="true{options_name_25}" />{options_name_25}<span></span>
            </label>
            </div>
            <?php endif; ?>
            <?php if(isset($options_name_27)): ?>
            <div class="col-md-12 secondary-checkbox">
            <label class="checkbox">
            <input data-option_id="27" class="checkbox_am" type="checkbox" value="true{options_name_27}" />{options_name_27}<span></span>
            </label>
            </div>
            <?php endif; ?>
            <?php if(isset($options_name_28)): ?>
            <div class="col-md-12 secondary-checkbox">
            <label class="checkbox">
            <input data-option_id="28" class="checkbox_am" type="checkbox" value="true{options_name_28}" />{options_name_28}<span></span>
            </label>
            </div>
            <?php endif; ?>
             <?php if(isset($options_name_29)): ?> 
            <div class="col-md-12 secondary-checkbox">
             <label class="checkbox">
             <input data-option_id="29" class="checkbox_am" type="checkbox" value="true{options_name_29}" />{options_name_29}<span></span>
             </label>
            </div>
            <?php endif; ?>
            <?php if(isset($options_name_32)): ?>
            <div class="col-md-12 secondary-checkbox">
             <label class="checkbox">
             <input data-option_id="32" class="checkbox_am" type="checkbox" value="true{options_name_32}" />{options_name_32}<span></span>
             </label>
            </div>
            <?php endif; ?>
            <?php if(isset($options_name_30)): ?>
            <div class="col-md-12 secondary-checkbox">
             <label class="checkbox">
             <input data-option_id="30" class="checkbox_am" type="checkbox" value="true{options_name_30}" />{options_name_30}<span></span>
             </label>
            </div>
            <?php endif; ?>
            <?php if(isset($options_name_33)): ?>
            <div class="col-md-12 secondary-checkbox">
             <label class="checkbox">
             <input data-option_id="33" class="checkbox_am" type="checkbox" value="true{options_name_33}" />{options_name_33}<span></span>
             </label>
            </div>
            <?php endif; ?>
            <?php if(isset($options_name_23)): ?>
            <div class="col-md-12 secondary-checkbox">
             <label class="checkbox">
             <input data-option_id="23" class="checkbox_am" type="checkbox" value="true{options_name_23}" />{options_name_23}<span></span>
             </label>
            </div>
             <?php endif; ?>
           <?php else: ?>
           
           <?php  _search_form_secondary(4); ?>
           <div style="height: 10px; display: block;clear:both;">&nbsp;</div>
           <?php endif; ?>
        
        <div class="form-group"  style="margin-bottom: 0;">
            <button class="btn btn-primary btn-wide color-primary refresh_filters" type='submit'>{lang_RefreshResults}</button>
        </div>
    </form>
</div><!-- /.widget-filter--> 