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
                        <div class="widget-content">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                <th class="span5">#</th>
                                    <th><?php echo lang_check('Info');?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                    <td><?php echo lang_check('Reservation id');?></td>
                                    <td>#<?php echo $reservation['id']; ?></td>
                                </tr>       
                                <tr>
                                    <td><?php echo lang_check('Dates range');?></td>
                                    <td><?php echo date('Y-m-d', strtotime($reservation['date_from'])).' - '.date('Y-m-d', strtotime($reservation['date_to'])); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang_check('Property');?></td>
                                    <td><?php echo isset($options[$reservation['property_id']][10])?'<a href="'.site_url('property/'.$reservation['property_id'].'/'.$lang_code).'">'.$options[$reservation['property_id']][10].', #'.$reservation['property_id'].'</a>':''?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang_check('Total price');?></td>
                                    <td><?php echo $reservation['total_price'].' '.$reservation['currency_code']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang_check('Total paid');?></td>
                                    <td><?php echo $reservation['total_paid'].' '.$reservation['currency_code']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang_check('Is booked');?></td>
                                    <td>
                                        <?php if($reservation['is_confirmed'] == 0):?>
                                        &nbsp;<span class="label label-important"><?php echo lang_check('Not confirmed')?></span>
                                        <?php else: ?>
                                        &nbsp;<span class="label label-success"><?php echo lang_check('Confirmed')?></span>
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <?php if($reservation['total_paid'] == 0): ?>
                                <tr>
                                    <td><?php echo lang_check('Pay advance and reservation');?>, <?php echo number_format($reservation['total_price']*0.2, 2).' '.$reservation['currency_code']; ?></td>

                                    <?php if(config_db_item('payments_enabled') == 1 && !_empty(config_db_item('paypal_email'))): ?>
                                    <td><a href="<?php echo site_url('frontend/do_purchase/'.$this->data['lang_code'].'/'.$reservation['id'].'/'.number_format($reservation['total_price']*0.2, 2)); ?>"><img style="height:36px;" src="assets/img/pay-now-paypal.png" /></a></td>
                                    <?php endif; ?>
                                    <?php if(file_exists(APPPATH.'controllers/paymentconsole.php') && config_item('stripe_enabled') !== FALSE): ?>
                                        <a href="<?php echo site_url('paymentconsole/strip_payment/'.$this->data['lang_code'].'/'.number_format($reservation['total_price']*0.2, 2).'/'.$reservation['currency_code'].'/'.$reservation['id'].'/RES'); ?>"><img style="height:36px; margin-right:10px;" src="assets/img/stripe-logo.png" alt="" /></a>
                                    <?php endif; ?>
                                </tr>
                                <?php endif; ?>
                                <?php if($reservation['total_paid'] < $reservation['total_price']): ?>
                                <tr>
                                    <td><?php echo lang_check('Pay total');?>, <?php echo number_format($reservation['total_price']-$reservation['total_paid'], 2).' '.$reservation['currency_code']; ?></td>
                                    <?php if(config_db_item('payments_enabled') == 1 && !_empty(config_db_item('paypal_email'))): ?>
                                    <td><a href="<?php echo site_url('frontend/do_purchase/'.$this->data['lang_code'].'/'.$reservation['id'].'/'.number_format($reservation['total_price']-$reservation['total_paid'], 2)); ?>"><img style="height:36px;" src="assets/img/pay-now-paypal.png" /></a></td>
                                    <?php endif; ?>
                                    <?php if(file_exists(APPPATH.'controllers/paymentconsole.php') && config_item('stripe_enabled') !== FALSE): ?>
                                        <a href="<?php echo site_url('paymentconsole/strip_payment/'.$this->data['lang_code'].'/'.number_format($reservation['total_price']-$reservation['total_paid'], 2).'/'.$reservation['currency_code'].'/'.$reservation['id'].'/RES'); ?>"><img style="height:36px; margin-right:10px;" src="assets/img/stripe-logo.png" alt="" /></a>
                                    <?php endif; ?>
                                </tr>
                                <?php endif; ?>
                              </tbody>
                            </table>
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
