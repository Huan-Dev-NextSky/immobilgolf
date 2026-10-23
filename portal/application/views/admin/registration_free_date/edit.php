<div class="page-head">
      <h2 class="pull-left"><?php echo lang_check('Register free date')?>
          <span class="page-meta"><?php echo lang_check('Free registration period settings')?></span>
    </h2>

    <div class="bread-crumb pull-right">
      <a href="<?php echo site_url('admin/dashboard')?>"><i class="icon-home"></i> <?php echo lang_check('Home')?></a>
      <span class="divider">/</span>
      <a class="bread-current" href="<?php echo site_url('admin/registration_license')?>"><?php echo lang_check('Registration licenses')?></a>
      <span class="divider">/</span>
      <a class="bread-current" href="<?php echo site_url('admin/registration_license/free_date')?>"><?php echo lang_check('Register free date')?></a>
    </div>

    <div class="clearfix"></div>
</div>

<div class="matter">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="widget wgreen">
                <div class="widget-head">
                  <div class="pull-left"><?php echo lang_check('Register free date')?></div>
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
                    <p class="help-block"><?php echo lang_check('When active and today is between Date Start and Date End, registration is free for the configured months.')?></p>
                    <hr />
                    <?php echo form_open(site_url('admin/registration_license/free_date'), array('class' => 'form-horizontal', 'role'=>'form'))?>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label"><?php echo lang_check('Date Start')?></label>
                                    <div class="col-lg-10">
                                        <div class="input-append" id="datetimepicker1">
                                            <?php echo form_input('date_start', set_value('date_start', $free_date->date_start), 'class="picker" data-format="yyyy-MM-dd"')?>
                                            <span class="add-on">
                                                &nbsp;<i data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label"><?php echo lang_check('Date End')?></label>
                                    <div class="col-lg-10">
                                        <div class="input-append" id="datetimepicker2">
                                            <?php echo form_input('date_end', set_value('date_end', $free_date->date_end), 'class="picker" data-format="yyyy-MM-dd"')?>
                                            <span class="add-on">
                                                &nbsp;<i data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label"><?php echo lang_check('Free months')?></label>
                                    <div class="col-lg-10">
                                        <?php echo form_input('free_months', set_value('free_months', $free_date->free_months), 'class="form-control" placeholder="'.lang_check('Free months').'"')?>
                                        <p class="help-block"><?php echo lang_check('Number of free registration months granted during this period.')?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang_check('Active')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_checkbox('active', '1', set_value('active', isset($free_date->active)?$free_date->active:0), 'id="input_active"')?>
                                  </div>
                                </div>

                                <hr />
                                <div class="form-group">
                                  <div class="col-lg-offset-2 col-lg-10">
                                    <?php echo form_submit('submit', lang_check('Save'), 'class="btn btn-success"')?>
                                    <a href="<?php echo site_url('admin/registration_license')?>" class="btn btn-primary" type="button"><?php echo lang_check('Cancel')?></a>
                                  </div>
                                </div>
                       <?php echo form_close()?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>
