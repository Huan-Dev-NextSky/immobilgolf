<?php
/*
Widget-title: Login menu
Widget-preview-image: /assets/img/widgets_preview/header_loginmenu.jpg
*/
?>
<?php _widget('custom_top_demo_geomaps_preview');?>
<div class="top-bar color-primary">
    <div class="container clearfix">
        <div class="float-left">
            <ul class="login-menu clearfix">
            {not_logged}
                <li><span><i class="fa fa-phone"></i> {settings_phone}</span></li>
                <li><a href="mailto:{settings_email}"><i class="icon-envelope icon-white"></i> {settings_email}</a></li>
                <?php if(config_db_item('property_subm_disabled')==FALSE):  ?>
                <li><a href="{front_login_url}#content"><i class="fa fa-user"></i> {lang_Login}</a></li>
                <?php endif;?>
            {/not_logged}
            {is_logged_user}
                <?php if($this->session->userdata('type') != 'VISITOR'):?>
                    <?php if(file_exists(APPPATH.'controllers/admin/booking.php')):?>
                    <li><a href="{myreservations_url}#content"><i class="fa fa-shopping-cart"></i> {lang_Myreservations}</a></li>
                    <?php endif; ?>
                    <li><a href="{myproperties_url}#content"><i class="fa fa-list"></i> {lang_Myproperties}</a></li>
                <?php endif; ?>
                <?php if(file_exists(APPPATH.'controllers/admin/savesearch.php')): ?>
                <li><a href="{myresearch_url}#content"><i class="fa fa-filter"></i> {lang_Myresearch}</a></li>  
                <?php endif; ?>
                <?php if(file_exists(APPPATH.'controllers/admin/favorites.php')):?>
                <li><a href="{myfavorites_url}#content"><i class="fa fa-star"></i> {lang_Myfavorites}</a></li>
                <?php endif; ?>
                <li><a href="<?php _che($mymessages_url); ?>#content"><i class="fa fa-envelope"></i> <?php _l('My messages'); ?></a></li>
                <li><a href="{myprofile_url}#content"><i class="fa fa-user"></i> {lang_Myprofile}</a></li>
                <li><a href="{logout_url}"><i class="fa fa-power-off"></i> {lang_Logout}</a></li>
                <?php if(isset($page_edit_url)&&!empty($page_edit_url)):?>
                <li><a href="{page_edit_url}"><i class="fa fa-edit"></i>  <?php echo _l('edit page');?></a></li>
                <?php endif;?>
                <?php _widget('custom_messenger_item');?>
            {/is_logged_user}
            {is_logged_other}
                <li><a href="{login_url}"><i class="fa fa-wrench"></i> {lang_Admininterface}</a></li>
                <li><a href="{logout_url}"><i class="fa fa-power-off"></i> {lang_Logout}</a></li>
                <?php if(isset($page_edit_url)&&!empty($page_edit_url)):?>
                <li><a href="{page_edit_url}"><i class="fa fa-edit"></i> <?php echo _l('edit page');?></a></li>
                <?php endif;?>
                <?php if(isset($category_edit_url)&&!empty($category_edit_url)) :?>
                <li><a href="{category_edit_url}"><i class="fa fa-edit"></i> <?php echo _l('edit category');?></a></li>
                <?php endif;?>
                <?php _widget('custom_messenger_item');?>
            {/is_logged_other}
            </ul>
        </div>
        <?php/*
        <div class="float-right color-secondary pull-right">
            <ul class="social-nav clearfix">
                <li><a href="https://www.facebook.com/share.php?u={homepage_url}&title=<?php echo urlencode($settings_websitetitle);?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Facebook</a></li>
                <li><a href="https://twitter.com/home?status=<?php echo urlencode($settings_websitetitle);?>%20{homepage_url}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Twitter</a></li>
                <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={homepage_url}&title=<?php echo urlencode($settings_websitetitle);?>&summary=&source=" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Linkid</a></li>
            </ul>
        </div>
        */?>
    </div>
</div><!-- /.top-bar-->
