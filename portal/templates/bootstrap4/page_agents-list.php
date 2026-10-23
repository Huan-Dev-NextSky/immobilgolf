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
    <?php _widget('top_titlebreadcrumb2');?>
    <main class="main main-container section-color-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <?php _widget('center_agents');?>
                    <section class="widget-agents-listing widget-overflow" id="agent-search">
                    
                        <div class="box-overflow-container box-container">
                            <div class="box-container-title">
                                <h2 class="title">{page_title}</h2> 
                                <div class="sub-title">{page_body}</div>
                            </div> <!-- /. content-header --> 

                            <div class="row agents-listing">
                                <?php foreach($paginated_agents as $item): ?>
                                <div class="col-lg-6 col-xl-4">
                                    <div class="agent-card">
                                        <div class="agent-logo media-left media-middle">
                                            <a href="<?php  _che($item['agent_url']);?>" class='img-circle-cover'>
                                                <img src="<?php echo _simg($item['image_url'], '90x90'); ?>" alt="" class="img-circle">
                                            </a>
                                        </div>
                                        <div class="agent-details media-right media-top">
                                            <a href="<?php  _che($item['agent_url']);?>" class="agent-name text-color-primary" title="<?php  _che($item['name_surname']);?>"><?php  _che($item['name_surname']);?></a>
                                            <span class="phone"><?php  _che($item['phone']);?></span>
                                            <span class="mail  text-color-primary"><a href="mailto:<?php  _che($item['mail']);?>?subject=<?php echo urlencode(lang_check('Estateinqueryfor'));?>:<?php echo urlencode($page_title);?>" class="text-color-primary" title="<?php  _che($item['mail']);?>"><?php  _che($item['mail']);?></a></span>
                                        </div>
                                    </div><!-- /.agent-card--> 
                                </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                        
                        <nav class="text-xs-right">
                                 <ul class="pagination">
                                    <?php echo $agents_pagination; ?>
                                </ul>
                        </nav>
                        
                    </section>
                <?php _widget('center_ads');?> 
                </div><!-- /.center-content -->
                
                <div class="col-lg-3 sidebar">

                    <div class="widget widget-search">
                        <form action="{page_current_url}#agent-search">
                            <div class="input-group input-with-search color-primary clearfix">
                                <input  name="search-agent" type="text" value="<?php echo $this->input->get('search-agent'); ?>" class="form-control" placeholder="<?php _l('Search');?>"/>
                                <button type="submit" id="btn-search_showroom" class="input-group-addon"><i class='fa fa-search fa-color-white'></i></button>
                            </div>
                        </form>
                    </div><!-- /.widget-search--> 
                    
                  <?php _widget('right_mainmenu');?><!-- /.widget-search--> 
                  <?php _widget('right_ads');?>

                </div>
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