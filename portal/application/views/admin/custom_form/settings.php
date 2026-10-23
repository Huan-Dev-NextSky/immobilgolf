
    <!-- Page heading -->
    <div class="page-head">
    <!-- Page heading -->
        <h2 class="pull-left"><?php echo lang_check('Configuration')?>
		  <!-- page meta -->
		</h2>


		<!-- Breadcrumb -->
    <div class="bread-crumb pull-right">
      <a href="<?php echo site_url('admin/dashboard')?>"><i class="icon-home"></i> <?php echo lang_check('Home')?></a> 
      <!-- Divider -->
      <span class="divider">/</span> 
      <a class="bread-current" href="<?php echo site_url('admin/custom_form')?>"><?php echo lang_check('Custom form')?></a>
    </div>

		<div class="clearfix"></div>

    </div>
    <!-- Page heading ends -->



    <!-- Matter -->

    <div class="matter-settings">
    
    <div class="container">
          <div class="row">

            <div class="col-md-12">


              <div class="widget wlightblue">
                
                <div class="widget-head">
                  <div class="pull-left"><?php echo lang_check('Data')?></div>
                  <div class="widget-icons pull-right">
                    <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a> 
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="widget-content">
                  <div class="padd">
                    <?php echo validation_errors()?> 
                    <?php if($this->session->flashdata('error')):?>
                    <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                    <?php endif;?>    
                    <?php if($this->session->flashdata('message')):?>
                    <?php echo $this->session->flashdata('message')?>
                    <?php endif;?>
                    <hr />
                    <!-- Form starts.  -->
                    <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>    

                      <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang_check('Categories List')?></label>
                        <div class="col-lg-9">
                          <?php echo form_input('custom_form_categories_list', set_value('custom_form_categories_list', isset($settings['custom_form_categories_list'])?$settings['custom_form_categories_list']:''), 'class="form-control" id="inputWebTitle" placeholder="'.lang_check('Categories List').'"')?>
                          <i><?php echo lang_check('Separate by coma');?></i>
                        </div>
                      </div>
                    
                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang_check('Towns List')?></label>
                      <div class="col-lg-9">
                        <?php echo form_input('custom_form_towns_list', set_value('custom_form_towns_list', isset($settings['custom_form_towns_list'])?$settings['custom_form_towns_list']:''), 'class="form-control" id="inputAddress" placeholder="'.lang_check('Towns List').'"')?>
                        <i><?php echo lang_check('Separate by coma');?></i>
                      </div>
                    </div>

                        <hr />

                        <div class="form-group">
                          <div class="col-lg-offset-3 col-lg-9">
                            <?php echo form_submit('submit', lang_check('Save'), 'class="btn btn-primary"')?>
                            <a href="<?php echo site_url('admin/custom_form')?>" class="btn btn-default" type="button"><?php echo lang_check('Cancel')?></a>
                          </div>
                        </div>
                       <?php echo form_close()?>
                  </div>
                </div>
                  <div class="widget-foot">
                    <!-- Footer goes here -->
                  </div>
              </div>  

            </div>
     
          </div>
    
    </div>
    </div>

	<!-- Matter ends -->

   <!-- Mainbar ends -->	    	
   <div class="clearfix"></div>