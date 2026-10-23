<div class="page-head">
      <h2 class="pull-left"><?php echo lang_check('Registration payments')?>
      <span class="page-meta"><?php echo lang_check('View all registration license payments')?></span>
    </h2>

    <div class="bread-crumb pull-right">
      <a href="<?php echo site_url('admin/dashboard')?>"><i class="icon-home"></i> <?php echo lang('Home')?></a>
      <span class="divider">/</span>
      <a href="<?php echo site_url('admin/registration_license')?>"><?php echo lang_check('Registration licenses')?></a>
      <span class="divider">/</span>
      <a class="bread-current" href="<?php echo site_url('admin/registration_license/payments')?>"><?php echo lang_check('Payments')?></a>
    </div>

    <div class="clearfix"></div>
</div>

<div class="matter">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="widget wviolet">
          <div class="widget-head">
            <div class="pull-left"><?php echo lang_check('Registration payments')?></div>
            <div class="widget-icons pull-right">
              <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="widget-content">
            <table class="table table-bordered footable">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?php echo lang_check('Payer email');?></th>
                  <th data-hide="phone,tablet"><?php echo lang_check('Date paid');?></th>
                  <th data-hide="phone,tablet"><?php echo lang_check('Paid');?></th>
                  <th data-hide="phone,tablet"><?php echo lang_check('Gateway');?></th>
                  <th data-hide="phone,tablet"><?php echo lang_check('Transaction id');?></th>
                  <th class="control"><?php echo lang_check('Details');?></th>
                </tr>
              </thead>
              <tbody>
                <?php if (sw_count($payments)): foreach ($payments as $item): ?>
                  <?php
                    $gateway = !empty($item->payment_gateway) ? $item->payment_gateway : '';
                    if ($gateway === 'free')
                      $gateway_label = '<span class="label label-success">'.lang_check('Free').'</span>';
                    elseif (stripos($gateway, 'stripe') !== FALSE)
                      $gateway_label = '<span class="label label-info">Stripe</span>';
                    elseif (stripos($gateway, 'paypal') !== FALSE)
                      $gateway_label = '<span class="label label-warning">PayPal</span>';
                    else
                      $gateway_label = htmlspecialchars($gateway, ENT_QUOTES, 'UTF-8');
                  ?>
                  <tr>
                    <td><?php echo (int) $item->id; ?></td>
                    <td><?php echo htmlspecialchars($item->payer_email, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item->date_paid, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item->paid.' '.$item->currency_code, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo $gateway_label; ?></td>
                    <td><?php echo htmlspecialchars($item->txn_id, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo btn_view('admin/registration_license/view_payment/'.$item->id); ?></td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr>
                    <td colspan="20"><?php echo lang('We could not find any');?></td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>

            <div style="text-align:center;"><?php echo $pagination; ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
