<?php
/*
Widget-title: Contact Info
Widget-preview-image: /assets/img/widgets_preview/right_contact.jpg
*/
?>
<div class="widget widget-box box-container widget-properties">
    <div class="widget-header text-uppercaser">{lang_Info}</div>
        <div class="widget-body">
            <p>
                <span style="font-weight: bold;">
                    {settings_address_footer}
                </span>
                <br>
                <span style="font-weight: bold;">
                    <span><?php echo _l('Tel');?>:</span>
                </span> {settings_phone}<br>
                
                <span style="font-weight: bold;">
                    <span><?php echo _l('Fax');?>:</span>
                </span> {settings_fax}<br>
                
                <span style="font-weight: bold;">
                    <span><?php echo _l('Mail');?>:</span>
                </span> {settings_email}
            </p>
        </div>
</div><!-- /.widget-form--> 