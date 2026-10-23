<div class="page-head">
    <!-- Page heading -->
      <h2 class="pull-left"><?php echo lang_check('Custom Form')?>
      <!-- page meta -->
      <span class="page-meta"><?php echo lang_check('View all requests')?></span>
    </h2>
    
    
    <!-- Breadcrumb -->
    <div class="bread-crumb pull-right">
      <a href="<?php echo site_url('admin/dashboard')?>"><i class="icon-home"></i> <?php echo lang_check('Home')?></a> 
      <!-- Divider -->
      <span class="divider">/</span> 
      <a class="bread-current" href="<?php echo site_url('admin/custom_form')?>"><?php echo lang_check('custom form')?></a>
    </div>
    
    <div class="clearfix"></div>
</div>

<div class="matter">
        <div class="container">
            <div class="row">
                <div class="col-md-12"> 
                    <?php echo anchor('admin/custom_form/edit', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add a message'), 'class="btn btn-primary"')?>
                </div>
            </div>
          <div class="row">

            <div class="col-md-12">

                <div class="widget worange">

                <div class="widget-head">
                  <div class="pull-left"><?php echo lang_check('Messages')?></div>
                  <div class="widget-icons pull-right">
                    <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a> 
                  </div>
                  <div class="clearfix"></div>
                </div>

                  <div class="widget-content">
                    <form class="search-admin form-inline" action="<?php echo site_url($this->uri->uri_string()); ?>" method="GET" autocomplete="off">

                    <div class="form-group">
                        <input class="form-control" name="smart_search" id="smart_search" value="<?php echo set_value_GET('smart_search', '', true); ?>" placeholder="<?php echo lang_check('Id, Town, Email, Category...'); ?>" type="text" />
                    </div>
                    <button type="submit" class="btn btn-default"><i class="icon icon-search"></i>&nbsp;&nbsp;<?php echo lang_check('Search'); ?></button>

                    </form>
                    <?php if($this->session->flashdata('error')):?>
                    <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                    <?php endif;?>

                    <table class="table table-bordered footable">
                      <thead>
                        <tr>
                            <th><?php echo lang_check('id');?></th>
                            <th><?php echo lang_check('Email');?></th>
                            <th><?php echo lang_check('Town');?></th>
                            <th><?php echo lang_check('Category');?></th>
                            <th><?php echo lang_check('Address');?></th>
                       
                            <th class="control"><?php echo lang_check('Edit');?></th>
                            <th class="control"><?php echo lang_check('Delete');?></th> 
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(sw_count($all_custom_forms)): foreach($all_custom_forms as $custom_form):?>
                          <tr>
                            <td><?php _che($custom_form->id);?></td>
                            <td><?php _che($custom_form->email)?></td>
                            <td><?php _che($custom_form->town)?></td>
                            <td><?php _che($custom_form->category)?></td>
                            <td><?php _che($custom_form->address)?></td>
                       
                            <td><?php echo (btn_edit('admin/custom_form/edit/'.$custom_form->id))?></td>
                            <td><?php echo (btn_delete('admin/custom_form/delete/'.$custom_form->id))?></td>
                          </tr>
                        <?php endforeach;?>
                        <?php else:?>
                          <tr>
                              <td colspan="20"><?php echo lang_check('We could not find any messages')?></td>
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