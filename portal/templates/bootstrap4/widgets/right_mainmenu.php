<?php
/*
Widget-title: Right Main Menu
Widget-preview-image: /assets/img/widgets_preview/right_mainmenu.jpg
*/
?>
<div class="widget widget-menu-right">
    <div id="menu-right">
        
                            <?php
               if ( ! function_exists('get_menu_custom2'))
               {
               //menu generate function
               function get_menu_custom2 ($array, $child = FALSE, $lang_code='en')
               {
                       $CI =& get_instance();
                       $str = '';
                   $is_logged_user = ($CI->user_m->loggedin() == TRUE);

                       if (sw_count($array)) {
                           $str .= $child == FALSE ? '<div class="list-group panel text-color-primary border-color-primary">' . PHP_EOL : '' . PHP_EOL;
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
                                   
                               if($item['keywords'] == '#')
                                   $href = '#';
                                            $str .= $active ? '<a href="#'.url_title_cro($item['navigation_title'], '-', TRUE).'" class="list-group-item list-group-item-success active" data-toggle="collapse" data-parent="#menu-right">' : '<a href="#'.url_title_cro($item['navigation_title'], '-', TRUE).'" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#menu-right">';
                                            $str .= $item['navigation_title'];
                                            $str .= '</a>' . PHP_EOL;
                                            
                                            $str .= $active ? ' <div class="collapse" id="'.url_title_cro($item['navigation_title'], '-', TRUE).'">' : ' <div class="collapse" id="'.url_title_cro($item['navigation_title'], '-', TRUE).'">';

                                               $str .= get_menu_custom2($item['children'], TRUE, $lang_code);
                                               $str .= '</div>' . PHP_EOL;
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

                               if($item['keywords'] == '#')
                                   $href = '#';
                                            if($child){
                                               $str .= $active ? '<a href="' . $href . '" class="dropdown-item active">' : '<a href="' . $href . '" class="dropdown-item">';
                                               $str .= $item['navigation_title'] . '</a>';
                                            }
                                           else {
                                                $str .= $active ? '<a href="' . $href . '" class="list-group-item list-group-item-success active" data-parent="#menu-right">' : '<a href="' . $href . '" class="list-group-item list-group-item-success" data-parent="#menu-right">';
                                                $str .= $item['navigation_title'];
                                                $str .= '</a>' . PHP_EOL;
                                           }

                                       }
                               }
                               if($child)
                                $str .= '' . PHP_EOL;
                               else
                                $str .= '</div>' . PHP_EOL;
                       }

                       return $str;
               }
               }
               ?>
               <?php
                   $CI =& get_instance();
                   echo get_menu_custom2($CI->temp_data['menu'], FALSE, $lang_code);
               ?>
    </div>
</div><!-- /.widget-search--> 