<?php
/*
Widget-title: Default Content
Widget-preview-image: /assets/img/widgets_preview/bottom_defaultcontent.jpg
*/
?>

<?php if(isset($page_body) && !empty($page_body)):?>
<div class="widget widget-box widget-section box-container widget-contact-info">
    <div class="widget-header text-uppercase">
        {page_title}
    </div>
    <p>
        {page_body}
    </p>
</div>
<?php endif;?>