<div class="page-head">
      <h2 class="pull-left"><?php echo lang_check('Registration coupons')?>
          <span class="page-meta"><?php echo empty($coupon->id) ? lang_check('Add registration coupon') : lang_check('Edit registration coupon').' "' . $coupon->code_name.'"'?></span>
    </h2>

    <div class="bread-crumb pull-right">
      <a href="<?php echo site_url('admin/dashboard')?>"><i class="icon-home"></i> <?php echo lang_check('Home')?></a>
      <span class="divider">/</span>
      <a class="bread-current" href="<?php echo site_url('admin/registration_coupon')?>"><?php echo lang_check('Registration coupons')?></a>
    </div>

    <div class="clearfix"></div>
</div>

<div class="matter">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="widget wgreen">
                <div class="widget-head">
                  <div class="pull-left"><?php echo lang_check('Coupon data')?></div>
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
                    <p class="label label-success validation"><?php echo $this->session->flashdata('message')?></p>
                    <?php endif;?>
                    <hr />
                    <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label"><?php echo lang_check('Code Name')?></label>
                                    <div class="col-lg-10">
                                        <?php echo form_input('code_name', set_value('code_name', $coupon->code_name), 'class="form-control" placeholder="'.lang_check('Code Name').'"');?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label"><?php echo lang_check('Coupon code')?></label>
                                    <div class="col-lg-10">
                                        <?php echo form_input('coupon_code', set_value('coupon_code', $coupon->coupon_code), 'class="form-control" placeholder="'.lang_check('Coupon code').'"')?>
                                    </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang_check('Discount type')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_dropdown('discount_type', $discount_types, set_value('discount_type', $coupon->discount_type), 'class="form-control" id="input_discount_type"')?>
                                  </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label"><?php echo lang_check('Discount value')?></label>
                                    <div class="col-lg-10">
                                        <?php echo form_input('discount_value', set_value('discount_value', $coupon->discount_value), 'class="form-control" placeholder="'.lang_check('Discount value').'"')?>
                                        <p class="help-block"><?php echo lang_check('For percent use 1-100. For fixed price enter the amount to subtract.');?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label"><?php echo lang_check('Quantity')?></label>
                                    <div class="col-lg-10">
                                        <?php echo form_input('quantity', set_value('quantity', $coupon->quantity), 'class="form-control" placeholder="'.lang_check('Quantity').'"')?>
                                    </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang_check('Used')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_input('used', set_value('used', isset($coupon->used)?$coupon->used:0), 'class="form-control" readonly="readonly"')?>
                                  </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label"><?php echo lang_check('Date Start')?></label>
                                    <div class="col-lg-10">
                                        <div class="input-append" id="datetimepicker1">
                                            <?php echo form_input('date_start', set_value('date_start', $coupon->date_start), 'class="picker" data-format="yyyy-MM-dd"')?>
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
                                            <?php echo form_input('date_end', set_value('date_end', $coupon->date_end), 'class="picker" data-format="yyyy-MM-dd"')?>
                                            <span class="add-on">
                                                &nbsp;<i data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang_check('Active')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_checkbox('active', '1', set_value('active', isset($coupon->active)?$coupon->active:1), 'id="input_active"')?>
                                  </div>
                                </div>

                                <hr />
                                <div class="form-group">
                                  <div class="col-lg-offset-2 col-lg-10">
                                    <?php echo form_submit('submit', lang_check('Save'), 'class="btn btn-success"')?>
                                    <a href="<?php echo site_url('admin/registration_coupon')?>" class="btn btn-primary" type="button"><?php echo lang_check('Cancel')?></a>
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
