{has_agent}
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
        $script.= 'var x = "<a href=\\"mailto:"+r+"\\" class=\"defaul-hover-primary\">"+r+"</a>";';
      else 
        $script.= 'var x = "<span>"+r+"</span>";';

      $script.= '$(this).parent().prepend(x);$(this).remove();})';
      $script = '<script>'.$script.'</script>';

      return '<span id="'.$id.'" class="'.$class.'"><span class="val_protected_mask">'.substr($str, 0, $preview_length).'xxxxxx</span> <a href="#" class="val_protected_spoiler">'.lang_check('unhide').'</a></span>'.$script;
    }
}
?>
<div class="widget widget-box box-container widget-agent">
    <div class=" media">
        <div class="agent-logo media-left media-middle" >
            <a href="{agent_url}" class='img-circle-cover'>
                <img src="{agent_image_url}" alt="<?php  _che($agent_name_surname);?>" class="img-circle">
            </a>
        </div>
        <div class="agent-details media-right media-top nome-agenzia">
            <a href="{agent_url}" class="agent-name"><?php _che($agent_name_surname);?></a>
            <span class="phone">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 16 16">
                  <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                  <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                </svg> <?php  _che($agent_phone);?>
            </span>
            <span class="email">
            <svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve" width="20px" height="20px" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:none;stroke:#ffffff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;} .st1{fill:none;stroke:#ffffff;stroke-width:2;stroke-linejoin:round;stroke-miterlimit:10;} </style> <path class="st0" d="M22.6,26c-2.2,1.5-5,2.3-8,1.9c-5.5-0.6-10-5.1-10.6-10.6C3.3,10.1,8.9,4,16,4c0.3,0,0.6,0,0.8,0 c7.5,0.5,12.4,8.3,10,15.5l0,0.1C26.3,21,25,22,23.5,22h0c-1.9,0-3.5-1.6-3.5-3.5V11"></path> <path class="st0" d="M16,21L16,21c-2.2,0-4-1.8-4-4v-2c0-2.2,1.8-4,4-4h0c2.2,0,4,1.8,4,4v2C20,19.2,18.2,21,16,21z"></path> </g></svg> <?php echo anti_spam_field($agent_mail, '');?>
            </span>
            <!-- Example to print all custom fields in list -->
            <?php //profile_cf_li(); ?>
            <!-- Example to print specific custom field with label -->
            <?php //profile_cf_single(1, TRUE); ?>
        </div>
    </div><!-- /.agent-card--> 
</div><!-- /. widget-agent -->  
{/has_agent}