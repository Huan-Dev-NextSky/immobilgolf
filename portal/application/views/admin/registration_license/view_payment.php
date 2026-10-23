<div class="page-head">
      <h2 class="pull-left"><?php echo lang_check('Payment')?>
      <span class="page-meta"><?php echo '#'.$payment->id; ?></span>
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
            <div class="pull-left"><?php echo lang_check('Payment').' #'.$payment->id; ?></div>
            <div class="widget-icons pull-right">
              <a class="wminimize" href="#"><i class="icon-chevron-up"></i></a>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="widget-content">
            <?php
              $meta = isset($payment_meta) && is_array($payment_meta) ? $payment_meta : array();
              $user_id = !empty($meta['user_id']) ? (int) $meta['user_id'] : 0;
              $currency = !empty($payment->currency_code) ? $payment->currency_code : 'EUR';
              $months = !empty($meta['duration_months']) ? (int) $meta['duration_months'] : 0;
              $discount_amount = isset($meta['discount_amount']) ? (float) $meta['discount_amount'] : 0;
              $original_price = isset($meta['original_price']) ? (float) $meta['original_price'] : null;
            ?>
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th style="width:220px;">#</th>
                  <td><?php echo (int) $payment->id; ?></td>
                </tr>
                <tr>
                  <th><?php echo lang_check('Payer email');?></th>
                  <td><?php echo htmlspecialchars($payment->payer_email, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                  <th><?php echo lang_check('Date paid');?></th>
                  <td><?php echo htmlspecialchars($payment->date_paid, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                  <th><?php echo lang_check('Paid');?></th>
                  <td><?php echo htmlspecialchars($payment->paid.' '.$currency, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <?php if ($original_price !== null): ?>
                <tr>
                  <th><?php echo lang_check('Original price');?></th>
                  <td><?php echo htmlspecialchars(number_format($original_price, 2, '.', '').' '.$currency, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                  <th><?php echo lang_check('Gateway');?></th>
                  <td><?php echo htmlspecialchars($payment->payment_gateway, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                  <th><?php echo lang_check('Transaction id');?></th>
                  <td><?php echo htmlspecialchars($payment->txn_id, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                  <th><?php echo lang_check('Invoice num');?></th>
                  <td><?php echo htmlspecialchars($payment->invoice_num, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <?php if ($user_id): ?>
                <tr>
                  <th><?php echo lang_check('User');?></th>
                  <td><a href="<?php echo site_url('admin/user/edit/'.$user_id); ?>">#<?php echo $user_id; ?></a></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($meta['mode'])): ?>
                <tr>
                  <th><?php echo lang_check('Mode');?></th>
                  <td><?php echo htmlspecialchars(lang_check($meta['mode']), ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                  <th><?php echo lang_check('License');?></th>
                  <td>
                    <?php
                      echo htmlspecialchars(
                        !empty($meta['license_name']) ? $meta['license_name'] : (!empty($meta['license_id']) ? '#'.$meta['license_id'] : '-'),
                        ENT_QUOTES,
                        'UTF-8'
                      );
                    ?>
                  </td>
                </tr>
                <tr>
                  <th><?php echo lang_check('Duration months');?></th>
                  <td>
                    <?php
                      if ($months > 0)
                        echo (int) $months.' '.($months === 1 ? lang_check('month') : lang_check('months'));
                      else
                        echo '-';
                    ?>
                  </td>
                </tr>
                <tr>
                  <th><?php echo lang_check('Coupon code');?></th>
                  <td>
                    <?php if (!empty($meta['coupon'])): ?>
                      <strong><?php echo htmlspecialchars($meta['coupon'], ENT_QUOTES, 'UTF-8'); ?></strong>
                      <?php if (!empty($meta['coupon_discount_label'])): ?>
                        <span class="label label-info" style="margin-left:6px;"><?php echo htmlspecialchars($meta['coupon_discount_label'], ENT_QUOTES, 'UTF-8'); ?></span>
                      <?php endif; ?>
                    <?php else: ?>
                      -
                    <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <th><?php echo lang_check('Discount amount');?></th>
                  <td>
                    <?php if ($discount_amount > 0): ?>
                      <span class="label label-success">
                        -<?php echo htmlspecialchars(number_format($discount_amount, 2, '.', '').' '.$currency, ENT_QUOTES, 'UTF-8'); ?>
                      </span>
                    <?php else: ?>
                      -
                    <?php endif; ?>
                  </td>
                </tr>
              </tbody>
            </table>

            <p>
              <a class="btn btn-default" href="<?php echo site_url('admin/registration_license/payments'); ?>">
                <?php echo lang_check('Back');?>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
