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
                            <?php echo $page_title; ?>
                        </div>
                        <div class="widget-content widget-controls"> 
                            <span>
                            <?php _l('You can withdraw up to:'); ?>
                            <?php
                                $index=0;
                                $currencies = array(''=>'');

                                if(sw_count($withdrawal_amounts) == 0)echo '0';

                                foreach($withdrawal_amounts as $currency=>$amount)
                                {
                                    $currencies[$currency] = $currency;
                                    echo '<span class="label label-success">'.$amount.' '.$currency.'</span>&nbsp;';
                                }
                            ?>
                            </span>
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
                            
                            <?php echo form_open(current_url().'#form-block', array('class' => 'form-horizontal form-estate', 'role'=>'form'))?>                              
                                <div class="form-group control-group row">
                                  <label class="col-xl-2 control-label"><?php _l('Amount')?></label>
                                  <div class="col-xl-10 controls">
                                  <div class="input-append">
                                    <?php echo form_input('amount', $this->input->post('amount') ? $this->input->post('amount') : '', ''); ?>
                                  </div>
                                  </div>
                                </div>

                                <div class="form-group control-group row">
                                  <label class="col-xl-2 control-label"><?php _l('Currency code')?></label>
                                  <div class="col-xl-10 controls">
                                    <?php echo form_dropdown('currency', $currencies, $this->input->post('currency') ? $this->input->post('currency') : '', 'class="form-control"')?>
                                  </div>
                                </div>

                                <div class="form-group control-group row">
                                  <label class="col-xl-2 control-label"><?php _l('Withdrawal email')?></label>
                                  <div class="col-xl-10 controls">
                                  <div class="input-append">
                                    <?php echo form_input('withdrawal_email', $this->input->post('withdrawal_email') ? $this->input->post('withdrawal_email') : '', ''); ?>
                                  </div>
                                  </div>
                                </div>

                                <div class="control-group">
                                  <div class="controls">
                                    <?php echo form_submit('submit', lang_check('Request withdrawal'), 'class="btn btn-primary"')?>
                                    <a href="<?php echo site_url('rates/payments/'.$lang_code)?>#content" class="btn btn-default" type="button"><?php echo lang_check('Cancel')?></a>
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
