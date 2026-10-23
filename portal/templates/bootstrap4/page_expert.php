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
                    <section class="widget-blog-listing widget-overflow widget-ask" id="news">
                    
                        <div class="box-overflow-container box-container">
                            <div class="box-container-title">
                                <h2 class="title">{page_title}</h2> 
                            </div> <!-- /. content-header --> 
                            <div class="widget-content">
                                {page_body}
                                {has_page_documents}
                                <h2>{lang_Filerepository}</h2>
                                <ul>
                                {page_documents}
                                <li>
                                    <a href="{url}">{filename}</a>
                                </li>
                                {/page_documents}
                                </ul>
                                {/has_page_documents}
                            </div>
                            
                            <?php if(file_exists(APPPATH.'controllers/admin/expert.php')):?>
                            <div class="panel-group panel-content property_content_position" id="accordionThree">
                                <?php foreach($expert_module_all as $key=>$row):?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="qmark">?</i>
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordionThree" href="#collapse<?php echo $key;?>" aria-expanded="false" class="collapsed">
                                                <?php echo $row->question; ?>                                        
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse<?php echo $key;?>" class="panel-collapse collapse <?php echo ($key==0) ? 'show' : '' ;?>" aria-expanded="false" role="definition">
                                        <div class="panel-body clearfix">
                                            <?php if(!empty($row->answer_user_id) && isset($all_experts[$row->answer_user_id])): ?>
                                            <a class="image_expert" href="<?php echo site_url('profile/'.$row->answer_user_id.'/'.$lang_code); ?>#content-position">
                                                <img src="<?php echo $all_experts[$row->answer_user_id]['image_url']?>" alt="" />
                                            </a>
                                            <?php endif;?>
                                            <?php echo $row->answer; ?>                                    
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <div class="pagination news">
                                <?php echo $expert_pagination; ?>
                                </div>
                            </div>
                            <?php endif;?>
                        </div>
                    </section>
                    <?php _widget('center_imagegallery');?>
                </div><!-- /.center-content -->
                <div class="col-lg-3 sidebar">
                    <?php if(file_exists(APPPATH.'controllers/admin/expert.php')):?>
                    <div class="widget widget-search">
                        <form action="{page_current_url}">
                            <div class="input-group input-with-search color-primary clearfix">
                                <input type="text" value="" class="form-control" id="search_expert" placeholder="<?php _l('Search');?>"/>
                                <button id="btn-search_expert" type="submit" class="input-group-addon"><i class='fa fa-search fa-color-white'></i></button>
                            </div>
                        </form>
                    </div><!-- /.widget-search--> 
                    
                    <div class="widget widget-box box-container widget-menu-right">
                        <div class="widget-header text-uppercase">
                            <?php _l('Categories');?>
                        </div>
                        <div id="menu-right">
                            <div class="list-group panel text-color-primary border-color-primary">
                                 <?php foreach($categories_expert as $id=>$category_name):?>
                                    <?php if($id != 0): ?>
                                        <a href="{page_current_url}?cat=<?php echo $id; ?>#news" class="list-group-item list-group-item-success" data-parent="#menu-right"><?php echo $category_name; ?></a>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div><!-- /.widget-search--> 
                    <?php endif;?>
                    
                    <div class="widget  widget-form" id="form">
                        <form action="{page_current_url}#form" method="post">
                            <div class="box-container widget-box">
                                <div class="widget-header text-uppercaser">{lang_Enquireform}</div>
                                {validation_errors} {form_sent_message}
                                <div class="form-additional">
                                    <!-- The form name must be set so the tags identify it -->
                                    <input type="hidden" name="form" value="contact" />

                                    <div class="form-group {form_error_firstname}">
                                        <input type="text" id="firstname" name='firstname' class="form-control" placeholder="{lang_FirstLast}" value="{form_value_firstname}">
                                    </div>
                                    <div class="form-group {form_error_email}">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="{lang_Email}" value="{form_value_email}">
                                    </div>
                                    <div class="form-group {form_error_phone}">
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="{lang_Phone}" value="{form_value_phone}" >
                                    </div>
                                    <?php if(config_item( 'captcha_disabled')===FALSE): ?>
                                    <div class="form-group form-captcha {form_error_captcha}">
                                        <div class="row">
                                            <div class="col-xl-12 form-group  form-control-c">
                                                <?php echo $captcha[ 'image']; ?>
                                            </div>
                                            <div class="col-xl-12">
                                                <input class="captcha form-control {form_error_captcha}" name="captcha" type="text" placeholder="{lang_Captcha}" value="" />
                                                <input class="hidden" name="captcha_hash" type="text" value="<?php echo $captcha_hash; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="form-group {form_error_question}">
                                        <textarea id="question" name="question" rows="3" class="form-control" placeholder="{lang_Question}">{form_value_question}</textarea>
                                    </div>
                                                     
                                <?php if(config_db_item('terms_link') !== FALSE): ?>
                                <?php
                                    $site_url = site_url();
                                    $urlparts = parse_url($site_url);
                                    $basic_domain = $urlparts['host'];
                                    $terms_url = config_db_item('terms_link');
                                    $urlparts = parse_url($terms_url);
                                    $terms_domain ='';
                                    if(isset($urlparts['host']))
                                        $terms_domain = $urlparts['host'];

                                    if($terms_domain == $basic_domain) {
                                        $terms_url = str_replace('en', $lang_code, $terms_url);
                                    }
                                ?>
                                <div class="control-group control-gt-terms">
                                  <div class="controls">
                                    <?php echo form_checkbox('option_agree_terms', 'true', set_value('option_agree_terms', false), 'class="ezdisabled" id="inputOption_terms"')?>
                                  <a target="_blank" href="<?php echo $terms_url; ?>"><?php echo lang_check('I Agree To The Terms & Conditions'); ?></a>
