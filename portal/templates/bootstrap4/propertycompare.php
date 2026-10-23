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
    
    <main class="main main-container section-color-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="h-side clearfix">
                        <div class="float-sm-left">
                            <h2 class="h-side-title page-title text-color-primary">{page_title}</h2>
                        </div>
                    </div> <!-- /. content-header --> 
                    <div class="widget widget-shadow box-container">
                        <?php if(isset($property_compare['address'])&&sw_count($property_compare['address'])>0):?>
                        <table class="table table-bordered  table-hover table-compare">
                            <thead>
                                <th></th>
                                <?php $i=1; foreach ($property_compare['url']['values'] as $k => $val):?>
                                <th>
                                    <a href='<?php _che($val); ?>'><?php echo lang_check('Estate');?>  <?php echo $i;?></a>
                                </th>
                                <?php $i++; endforeach; ?>
                            </thead>

                            <tr>
                                <?php _che($property_compare['address']['tr']);?>
                            </tr>
                            <tr>
                                <?php _che($property_compare['agent_name']['tr']);?>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo lang_check('Image');?>
                                </td>
                                <?php foreach ($property_compare['thumbnail_url']['values'] as $k => $val):?>
                                <td style="text-align:center">
                                    <img src='<?php echo _simg($val, '150x100')?>' alt=""/>
                                </td>
                                <?php endforeach; ?>
                            </tr>

                            <?php 
                            // options fetch
                            foreach ($property_compare as $field_key => $values):
                            ?>
                            <?php if(!preg_match('/^option_/', $field_key)) continue;?>
                            <?php if(isset($values['empty'])&&$values['empty']!==false) continue;?>
                            <?php /*video skip*/ if($field_key=='option_12') continue;?>
                            <tr>
                                <?php _che($values['tr']);?>
                            </tr>
                            <?php endforeach; ?>

                            <tr>
                                <td>
                                </td>
                                <?php foreach ($property_compare['url']['values'] as $k => $val):?>
                                <td>
                                    <a class="btn btn-info" href='<?php _che($val); ?>'> <?php echo lang_check('open property');?></a>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                        </table>
                        <?php endif;?>
                    </div><!-- /.our-agents -->        
                    
                    
                </div><!-- /.center-content -->
                <!-- /.right side bar -->
            </div>
        </div>
    </main><!-- /.main-part--> 

    <!-- footer -->
    <?php _widget('custom_footer');?>
    <!-- /.footer --> 
</div>
<?php _widget('custom_palette');?>
<?php _widget('custom_javascript');?>
</body>
</html>