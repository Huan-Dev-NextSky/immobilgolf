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
    
    <main class="main section-color-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <section class="top-title sl">
                        <h1 class="h-side-title page-title page-title-big text-color-primary">{page_title}</h1> 
                    </section>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="widget  widget-box box-container widget-form form-main" id="form">
                                <div class="widget-header">
                                    {lang_Register}
                                 </div>
                                <?php if($this->session->flashdata('error_registration') != ''):?>
                                    <p class="alert alert-success"><?php echo $this->session->flashdata('error_registration')?></p>
                                <?php endif;?>
                                <?php echo validation_errors()?>
                                <?php echo form_open(NULL, array('class' => 'form-horizontal'))?>
                                    <div class="control-group">
                                      <label class="control-label"><?php echo lang('FirstLast')?></label>
                                      <div class="controls">
                                        <?php echo form_input('name_surname', set_value('name_surname', ''), 'class="form-control" id="inputNameSurname" placeholder="'.lang('FirstLast').'"')?>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                      <label class="control-label"><?php echo lang('Username')?></label>
                                      <div class="controls">
                                        <?php echo form_input('username', set_value('username', ''), 'class="form-control" id="inputUsername" placeholder="'.lang('Username').'"')?>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                      <label class="control-label">Password</label>
                                      <div class="controls">
                                        <?php echo form_password('password', set_value('password', ''), 'class="form-control" id="inputPassword" placeholder="'.lang('Password').'" autocomplete="new-password"')?>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                      <label class="control-label"><?php echo lang('Confirmpassword')?></label>
                                      <div class="controls">
                                        <?php echo form_password('password_confirm', set_value('password_confirm', ''), 'class="form-control" id="inputPasswordConfirm" placeholder="'.lang('Confirmpassword').'" autocomplete="new-password"')?>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                      <label class="control-label"><?php echo lang('Address')?></label>
                                      <div class="controls">
                                        <?php echo form_textarea('address', set_value('address', ''), 'placeholder="'.lang('Address').'" rows="3" class="form-control"')?>
                                      </div>
                                    </div>          

                                    <div class="control-group">
                                      <label class="control-label"><?php echo lang('Phone')?></label>
                                      <div class="controls">
                                        <?php echo form_input('phone', set_value('phone', ''), 'class="form-control" id="inputPhone" placeholder="'.lang('Phone').'"')?>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                      <label class="control-label"><?php echo lang('Email')?></label>
                                      <div class="controls">
                                        <?php echo form_input('mail', set_value('mail', ''), 'class="form-control" id="inputMail" placeholder="'.lang('Email').'"')?>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" class="btn btn-danger"><?php echo lang('Register')?></button>
                                            <button type="reset" class="btn btn-success"><?php echo lang('Reset')?></button>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <a href="{front_login_url}"><i class="icon-user"></i> {lang_HaveAcc}</a>
                                        </div>
                                    </div>
                                <?php echo form_close()?>
                            </div><!-- /.widget-form--> 
                        </div> 
                        
                        <div class="col-xl-6">
                            <div class="widget  widget-box box-container widget-form form-main" id="form">
                                <div class="widget-header">
                                    {lang_ReservationInfo}
                                </div>
                                <table class="table table-striped">
                                    <tr>
                                        <td><?php echo lang_check('Dates range');?></td>
                                        <td><?php echo date('Y-m-d', strtotime($reservation['date_from'])).' - '.date('Y-m-d', strtotime($reservation['date_to'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang_check('Property');?></td>
                                        <td><?php echo isset($options[$reservation['property_id']][10])?$options[$reservation['property_id']][10].', #'.$reservation['property_id']:''?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang_check('Total price');?></td>
                                        <td><?php echo $reservation['total_price'].' '.$reservation['currency_code']; ?></td>
                                </tr>
                            </div><!-- /.widget-form--> 
                        </div>
                    </div>
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