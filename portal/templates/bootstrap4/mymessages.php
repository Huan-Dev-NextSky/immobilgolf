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
                           <?php _l('My messages'); ?>
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
                            <table class="table table-striped footable-sort" data-sorting="true">
                                <thead>
                                    <th>#</th>
                                    <th data-type="html"><?php _l('Date');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('Mail');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('Message');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('Estate');?></th>
                                    <th class="control" data-type="html"><?php _l('Edit');?></th>
                                    <th class="control" data-type="html"><?php _l('Delete');?></th>
                                </thead>
                                <?php if(sw_count($listings)): foreach($listings as $listing_item):?>
                                    <tr>
                                        <td><?php echo $listing_item->id; ?>&nbsp;&nbsp;<?php echo $listing_item->readed == 0? '<span class="label label-warning">'.lang_check('Not readed').'</span>':''?></td>
                                        <td><?php echo $listing_item->date; ?></td>
                                        <td><?php echo $listing_item->mail; ?></td>
                                        <td><?php echo $listing_item->message; ?></td>
                                        <td><?php echo $all_estates[$listing_item->property_id]; ?></td>
                                        <td><?php echo btn_edit('fmessages/edit/'.$lang_code.'/'.$listing_item->id)?></td>
                                        <td><?php echo btn_delete('fmessages/delete/'.$lang_code.'/'.$listing_item->id)?></td>
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
