<?php if (config_item('agency_agent_enabled') === FALSE): ?>
    <?php if (!empty($estate_data_option_67)): ?>
        <div class="widget widget-box box-container widget-company">
            <div class="widget-header text-uppercase titolo-agente">
                <?php echo lang_check('Company details'); ?>
            </div>
            <div class="">
                <?php
                if (!empty($estate_data_option_74)) {
                    //Fetch repository
                    $rep_id = $estate_data_option_74;
                    $file_rep = $this->file_m->get_by(array('repository_id' => $rep_id));
                    $rep_value = '';
                    if (sw_count($file_rep)) {
                        echo '<div class="image-company"><img src="' . base_url('files/' . $file_rep[0]->filename) . '" alt="' . $estate_data_option_67 . '" /></div>';
                    }
                }
                ?><br>
                <?php if (!empty($estate_data_option_67)): ?><div class="name name-agent"><?php echo $estate_data_option_67; ?></div><?php endif; ?>
                <?php if (!empty($estate_data_option_68)): ?>
                    <div class="phone dettaglio-agente">
                        <img src="assets/img/icon-phone.png" width="25px" alt="immobilgolf">
                        <a href="tel:<?php echo $estate_data_option_68; ?>"><?php echo $estate_data_option_68; ?></a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($estate_data_option_1063)): ?>
                    <div class="phone dettaglio-agente">
                        <img src="assets/img/icon-email.png" width="25px" alt="immobilgolf">
                        <a href="mailto:<?php echo $estate_data_option_1063; ?>"><?php echo $estate_data_option_1063; ?></a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($estate_data_option_73)): ?>
                    <div class="hours dettaglio-agente">
                        <img src="assets/img/icon-hours.png" width="25px" alt="immobilgolf">
                        <?php echo lang_check('Office hours'); ?>: <?php echo $estate_data_option_73; ?>
                    </div>
                <?php endif; ?>
                <?/*php if (!empty($estate_data_option_69)): ?>
                    <div class="website dettaglio-agente"><a target="_blank" style="color: blue;" href="<?php echo $estate_data_option_69; ?>">
                        <svg fill="#1e4632" height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 490 490" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M445.06,154.352C410.115,77.368,333.233,26.827,248.63,25.425c-87.761-1.454-167.512,49.093-203.714,128.93 C19.6,157.729,0,179.451,0,205.675v78.647c0,26.227,19.604,47.95,44.924,51.321C80.517,414.166,158.449,464.605,245,464.605 c86.558,0,164.489-50.435,200.077-128.963c25.319-3.371,44.923-25.094,44.923-51.32v-78.647 C490,179.443,470.387,157.716,445.06,154.352z M248.32,44.113c74.364,1.232,142.218,43.957,175.786,109.772H65.871 C100.599,85.593,171.068,42.833,248.32,44.113z M245,445.915c-76.138,0-144.986-42.66-179.12-109.803h358.24 C389.989,403.255,321.144,445.915,245,445.915z M471.31,284.322c0,18.252-14.848,33.1-33.1,33.1H51.79 c-18.252,0-33.1-14.848-33.1-33.1v-78.647c0-18.252,14.848-33.1,33.1-33.1h386.42c18.252,0,33.1,14.848,33.1,33.1V284.322z"></path> <polygon points="135.931,258.049 120.134,209.152 98.323,209.152 82.526,258.049 66.729,209.152 43.403,209.152 70.936,290.094 94.252,290.094 109.302,246.011 124.195,290.094 147.667,290.094 175.2,209.152 151.728,209.152 "></polygon> <polygon points="271.634,258.049 255.837,209.152 234.026,209.152 218.228,258.049 202.432,209.152 179.106,209.152 206.639,290.094 229.955,290.094 245.005,246.011 259.898,290.094 283.369,290.094 310.903,209.152 287.431,209.152 "></polygon> <polygon points="407.337,258.049 391.539,209.152 369.729,209.152 353.931,258.049 338.135,209.152 314.809,209.152 342.342,290.094 365.658,290.094 380.708,246.011 395.601,290.094 419.072,290.094 446.605,209.152 423.134,209.152 "></polygon> </g> </g></svg>
                        <?php echo lang_check('Website'); ?></a>
                    </div>
                <?php endif;*/ ?><br>
                <!--<div style="padding: 5px;">
                <?/*php if (!empty($estate_data_option_73)): ?><div class="description"><em><?php echo $estate_data_option_73; ?></em></div><?php endif; */?>
                <?/*php if (!empty($estate_data_option_72)): ?><div class="description"><em><?php echo $estate_data_option_72; ?></em></div><?php endif; */?>
                <?/*php if (!empty($estate_data_option_70)): ?><a target="_blank" href="<?php echo $estate_data_option_70; ?>"><img src="assets/img/facebook.png" /></a><?php endif;*/ ?>
                <?/*php if (!empty($estate_data_option_71)): ?><a target="_blank" href="<?php echo $estate_data_option_71; ?>"><img src="assets/img/linkedin.png" /></a><?php endif;*/ ?>
                </div>-->
            </div>
        </div><!-- /. widget-OVERVIEW -->   
    <?php endif; ?>
<?php else: ?>
    {has_agent}
    <div class="widget widget-box box-container widget-company">
        <div class="widget-header text-uppercase">
            <?php echo lang_check('Company details'); ?>
        </div>
        <div class="">
            <?php
            if (!empty($agency_image_url)) {
                echo '<div class="image-company"><img src="' .$agency_image_url . '" alt="' . _ch($estate_data_option_67,'') . '" /></div>';
            }
            ?>
            <?php if (!empty($estate_data_option_67)): ?><div class="name"><a href="{agent_url}#content"><?php echo $estate_data_option_67; ?></a></div><?php endif; ?>
            <?php if (!empty($estate_data_option_68)): ?><div class="phone"><?php echo $estate_data_option_68; ?></div><?php endif; ?>
            <?php if (!empty($estate_data_option_73)): ?><div class="hours"><?php echo lang_check('Office hours'); ?>: <?php echo $estate_data_option_73; ?></div><?php endif; ?>
            <?php if (!empty($estate_data_option_69)): ?><div class="website"><a target="_blank" style="color: blue;" href="<?php echo $estate_data_option_69; ?>"><?php echo lang_check('Website'); ?></a></div><?php endif; ?>
            <div style="padding: 5px;">
            <?php if (!empty($estate_data_option_73)): ?><div class="description"><em><?php echo $estate_data_option_73; ?></em></div><?php endif; ?>
            <?php if (!empty($estate_data_option_72)): ?><div class="description"><em><?php echo $estate_data_option_72; ?></em></div><?php endif; ?>
            <?php if (!empty($estate_data_option_70)): ?><a target="_blank" href="<?php echo $estate_data_option_70; ?>"><img src="assets/img/social-facebook-button-blue-icon.png" /></a><?php endif; ?>
                <?php if (!empty($estate_data_option_71)): ?><a target="_blank" href="<?php echo $estate_data_option_71; ?>"><img src="assets/img/social-twitter-button-blue-icon.png" /></a><?php endif; ?>
            </div>

        </div>
    </div><!-- /. widget-OVERVIEW -->   
    {/has_agent}
<?php endif; ?>