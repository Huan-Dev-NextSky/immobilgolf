<!DOCTYPE html>
<html lang="en">
<head>
    <?php _widget('head');?>
</head>

<body class="<?php _widget('custom_paletteclass');?>">
    <div class="container container-wrapper">
    <header class="header">
        <div class="top-box" data-toggle="sticky-onscroll">
            <div class="container">
                <?php _widget('header_loginmenu');?>
                <?php _widget('header_mainmenu');?>
            </div> 
        </div>
    </header><!-- /.header--> 
    
    <main class="main main-container section-color-primary" id="main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    
                    <div class="widget widget-box box-container">
                        <div class="widget-header text-uppercase">
                           {lang_Editresearch}, #<?php echo $listing['id']; ?>
                        </div>
                        <div class="widget-content">
                           <div class="widget-body">
                                <?php echo validation_errors()?>
                                <?php if($this->session->flashdata('message')):?>
                                <?php echo $this->session->flashdata('message')?>
                                <?php endif;?>
                                <?php if($this->session->flashdata('error')):?>
                                <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                                <?php endif;?>
                                <!-- Form starts.  -->
                            </div>
                            <?php echo form_open(NULL, array('class' => 'form-horizontal form-estate', 'role'=>'form'))?>                              
                                
                                <div class="control-group">
                                    <label for="inputActivated" class="control-label"><?php echo lang_check('Activated')?></label>
                                    <div class="controls">
                                         <?php echo form_checkbox('activated', '1', set_value('activated', $listing['activated']), 'id="inputActivated"')?>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label"><?php echo lang_check('Parameters')?></label>
                                    <div class="controls">
                                        <?php echo lang_check('Lang code').': '; ?><?php echo '['.strtoupper($listing['lang_code']).']'; ?><br />
                                        <?php
                                        $parameters = json_decode($listing['parameters']);
                                        foreach($parameters as $key=>$value){
                                            if(!empty($value) && $key != 'view' && $key != 'order')
                                            {
                                                if(is_array($value))
                                                {
                                                    $value = implode(', ', $value);
                                                }

                                                echo $key.': <b>'.$value.'</b><br />';
                                            }
                                        }

                                        ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                  <div class="controls">
                                    <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary"')?>
                                    <a href="<?php echo site_url('fresearch/myresearch/'.$lang_code)?>#content" class="btn btn-default" type="button"><?php echo lang('Cancel')?></a>
                                  </div>
                                </div>
                            <?php echo form_close()?>
                        </div>
                    </div> <!-- /. widget-table-->   
                </div><!-- /.center-content -->
            </div>
        </div>
    </main><!-- /.main-part--> 

    <!-- footer -->
    <?php _widget('custom_footer');?>
    <!-- /.footer --> 
</div>
<?php _widget('custom_palette');?>
<?php _widget('custom_javascript');?>
<script>
    /*
     * http://fooplugins.github.io/FooTable/docs/getting-started.html
     */    
    
    $('document').ready(function () {
        $('.footable').footable({
            "filtering": {
            "enabled": false
                  },
        });
    })
        
</script>
</body>
</html>
