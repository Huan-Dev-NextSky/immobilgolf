<div class="page-head">
      <h2 class="pull-left"><?php echo lang_check('Registration licenses')?>
          <span class="page-meta"><?php echo empty($license->id) ? lang_check('Add registration license') : lang_check('Edit registration license').' "' . $license->id.'"'?></span>
        </h2>

    <div class="bread-crumb pull-right">
      <a href="<?php echo site_url('admin/dashboard')?>"><i class="icon-home"></i> <?php echo lang('Home')?></a>
      <span class="divider">/</span>
      <a class="bread-current" href="<?php echo site_url('admin/registration_license')?>"><?php echo lang_check('Registration licenses')?></a>
    </div>

    <div class="clearfix"></div>
</div>

<div class="matter">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="widget worange">
                <div class="widget-head">
                  <div class="pull-left"><?php echo lang_check('License data')?></div>
                  <div class="widget-icons pull-right">
                    <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="widget-content">
                  <div class="padd">
                    <?php echo validation_errors()?>
                    <?php if($this->session->flashdata('message')):?>
                    <?php echo $this->session->flashdata('message')?>
                    <?php endif;?>
                    <?php if($this->session->flashdata('error')):?>
                    <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                    <?php endif;?>
                    <hr />
                    <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>
                      <div class="form-group">
                        <label class="col-lg-2 control-label"><?php echo lang_check('License name')?></label>
                        <div class="col-lg-10">
                          <?php echo form_input('license_name', set_value('license_name', $license->license_name), 'class="form-control" placeholder="'.lang_check('License name').'"')?>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-lg-2 control-label"><?php echo lang_check('Duration months')?></label>
                        <div class="col-lg-10">
                          <?php echo form_input('duration_months', set_value('duration_months', $license->duration_months), 'class="form-control" type="number" min="1" step="1" placeholder="'.lang_check('Duration months').'"')?>
                          <p class="help-block"><?php echo lang_check('Enter number of months. Must be unique.');?></p>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-lg-2 control-label"><?php echo lang_check('Price')?></label>
                        <div class="col-lg-10">
                          <?php echo form_input('price', set_value('price', $license->price), 'class="form-control" placeholder="'.lang_check('Price').'"')?>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-lg-2 control-label"><?php echo lang_check('Currency code')?></label>
                        <div class="col-lg-10">
                          <?php echo form_dropdown('currency_code', $currencies, set_value('currency_code', $license->currency_code), 'class="form-control"')?>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-lg-2 control-label"><?php echo lang_check('Active')?></label>
                        <div class="col-lg-10">
                          <?php echo form_checkbox('active', '1', set_value('active', isset($license->active) ? $license->active : 1), 'id="input_active"')?>
                        </div>
                      </div>

                      <hr />
                      <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                          <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary"')?>
                          <a href="<?php echo site_url('admin/registration_license')?>" class="btn btn-default" type="button"><?php echo lang('Cancel')?></a>
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
