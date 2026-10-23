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
                           <?php echo lang_check('My rates and availability'); ?>
                        </div>
                        <div class="widget-content widget-controls"> 
                            <?php echo anchor('rates/rate_edit/'.$lang_code.'#content', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add rate'), 'class="btn btn-info"')?>
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
                            <table class="table table-striped" data-sorting="true">
                                <thead>
                                    <th>#</th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php echo lang_check('From date');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php echo lang_check('To date');?></th>
                                    <th data-type="html"><?php echo lang_check('Property');?></th>
                                    <th class="control" data-type="html"><?php echo lang_check('Edit');?></th>
                                    <th class="control" data-type="html"><?php echo lang_check('Delete');?></th>
                                </thead>
                               <?php if(sw_count($listings)): foreach($listings as $listing_item):?>
                                    <tr>
                                        <td><?php echo $listing_item->id; ?></td>
                                        <td><?php echo $listing_item->date_from; ?></td>
                                        <td><?php echo $listing_item->date_to; ?></td>
                                        <td><?php echo $properties[$listing_item->property_id]; ?></td>
                                        <td><?php echo btn_edit('rates/rate_edit/'.$lang_code.'/'.$listing_item->id)?></td>
                                        <td><?php echo btn_delete('rates/rate_delete/'.$lang_code.'/'.$listing_item->id)?></td>
                                    
                                    </tr>
                                <?php endforeach;?>
                                <?php else:?>
                                    <tr>
                                    	<td colspan="20"><?php echo lang_check('We could not find any');?></td>
                                    </tr>
                                <?php endif;?>       
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
        
        $('.footable-sort').footable({
            "filtering": {
            "enabled": true
                  },
        });
    })
        
</script>
</body>
</html>
