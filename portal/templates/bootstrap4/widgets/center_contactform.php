<?php
/*
Widget-title: Contact form
Widget-preview-image: /assets/img/widgets_preview/center_contactform.jpg
*/
?>
<?php if(sw_count($has_settings_email) > 0): ?>
<div class="widget widget-box box-container widget-contactform" id="form-contact">
    <div class="widget-header text-uppercase">
       {lang_Contactform}
    </div>
    <form class="form-additional" action="{page_current_url}#form-contact" method="post" >
        <?php _che($validation_errors); ?>
        <?php _che($form_sent_message); ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {form_error_firstname}">
                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="{lang_FirstLast}" value="{form_value_firstname}">
                </div>

                <div class="form-group {form_error_email}">
                     <input type="email" id="email" name="email" class="form-control" placeholder="{lang_Email}" value="{form_value_email}">
                </div>
                <div class="form-group {form_error_phone}">
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="{lang_Phone}"  value="{form_value_phone}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {form_error_message}">
                     <textarea class="form-control" id="message" name="message"  placeholder="{lang_Message}" style="height:144px;">{form_value_message}</textarea>
                </div>
            </div>
                             
                                <?php if(config_db_item('terms_link') !== FALSE): ?>
                                <?php
                                    $site_url = site_url();
                                    $urlparts = parse_url($site_url);
                                    $basic_domain = $urlparts['host'];
                                    $terms_url = config_db_item('terms_link');
                                    $urlparts = parse_url($terms_url);
                                    $terms_domain ='';
                                    if(isset($urlparts['host']))
                                        $terms_domain = $urlparts['host'];

                                    if($terms_domain == $basic_domain) {
                                        $terms_url = str_replace('en', $lang_code, $terms_url);
                                    }
                                ?>
            <div class="col-md-6">
                                <div class="control-group control-gt-terms">
                                  <div class="controls">
                                    <?php echo form_checkbox('option_agree_terms', 'true', set_value('option_agree_terms', false), 'class="ezdisabled" id="inputOption_terms"')?>
                                  <a target="_blank" href="<?php echo $terms_url; ?>"><?php echo lang_check('I Agree To The Terms & Conditions'); ?></a>
</div>
                                </div>
                                </div>
                                <?php endif; ?>
                                



                                <?php if(config_db_item('privacy_link') !== FALSE && sw_count($not_logged)>0): ?>
                                                            <?php

                                $site_url = site_url();
                                $urlparts = parse_url($site_url);
                                $basic_domain = $urlparts['host'];
                                $privacy_url = config_db_item('privacy_link');
                                $urlparts = parse_url($privacy_url);
                                $privacy_domain ='';
                                if(isset($urlparts['host']))
                                    $privacy_domain = $urlparts['host'];

                                if($privacy_domain == $basic_domain) {
                                    $privacy_url = str_replace('en', $lang_code, $privacy_url);
                                }
                            ?>
             <div class="col-md-6">
                                <div class="control-group control-gt-terms">
                                  
                                  <div class="controls">
                                    <?php echo form_checkbox('option_privacy_link', 'true', set_value('option_privacy_link', false), 'class="novalidate" required="required" id="inputOption_privacy_link"')?>
                                 <a target="_blank" href="<?php echo $privacy_url; ?>"><?php echo lang_check('I Agree The Privacy'); ?></a>
 </div>
                                </div>
                                </div>
                                <?php endif; ?>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <?php if(config_item('captcha_disabled') === FALSE): ?>
                <div class="control-group control-group-captcha">
                    <?php echo $captcha[ 'image']; ?>
                    <div class="captcha-input-box  form-group {form_error_captcha}">
                        <input class="captcha form-control {form_error_captcha}" name="captcha" type="text" placeholder="{lang_Captcha}" value="" />
                        <input class="hidden" name="captcha_hash" type="text" value="<?php echo $captcha_hash; ?>" />
                    </div>
                </div>
                <?php endif; ?>
                <?php if(config_item('recaptcha_site_key') !== FALSE): ?>
                <div class="control-group form-group" >
                    <label class="control-label captcha"></label>
                    <div class="controls">
                        <?php _recaptcha(true); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <div class="form-group clearfix">
                    <button class="btn btn-primary color-primary pull-right" type='submit'>{lang_Send}</button>
                </div>
            </div>
        </div>
    </form>
</div>  <!-- /. widget-map  -->    
<?php endif;?>