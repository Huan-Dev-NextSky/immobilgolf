<?php
/*
Widget-title: Default Content
Widget-preview-image: /assets/img/widgets_preview/bottom_defaultcontent.jpg
*/
?>

<?php 
if(!function_exists('generate_alt')){
function generate_alt($html) {
    $tag = 'img';
    preg_match_all('#<'.$tag.'[^>]*>#Usi', $html, $m);
    foreach ($m[0] as $t) {
      if (stripos($tag, 'alt=') === FALSE) {
        $t1 = str_replace(array('>','/>'), ' alt="">', $t);
        $html = str_replace($t, $t1, $html);     
      }  
    }
    return $html;
  }
}
?>

<?php if(isset($page_body) && !empty($page_body)):?>
<section class="section page-body section-color-primary">
    <div class="section-title">
        <h2 class="section-title text-center"><span class=""><?php echo _l('content');?></span></h2>
    </div>
    <div class="container">
        <?php echo generate_alt($page_body);?>
    </div>
</section><!-- /.page-body --> 
<?php endif;?>