</div>
                                </div>
                                <?php endif; ?>
                                



                                <?php if(config_db_item('privacy_link') !== FALSE && sw_count($not_logged)>0): ?>
                                                            <?php

                                $site_url = site_url();
                                $urlparts = parse_url($site_url);
                                $basic_domain = $urlparts['host'];
                                $privacy_url = config_db_item('privacy_link');
                                $urlparts = parse_url($privacy_url);
                                $privacy_domain ='';
                                if(isset($urlparts['host']))
                                    $privacy_domain = $urlparts['host'];

                                if($privacy_domain == $basic_domain) {
                                    $privacy_url = str_replace('en', $lang_code, $privacy_url);
                                }
                            ?>
                                <div class="control-group control-gt-terms">
                                  
                                  <div class="controls">
                                    <?php echo form_checkbox('option_privacy_link', 'true', set_value('option_privacy_link', false), 'class="novalidate" required="required" id="inputOption_privacy_link"')?>
                                 <a target="_blank" href="<?php echo $privacy_url; ?>"><?php echo lang_check('I Agree The Privacy'); ?></a>
 </div>
                                </div>
                                <?php endif; ?>
                                    <div class="form-group form-group-submit">
                                          <input type="submit"  class="btn btn-primary btn-wide color-primary btn-property" value="{lang_Send}" >
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.widget-form--> 
                </div>
                <!-- /.right side bar -->
            </div>
        </div>
    </main><!-- /.main-part--> 

    <!-- footer -->
    <?php _widget('custom_footer');?>
    <!-- /.footer --> 
        <script>
    $(document).ready(function(){
        $("#search_expert").keyup( function() {
            if($(this).val().length > 2 || $(this).val().length == 0)
            {
                $.post('<?php echo $ajax_expert_load_url; ?>', {search: $('#search_expert').val()}, function(data){
                    $('.property_content_position').html(data.print);
                    
                    reloadElements();
                }, "json");
            }
        });
        

    });    
    </script>
</div>
<?php _widget('custom_palette');?>
<?php _widget('custom_javascript');?>
</body>
</html>