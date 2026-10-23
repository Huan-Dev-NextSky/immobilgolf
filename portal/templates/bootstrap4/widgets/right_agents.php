<?php
/*
Widget-title: Agents List
Widget-preview-image: /assets/img/widgets_preview/right_agents.jpg
*/
?>

<?php
/*
 * 
 * Hidden and encoding string (for robots), add decoding btn for user
 * 
 * @param $str (string)  string for hiden
 * @param $class (string) css class`es
 * @param $preview_length (int), max preview character
 * 
 * return html string  (<div id="%id%" class="%$class%">
                            <span class="val_protected_mask">%$str%xxxxxxx</span> 
                            <a href="#" class="val_protected_spoiler">show</a>
                        </div>)
 */


if ( ! function_exists('anti_spam_field'))
{
    function anti_spam_field($str=NULL, $class='', $preview_length=2)
    { 
      if($str === NULL) return false;  
      $type ='';

      // set type mail if mail
      if(filter_var($str, FILTER_VALIDATE_EMAIL))
        $type = 'mail';

      $character_set = "+-.,0123456789@() ~!#$%^&*?ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz";

      $key = str_shuffle($character_set); 
      $cipher_text = ''; $id = 'e'.rand(1,999999999);
      for ($i=0;$i<strlen($str);$i+=1) {
        //check string and skip, if not avaible character
        if(strpos($character_set, $str[$i]) !== FALSE )
            $cipher_text.= $key[strpos($character_set,$str[$i])];
      }

      $script = '$("#'.$id.' .val_protected_spoiler").click(function(e){e.preventDefault();';
      $script.= 'var str = "'.$key.'";var length="'.$cipher_text.'";';
      $script.= 'var character_un = "'.$character_set.'";var r="";';
      $script.= 'for(var e=0;e<length.length;e++)r+=character_un.charAt(str.indexOf(length.charAt(e)));';
      $script.= '$(this).parent().find(".val_protected_mask").remove();';

      if($type == 'mail')
        $script.= 'var x = "<a class=\"defaul-hover-primary\" href=\\"mailto:"+r+"\\">"+r+"</a>";';
      else 
        $script.= 'var x = "<span>"+r+"</span>";';

      $script.= '$(this).parent().prepend(x);$(this).remove();})';
      $script = '<script>'.$script.'</script>';

      return '<span id="'.$id.'" class="'.$class.'"><span class="val_protected_mask">'.substr($str, 0, $preview_length).'xxxxxx</span> <a href="#" class="val_protected_spoiler">'.lang_check('unhide').'</a></span>'.$script;
    }
}
?>
<?php if(!empty($paginated_agents )):?>
<div class="widget  widget-agent widget-agentslist">
    <div class="widget-box">
        <h2 class="widget-header text-uppercase">
            {lang_Agents}
        </h2>
    </div>
    <!--energy version full -->

    <div class="agents-list">
        <?php foreach ($paginated_agents as $item) :?>
        <div class="widget widget-box box-container widget-agent">
            <div class=" media">
                <div class="agent-logo media-left media-middle">
                    <a href="<?php _che($item['agent_url']);?>">
                        <img src="<?php echo _simg($item['image_url'], '90x90'); ?>" alt="<?php _che($item['name_surname']);?>" class="img-circle">
                    </a>
                </div>
                <div class="agent-details media-right media-top">
                    <a href="<?php _che($item['agent_url']);?>" class="agent-name text-color-primary"><?php _che($item['name_surname']);?></a>
                    <span class="phone"><?php _che($item['phone']);?></span>
                    <?php echo anti_spam_field($item['mail']);?>

                    <!-- Example to print specific custom field with label -->
                    <?php //profile_cf_single(1, TRUE); ?>
                </div>
            </div><!-- /.agent-card--> 
        </div><!-- /. widget-agent -->  
        <?php endforeach;?>
    </div>
  <!--energy --> 
</div><!-- /. widget-energy-gas -->   
<?php endif;?>