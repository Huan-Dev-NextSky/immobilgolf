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
                           <?php _l('My reservations and payments'); ?>
                        </div>
                        <div class="widget-content">
                           <div class="widget-body">
                                <?php if($this->session->flashdata('message')):?>
                                <?php echo $this->session->flashdata('message')?>
                                <?php endif;?>
                                <?php if($this->session->flashdata('error')):?>
                                <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                                <?php endif;?>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <th>#</th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('From date');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('To date');?></th>
                                    <th data-type="html"><?php _l('Property');?></th>
                                    <th data-breakpoints="xs sm md" data-type="html"><?php _l('Client');?></th>
                                    <th data-type="html"><?php _l('Paid');?></th>
                                    <th data-breakpoints="xs sm md" data-type="html"><?php _l('Available');?></th>
                                </thead>
                                <?php if(sw_count($listings)): foreach($listings as $listing_item):?>
                                    <tr>
                                        <td><?php echo $listing_item->id; ?></td>
                                        <td><?php echo $listing_item->date_from; ?></td>
                                        <td><?php echo $listing_item->date_to; ?></td>
                                        <td><?php echo $properties[$listing_item->property_id]; ?></td>
                                        <td><?php echo $listing_item->buyer_username; ?></td>
                                        <td>
                                        <?php if($listing_item->total_paid == $listing_item->total_price): ?>
                                        <span class="label label-success"><?php echo $listing_item->total_paid.'/'.$listing_item->total_price.' '.$listing_item->currency_code; ?></span>
                                        <?php elseif($listing_item->total_paid > 0):?>
                                        <span class="label label-warning"><?php echo $listing_item->total_paid.'/'.$listing_item->total_price.' '.$listing_item->currency_code; ?></span>
                                        <?php else: ?>
                                        <span class="label label-default"><?php echo $listing_item->total_paid.'/'.$listing_item->total_price.' '.$listing_item->currency_code; ?></span>
                                        <?php endif; ?>
                                        </td>
                                        <td>
                                        <?php
                                            $earned = $listing_item->total_paid-$listing_item->total_paid*$listing_item->booking_fee/100;
                                            
                                            if(strtotime($listing_item->date_from)+24*60*60 < time())
                                            {
                                                echo $earned.' '.$listing_item->currency_code;
                                            }
                                            else
                                            {
                                                echo '-';
                                            }
                                         ?></td>
                                    </tr>
                                <?php endforeach;?>
                                <?php else:?>
                                    <tr>
                                    	<td colspan="20"><?php _l('We could not find any');?></td>
                                    </tr>
                                <?php endif;?>           
                            </table>
                            <div class="pagination">
                                <?php echo $pagination_links; ?>
                            </div>
                        </div>
                    </div> <!-- /. widget-table-->   
                    
                    <div class="widget widget-box box-container">
                        <div class="widget-header text-uppercase">
                           <?php _l('Last 5 withdrawal request'); ?>
                        </div>
                        <div class="widget-content widget-controls"> 
                            <span>
                            <?php _l('You can withdraw up to:'); ?>
                            <?php
                                $index=0;

                                if(sw_count($withdrawal_amounts) == 0)echo '0';

                                foreach($withdrawal_amounts as $currency=>$amount)
                                {
                                    echo '<span class="label label-success">'.$amount.' '.$currency.'</span>&nbsp;';
                                }
                            ?>
                            <?php _l('Waiting to check in pass 1 day:'); ?>
                            <?php
                                $index=0;

                                if(sw_count($pending_amounts) == 0)echo '0';

                                foreach($pending_amounts as $currency=>$amount)
                                {
                                    echo '<span class="label label-info">'.$amount.' '.$currency.'</span>&nbsp;';
                                }
                            ?>
                            </span>
                            <?php if(sw_count($withdrawal_amounts) > 0): ?>
                            <?php echo anchor('rates/make_withdrawal/'.$lang_code.'#content', '<i class="icon-briefcase icon-white"></i>&nbsp;&nbsp;'.lang_check('Make a withdrawal'), 'class="btn btn-primary pull-right" style="margin-right:5px;"')?>
                            <?php endif;?>
                        </div>
                        <div class="widget-content">
                            <table class="table table-striped">
                                <thead>
                                    <th>#</th>
                                    <th data-type="html"><?php _l('Email');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('Date requested');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('Date completed');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('Amount');?></th>
                                    <th data-type="html"><?php _l('Completed');?></th>
                                </thead>
                                <tbody>
                                    <?php if(sw_count($listings_withdrawal)): foreach($listings_withdrawal as $listing_item):?>
                                        <tr>
                                            <td><?php echo $listing_item->id_withdrawal; ?></td>
                                            <td><?php echo $listing_item->withdrawal_email; ?></td>
                                            <td><?php echo $listing_item->date_requested; ?></td>
                                            <td><?php echo $listing_item->date_completed; ?></td>
                                            <td><?php echo $listing_item->amount.' '.$listing_item->currency; ?></td>
                                            <td>
                                            <?php 
                                            if($listing_item->completed)
                                            {
                                                echo '<span class="label label-success"><i class="icon-ok icon-white"></i></span>';
                                            }
                                            else
                                            {
                                                echo '<span class="label label-important"><i class="icon-remove icon-white"></i></span>';
                                            }
                                            ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                    <?php else:?>
                                        <tr>
                                            <td colspan="20"><?php _l('We could not find any');?></td>
                                        </tr>
                                    <?php endif;?>           
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
