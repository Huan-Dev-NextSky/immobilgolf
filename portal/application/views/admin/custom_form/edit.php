<div class="page-head">
  <!-- Page heading -->
  <h2 class="pull-left"><?php echo lang_check('Message') ?>
    <!-- page meta -->
    <span class="page-meta"><?php echo empty($custom_form->id) ? lang_check('Add a new message') : lang_check('Edit message') . ' "' . $custom_form->id . '"' ?></span>
  </h2>


  <!-- Breadcrumb -->
  <div class="bread-crumb pull-right">
    <a href="<?php echo site_url('admin/dashboard') ?>"><i class="icon-home"></i> <?php echo lang_check('Home') ?></a>
    <!-- Divider -->
    <span class="divider">/</span>
    <a class="bread-current" href="<?php echo site_url('admin/custom_forms') ?>"><?php echo lang_check('Message') ?></a>
  </div>

  <div class="clearfix"></div>
</div>

<div class="matter">
  <div class="container">

    <div class="row">

      <div class="col-md-12">
        <div class="widget wgreen">

          <div class="widget-head">
            <div class="pull-left"><?php echo lang_check('custom_form data') ?></div>
            <div class="widget-icons pull-right">
              <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="widget-content">
            <div class="padd">
              <?php echo validation_errors() ?>
              <?php if ($this->session->flashdata('error')): ?>
                <p class="label label-important validation"><?php echo $this->session->flashdata('error') ?></p>
              <?php endif; ?>
              <?php if ($this->session->flashdata('message')): ?>
                <p class="label label-success validation"><?php echo $this->session->flashdata('message') ?></p>
              <?php endif; ?>
              <hr />
              <!-- Form starts.  -->
              <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role' => 'form')) ?>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="inputcode_name"><?php echo lang_check('First Name') ?></label>
                <div class="col-lg-10">
                  <?php echo form_input('first_name', set_value('code_name', $custom_form->first_name), 'id="inputcode_name" class="form-control" placeholder="' . lang_check('First Name') . '"'); ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-2 control-label" for="inputlast_name"><?php echo lang_check('Last Name') ?></label>
                <div class="col-lg-10">
                  <?php echo form_input('last_name', set_value('last_name', $custom_form->last_name), 'id="inputlast_name" class="form-control" placeholder="' . lang_check('Last Name') . '"') ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-2 control-label" for="inputphone"><?php echo lang_check('Phone') ?></label>
                <div class="col-lg-10">
                  <?php echo form_input('phone', set_value('phone', $custom_form->phone), 'id="inputphone" class="form-control" placeholder="' . lang_check('Phone') . '"') ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-2 control-label" for="inputemail"><?php echo lang_check('Email') ?></label>
                <div class="col-lg-10">
                  <?php echo form_input('email', set_value('email', $custom_form->email), 'id="inputemail" class="form-control" placeholder="' . lang_check('Email') . '"') ?>
                </div>
              </div>



              <div class="form-group">
                <label class="col-lg-2 control-label" for="inputtown"><?php echo lang_check('Town') ?></label>
                <div class="col-lg-10">
                  <?php echo form_input('town', set_value('town', $custom_form->town), 'id="inputtown" class="form-control" placeholder="' . lang_check('Town') . '"') ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-2 control-label" for="inputaddress"><?php echo lang_check('Address') ?></label>
                <div class="col-lg-10">
                  <?php echo form_input('address', set_value('address', $custom_form->address), 'id="inputaddress" class="form-control" placeholder="' . lang_check('Address') . '"') ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-2 control-label" for="inputyear"><?php echo lang_check('Year') ?></label>
                <div class="col-lg-10">
                  <?php echo form_input('year', set_value('year', $custom_form->year), 'id="inputyear" class="form-control" placeholder="' . lang_check('Year') . '"') ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-2 control-label" for="inputcategory"><?php echo lang_check('Category') ?></label>
                <div class="col-lg-10">
                  <?php echo form_input('category', set_value('category', $custom_form->category), 'id="inputcategory" class="form-control" placeholder="' . lang_check('Category') . '"') ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-lg-2 control-label" for="inputmessage"><?php echo lang_check('Message') ?></label>
                <div class="col-lg-10">
                  <?php echo form_textarea('message', set_value('message', $custom_form->message), 'id="inputmessage" class="form-control" placeholder="' . lang_check('Message') . '"') ?>
                </div>
              </div>
              <?php if(!empty($custom_form->date_submit)):?>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="inputdate_submit"><?php echo lang_check('Date Submited') ?></label>
                <div class="col-lg-10">
                  <?php echo form_input('date_submit', set_value('date_submit', $custom_form->date_submit), 'id="inputdate_submit" readonly="readonly" class="form-control" placeholder="' . lang_check('Date Submited') . '"') ?>
                </div>
              </div>
              <?php endif;?>
              <div class="form-group">
                <label class="col-lg-2 control-label" for="inputReaded"><?php echo lang('Readed') ?></label>
                <div class="col-lg-10">
                  <?php echo form_checkbox('is_readed', '1', set_value('is_readed', $custom_form->is_readed), 'id="inputReaded"') ?>
                </div>
              </div>

              <hr />
              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <?php echo form_submit('submit', lang_check('Save'), 'class="btn btn-success"') ?>
                  <a href="<?php echo site_url('admin/custom_forms') ?>" class="btn btn-primary" type="button"><?php echo lang_check('Cancel') ?></a>
                </div>
              </div>
              <?php echo form_close() ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


<style>
  label {
    cursor: pointer;
  }
</style>