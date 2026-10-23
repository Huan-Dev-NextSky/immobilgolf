<div class="page-head">
      <h2 class="pull-left"><?php echo lang_check('Registration licenses')?>
      <span class="page-meta"><?php echo lang_check('View all registration licenses')?></span>
    </h2>

    <div class="bread-crumb pull-right">
      <a href="<?php echo site_url('admin/dashboard')?>"><i class="icon-home"></i> <?php echo lang('Home')?></a>
      <span class="divider">/</span>
      <a class="" href="<?php echo site_url('admin/registration_license')?>"><?php echo lang_check('Registration licenses')?></a>
    </div>

    <div class="clearfix"></div>
</div>

<div class="matter">
        <div class="container">

        <div class="row">
            <div class="col-md-12">
                <?php echo anchor('admin/registration_license/edit', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add registration license'), 'class="btn btn-primary"')?>
            </div>
        </div>
          <div class="row">
            <div class="col-md-12">
                <div class="widget worange">
                <div class="widget-head">
                  <div class="pull-left"><?php echo lang_check('Registration licenses')?></div>
                  <div class="widget-icons pull-right">
                    <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>

                  <div class="widget-content">
                    <?php if($this->session->flashdata('message')):?>
                    <?php echo $this->session->flashdata('message')?>
                    <?php endif;?>
                    <?php if($this->session->flashdata('error')):?>
                    <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                    <?php endif;?>
                    <table class="table table-bordered footable">
                      <thead>
                        <tr>
                        	<th>#</th>
                            <th><?php echo lang_check('License name');?></th>
                            <th><?php echo lang_check('Duration months');?></th>
                            <th><?php echo lang_check('Price');?></th>
                            <th><?php echo lang_check('Active');?></th>
                        	<th class="control"><?php echo lang('Edit');?></th>
                        	<th class="control"><?php echo lang('Delete');?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(sw_count($licenses)): foreach($licenses as $listing):?>
                        <tr>
                        	<td><?php echo $listing->id?></td>
                            <td>
                            <a href="<?php echo site_url('admin/registration_license/edit/'.$listing->id); ?>"><?php echo $listing->license_name; ?></a>
                            </td>
                            <td>
                            <?php
                            $months = (int) $listing->duration_months;
                            echo $months.' '.($months === 1 ? lang_check('month') : lang_check('months'));
                            ?>
                            </td>
                            <td><?php echo $listing->price.(!empty($listing->currency_code) ? ' '.$listing->currency_code : ''); ?></td>
                            <td><?php echo !empty($listing->active) ? lang_check('Yes') : lang_check('No'); ?></td>
                        	<td><?php echo btn_edit('admin/registration_license/edit/'.$listing->id)?></td>
                        	<td><?php echo btn_delete('admin/registration_license/delete/'.$listing->id)?></td>
                        </tr>
                        <?php endforeach;?>
                        <?php else:?>
                        <tr>
                        	<td colspan="20"><?php echo lang('We could not find any');?></td>
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
