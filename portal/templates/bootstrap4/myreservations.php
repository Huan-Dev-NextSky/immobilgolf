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
                           {lang_Myreservations}
                        </div>
                        <div class="widget-content">
                           <div class="widget-body">
                                <?php if($this->session->flashdata('error')):?>
                                <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                                <?php endif;?>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <th>#</th>
                                    <th><?php echo lang('Dates');?></th>
                                    <!-- Dynamic generated -->
                                    <?php foreach($this->option_m->get_visible($content_language_id) as $row):?>
                                    <th data-breakpoints="xs sm md"  data-type="html"><?php echo $row->option?></th>
                                    <?php endforeach;?>
                                    <!-- End dynamic generated -->
                                    <th class="control" style="width: 120px;" data-type="html"><?php echo lang('Edit');?></th>
                                    <th class="control" data-type="html"><?php echo lang('Delete');?></th>
                                </thead>
                                <tbody>
                                    <?php if(sw_count($estates)): foreach($estates as $estate):?>
                                    <tr>
                                        <td><?php echo $estate->id?></td>
                                        <td>
                                        <?php echo anchor('frontend/viewreservation/'.$lang_code.'/'.$estate->id, date('Y-m-d', strtotime($estate->date_from)).' - '.date('Y-m-d', strtotime($estate->date_to)))?>
                                        <?php if($estate->is_confirmed == 0):?>
                                        &nbsp;<span class="label label-important"><?php echo lang_check('Not confirmed')?></span>
                                        <?php else: ?>
                                        &nbsp;<span class="label label-success"><?php echo lang_check('Confirmed')?></span>
                                        <?php endif;?>
                                        </td>
                                        <!-- Dynamic generated -->
                                        <?php foreach($this->option_m->get_visible($content_language_id) as $row):?>
                                        <td>
                                        <?php echo isset($options[$estate->property_id][$row->option_id])?$options[$estate->property_id][$row->option_id]:'-'?></td>
                                        <?php endforeach;?>
                                        <!-- End dynamic generated -->
                                        <td><?php echo anchor('frontend/viewreservation/'.$lang_code.'/'.$estate->id, '<i class="icon-shopping-cart"></i> '.lang_check('View/Pay'), array('class'=>'btn btn-info'))?></td>
                                        <td><?php if($estate->is_confirmed == 0):?><?php echo anchor('frontend/deletereservation/'.$lang_code.'/'.$estate->id, '<i class="icon-remove"></i> '.lang('Delete'), array('onclick' => 'return confirm(\''.lang_check('Are you sure?').'\')', 'class'=>'btn btn-danger'))?><?php endif;?></td>
                                    </tr>
                                    <?php endforeach;?>
                                    <?php else:?>
                                        <tr>
                                            <td colspan="20"><?php echo lang_check('No reservations available');?></td>
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
