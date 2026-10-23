<?php
/*
Widget-title: Custom Filter Visual
Widget-preview-image: /assets/img/widgets_preview/right_customfilter.jpg
*/
?>
<div class="widget widget-box  box-container widget-rightcustomfilter">
    <div class="widget-header text-uppercaser">{lang_CustomFilters}</div>
    <form class="form-additional">

           <?php  _search_form_secondary(4); ?>
        
           <div style="height: 10px; display: block;clear:both;">&nbsp;</div>
        
        <div class="form-group" style="margin-bottom: 0;">
            <button class="btn btn-primary btn-wide color-primary refresh_filters" type='submit'>{lang_RefreshResults}</button>
        </div>
    </form>
</div><!-- /.widget-filter--> 