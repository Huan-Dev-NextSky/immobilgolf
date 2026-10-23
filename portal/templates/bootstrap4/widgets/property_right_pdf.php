<?php if(file_exists(APPPATH.'libraries/Pdf.php')) : ?>
<a href="<?php echo site_url('api/pdf_export/'.$property_id.'/'.$lang_code) ;?>" class="btn btn-primary color-primary btn-property"><?php _l('PDF export');?></a>
<?php endif;?>