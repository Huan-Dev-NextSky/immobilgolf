<?php
/*
Widget-title: Main menu & Logo & lang menu
Widget-preview-image: /assets/img/widgets_preview/header_mainmenu.jpg
*/
?>
<?php
if ( ! function_exists('get_lang_menu_custom'))
{
function get_lang_menu_custom($array, $lang_code, $extra_ul_attributes = '')
    {
        $CI =& get_instance();
        $property_data = NULL;

        if(sw_count($array) == 1)
            return '';

        if(empty($CI->data['listing_uri']))
        {
            $listing_uri = 'property';
        }
        else
        {
            $listing_uri = $CI->data['listing_uri'];
        }

        $default_base_url = config_item('base_url');
        $default_lang_code = $CI->language_m ->get_default();
        $first_page = $CI->page_m->get_first();

        $str = '<ul '.$extra_ul_attributes.'>';
        foreach ($array as $item) {
            $active = $lang_code == $item['code'] ? TRUE : FALSE;

            $custom_domain_enabled=false;
            if(config_db_item('multi_domains_enabled') === TRUE)
            {
                if(!empty($item['domain']) && substr_count($item['domain'], 'http') > 0)
                {
                    $custom_domain_enabled=true;
                    $CI->config->set_item('base_url', $item['domain']);
                }
                else
                {
                    $CI->config->set_item('base_url', $default_base_url);
                }
            }

            $flag_icon = '';

            if(isset($CI->data['settings_template']))
            {
                $template_name = $CI->data['settings_template'];
                if(file_exists(FCPATH.'templates/'.$template_name.'/assets/img/flags/'.$item['code'].'.png'))
                {
                    $flag_icon = '&nbsp; <img src="'.'assets/img/flags/'.$item['code'].'.png" alt="" />';
                }
            }

            if($CI->uri->segment(1) == $listing_uri)
            {
                if($active)
                {
                    $str.='<li class="'.$item['code'].' active">'.anchor(slug_url($listing_uri.'/'.$CI->uri->segment(2).'/'.$item['code'].'/'.$CI->uri->segment(4)), $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
                else
                {
                    $property_title = '';
                    if($property_data === NULL)
                        $property_data = $CI->estate_m->get_dynamic($CI->uri->segment(2));

                    if(isset($property_data->{'option10_'.$item['id']}))
                        $property_title = $property_data->{'option10_'.$item['id']};

                    $str.='<li class="'.$item['code'].'" >'.anchor(slug_url($listing_uri.'/'.$CI->uri->segment(2).'/'.$item['code'].'/'.url_title_cro($property_title)), $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
            }
            else if($CI->uri->segment(1) == 'showroom')
            {
                if($active)
                {
                    $str.='<li class="'.$item['code'].' active">'.anchor('showroom/'.$CI->uri->segment(2).'/'.$item['code'], $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
                else
                {
                    $str.='<li class="'.$item['code'].'">'.anchor('showroom/'.$CI->uri->segment(2).'/'.$item['code'], $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
            }
            else if($CI->uri->segment(1) == 'profile')
            {
                if($active)
                {
                    $str.='<li class="'.$item['code'].' active">'.anchor(slug_url('profile/'.$CI->uri->segment(2).'/'.$item['code']), $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
                else
                {
                    $str.='<li class="'.$item['code'].'">'.anchor(slug_url('profile/'.$CI->uri->segment(2).'/'.$item['code']), $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
            }
            else if($CI->uri->segment(1) == 'propertycompare')
            {
                if($active)
                {
                    $str.='<li class="'.$item['code'].' active">'.anchor(slug_url('propertycompare/'.$CI->uri->segment(2).'/'.$item['code']), $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
                else
                {
                    $str.='<li class="'.$item['code'].'">'.anchor(slug_url('propertycompare/'.$CI->uri->segment(2).'/'.$item['code']), $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
            }
            else if($CI->uri->segment(1) == 'treefield')
            {
                if($active)
                {
                    $str.='<li class="'.$item['code'].' active">'.anchor(slug_url('treefield/'.$item['code'].'/'.$CI->uri->segment(3).'/'.$CI->uri->segment(4)), $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
                else
                {
                    $str.='<li class="'.$item['code'].'">'.anchor(slug_url('treefield/'.$item['code'].'/'.$CI->uri->segment(3).'/'.$CI->uri->segment(4)), $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
            }
            else if(is_numeric($CI->uri->segment(2)))
            {
                if($active)
                {
                    $str.='<li class="'.$item['code'].' active">'.anchor(slug_url($item['code'].'/'.$CI->uri->segment(2), 'page_m'), $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
                else
                {
                    $str.='<li class="'.$item['code'].'">'.anchor(slug_url($item['code'].'/'.$CI->uri->segment(2), 'page_m'), $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
            }
            else if($CI->uri->segment(2) != '')
            {
                if($active)
                {
                    $str.='<li class="'.$item['code'].' active">'.anchor($CI->uri->segment(1).'/'.$CI->uri->segment(2).'/'.$item['code'].'/'.$CI->uri->segment(4), $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
                else
                {
                    $str.='<li class="'.$item['code'].'">'.anchor($CI->uri->segment(1).'/'.$CI->uri->segment(2).'/'.$item['code'].'/'.$CI->uri->segment(4), $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
            }
            else
            {
                $url_lang_code = $item['code'];
                if($custom_domain_enabled)
                {
                    $url_lang_code='';
                }
                else if($default_lang_code == $item['code'])
                {
                    $url_lang_code = base_url();
                }

                if($active)
                {
                    $str.='<li class="'.$item['code'].' active">'.anchor($url_lang_code, $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
                else
                {
                    $str.='<li class="'.$item['code'].'">'.anchor($url_lang_code, $flag_icon.$item['language'], 'class="dropdown-item"').'</li>';
                }
            }
        }
        $str.='</ul>';

        $CI->config->set_item('base_url', $default_base_url);

        return $str;
    }
}

?>
<section class="header-inner">
    <div class="container-portal clearfix">
    <h3 class="hidden-xs-up"><?php echo _l('Menu');?></h3>
        <div class="logo float-md-left pull-sm-up col-md-6 col-12  text-center text-sm-left">
            <a href="{homepage_url_lang}" class="logo-top">
                <img src="<?/*php echo $website_logo_url; */?>https://immobilgolf.com/wp-content/uploads/2025/08/ImmobilGolf-Logo-White.png" width="145px" alt="{settings_websitetitle}">
                <img  class="mini-logo" src="<?php echo $website_logo_secondary_url; ?>" alt="{settings_websitetitle}">
            </a>
            <a href="{homepage_url_lang}" class="logo-bottom">
                <img src="assets/img/logo_white.png" alt="{settings_websitetitle}">
            </a>
            <div class="text-xs-right hidden-md-up menu-toggle">
                <button class="navbar-toggler navbar-toggle hidden-md-up" type="button" data-toggle="collapse" data-target="#main-menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
        </div>
        <?/*php if(config_db_item('property_subm_disabled')==FALSE):  ?>
        <div class="float-md-right pull-sm-up col-md-6 col-12 websitetitle focus-color">
            <?php if(config_db_item('enable_qs') == 1): ?>
                <a href="<?php echo site_url('fquick/submission/'.$lang_code); ?>" class="row">
                    <div class="sub-title"><?php echo _l('join us');?></div>
                    <h2 class="title"><?php echo _l('Add your listing');?></h2>
                </a>
            <?php else: ?>
                <a href="{myproperties_url}" class="row">
                    <div class="sub-title"><?php echo _l('join us');?></div>
                    <h2 class="title"><?php echo _l('Add your listing');?></h2>
                </a>
            <?php endif; ?>
        </div>
        <?php endif;*/?>
        <div class="float-md-right menu">
            <?/*php<div class="lang-manu dropdown pull-right">
                <?php
                     $lang_array = $this->language_m->get_array_by(array('is_frontend'=>1));
                     if(sw_count($lang_array) > 1):
                 ?>
                <?php
                    $flag_icon = '';
                    if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/img/flags/'.$this->data['lang_code'].'.png'))
                    {
                        $flag_icon = '<img class="flag-icon" src="'.'assets/img/flags/'.$this->data['lang_code'].'.png" alt="" />';
                    }

                    ?>
                    <button class="btn btn-secondary" type="button" id="about-us" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $flag_icon;?><span><?php echo $this->data['lang_code']; ?></span>
                        <i class='icon-dropdown'></i>
                    </button>
                    <?php
                      echo get_lang_menu($this->language_m->get_array_by(array('is_frontend'=>1)), $this->data['lang_code'], 'id="auxLanguages" class="dropdown-menu dropdown-menu-lang"');
                    ?>
                    <?php endif;?>
            </div>*/?>
            <div class="text-xs-right hidden-md-up">
                <button class="navbar-toggler navbar-toggle hidden-md-up" type="button" data-toggle="collapse" data-target="#main-menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <nav class="navbar text-color-primary">
                <!-- Links -->
                <?php
               if ( ! function_exists('get_menu_custom'))
               {
               //menu generate function
               function get_menu_custom ($array, $child = FALSE, $lang_code='en')
               {
                       $CI =& get_instance();
                       $str = '';
                       $is_logged_user = ($CI->user_m->loggedin() == TRUE);

                       $lang_menu_mobile = get_lang_menu_custom($CI->language_m->get_array_by(array('is_frontend'=>1)), $lang_code);
                       $lang_menu_mobile = '<li class="lang-menu-mobile">'.$lang_menu_mobile.'</li>';

                       if (sw_count($array)) {
                           $str .= $child == FALSE ? '<ul class="nav navbar-nav collapse navbar-toggleable-sm clearfix" id="main-menu">'.$lang_menu_mobile . PHP_EOL : '<div class="dropdown-menu" >' . PHP_EOL;
                                               $position = 0;
                               foreach ($array as $key=>$item) {
                                       $position++;

                           $active = $CI->uri->segment(2) == url_title_cro($item['id'], '-', TRUE) ? TRUE : FALSE;

                           if($position == 1 && $child == FALSE){
                               //$item['navigation_title'] = '<img src="assets/img/home-icon.png" alt="'.$item['navigation_title'].'" />';

                               if($CI->uri->segment(2) == '')
                                   $active = TRUE;
                           }

                           if($item['is_visible'] == '1')
                           if(empty($item['is_private']) || $item['is_private'] == '1' && $is_logged_user)
                                       if (isset($item['children']) && sw_count($item['children'])) {

                               $href = slug_url($lang_code.'/'.$item['id'].'/'.url_title_cro($item['navigation_title'], '-', TRUE), 'page_m');
                               if(substr($item['keywords'],0,4) == 'http')
                                   $href = $item['keywords'];

                               if(substr($item['keywords'],0,6) == 'search')
                               {
                                    $href = $href.'?'.$item['keywords'];
                                    $href = str_replace('"', '%22', $href);
                               }

                                $target = '';
                                if(substr($item['keywords'],0,4) == 'http')
                                {
                                    $href = $item['keywords'];
                                    if(substr($item['keywords'],0,10) != substr(site_url(),0,10))
                                    {
                                        $target=' target="_blank"';
                                    }
                                }

                               if($item['keywords'] == '#')
                                   $href = '#';
                                               $active_item = $active ? 'active' : '';
                                               $str .= $active ? '<li class="nav-item dropdown active">' : '<li class="nav-item dropdown">';
                                               $str .= '<a href="' . $href . '" class="nav-link dropdown-toggle '.$active_item.'" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" '.$target.'>' . $item['navigation_title'];
                                               $str .= '<i class="icon-dropdown"></i>' ;
                                               $str .= '</a>' . PHP_EOL;

                                               $str .= get_menu_custom($item['children'], TRUE, $lang_code);
                                               $str .= '</li>' . PHP_EOL;
                                       }
                                       else {

                               $href = slug_url($lang_code.'/'.$item['id'].'/'.url_title_cro($item['navigation_title'], '-', TRUE), 'page_m');
                               if(substr($item['keywords'],0,4) == 'http')
                                   $href = $item['keywords'];

                               if(substr($item['keywords'],0,6) == 'search')
                               {
                                    $href = $href.'?'.$item['keywords'];
                                    $href = str_replace('"', '%22', $href);
                               }

                                $target = '';
                                if(substr($item['keywords'],0,4) == 'http')
                                {
                                    $href = $item['keywords'];
                                    if(substr($item['keywords'],0,10) != substr(site_url(),0,10))
                                    {
                                        $target=' target="_blank"';
                                    }
                                }
                               if($item['keywords'] == '#')
                                   $href = '#';
                                            if($child){
                                               $str .= $active ? '<a href="' . $href . '" class="dropdown-item active" '.$target.'>' : '<a href="' . $href . '" class="dropdown-item" '.$target.'>';
                                               $str .= $item['navigation_title'] . '</a>';
                                            }
                                           else {
                                                $active_item = $active ? 'active' : '';
                                                $str .= $active ? '<li class="nav-item dropdown active">' : '<li class="nav-item dropdown">';
                                                $str .= '<a href="' . $href . '" class="nav-link '.$active_item.'" '.$target.'>' . $item['navigation_title'];
                                                $str .= '<div class="bottom-line color-primary"></div></a>' . PHP_EOL;
                                                $str .= '</li>' . PHP_EOL;
                                           }

                                       }
                               }
                               if($child)
                                $str .= '</div>' . PHP_EOL;
                               else
                                $str .= '</ul>' . PHP_EOL;
                       }

                       return $str;
               }
               }
               ?>
               <?php
                   $CI =& get_instance();
                   echo get_menu_custom($CI->temp_data['menu'], FALSE, $lang_code);
               ?>
            </nav>

        </div>
    </div>
</section><!-- /.menu-->
