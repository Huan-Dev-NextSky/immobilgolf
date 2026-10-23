<div class="page-head">
      <h2 class="pull-left"><?php echo lang_check('Registration coupons')?>
      <span class="page-meta"><?php echo lang_check('View all registration coupons')?></span>
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
                    <?php echo anchor('admin/registration_coupon/edit', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add registration coupon'), 'class="btn btn-primary"')?>
                </div>
            </div>
          <div class="row">
            <div class="col-md-12">
                <div class="widget worange">
                <div class="widget-head">
                  <div class="pull-left"><?php echo lang_check('Registration coupons')?></div>
                  <div class="widget-icons pull-right">
                    <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>

                  <div class="widget-content">
                    <form class="search-admin form-inline" action="<?php echo site_url($this->uri->uri_string()); ?>" method="GET" autocomplete="off">
                    <div class="form-group">
                        <input class="form-control" name="smart_search" id="smart_search" value="<?php echo set_value_GET('smart_search', '', true); ?>" placeholder="<?php echo lang_check('Id, Code Name'); ?>" type="text" />
                    </div>
                    <button type="submit" class="btn btn-default"><i class="icon icon-search"></i>&nbsp;&nbsp;<?php echo lang_check('Search'); ?></button>
                    </form>

                    <?php if($this->session->flashdata('message')):?>
                    <?php echo $this->session->flashdata('message')?>
                    <?php endif;?>
                    <?php if($this->session->flashdata('error')):?>
                    <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                    <?php endif;?>

                    <table class="table table-bordered footable">
                      <thead>
                        <tr>
                            <th><?php echo lang_check('id');?></th>
                            <th><?php echo lang_check('Code Name');?></th>
                            <th><?php echo lang_check('Coupon code');?></th>
                            <th><?php echo lang_check('Discount');?></th>
                            <th><?php echo lang_check('Quantity');?></th>
                            <th><?php echo lang_check('Used');?></th>
                            <th><?php echo lang_check('Start');?></th>
                            <th><?php echo lang_check('End');?></th>
                            <th><?php echo lang_check('Active');?></th>
                            <th class="control"><?php echo lang_check('Edit');?></th>
                            <th class="control"><?php echo lang_check('Delete');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(sw_count($coupons)): foreach($coupons as $coupon):?>
                                    <tr>
                                    	<td><?php _che($coupon->id);?></td>
                                    	<td><?php echo anchor('admin/registration_coupon/edit/'.$coupon->id, $coupon->code_name)?></td>
                                        <td><?php _che($coupon->coupon_code)?></td>
                                        <td><?php echo $this->registration_coupon_m->format_discount($coupon); ?></td>
                                        <td><?php _che($coupon->quantity)?></td>
                                        <td><?php _che($coupon->used)?></td>
                                        <td><?php _che($coupon->date_start)?></td>
                                        <td><?php _che($coupon->date_end)?></td>
                                        <td><?php echo !empty($coupon->active) ? lang_check('Yes') : lang_check('No'); ?></td>
                                    	<td><?php echo btn_edit('admin/registration_coupon/edit/'.$coupon->id)?></td>
                                    	<td><?php echo btn_delete('admin/registration_coupon/delete/'.$coupon->id)?></td>
                                    </tr>
                        <?php endforeach;?>
                        <?php else:?>
                                    <tr>
                                        <td colspan="20"><?php echo lang_check('We could not find any registration coupons')?></td>
                                    </tr>
                        <?php endif;?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
          </div>
        </div>
</div>
