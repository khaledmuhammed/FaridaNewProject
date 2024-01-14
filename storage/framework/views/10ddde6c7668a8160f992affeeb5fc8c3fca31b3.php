<?php $__env->startComponent('mail::message'); ?>
<tr>
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
      <center>
        <table cellspacing="0" cellpadding="0" width="600" class="w320">
          <tr>
            <td class="header-lg">
              <b><?php echo e($order->username); ?>,</b> <?php echo app('translator')->getFromJson('Thank you for ordering from'); ?> <?php echo app('translator')->getFromJson('Faridah Flowers'); ?> !
            </td>
          </tr>
          <tr>
            <td class="free-text">
              <?php echo app('translator')->getFromJson('Your order has been successfully completed,'); ?> <?php echo app('translator')->getFromJson('Order ID'); ?> <a href="">#<?php echo e($order->id); ?></a>. <?php echo app('translator')->getFromJson('Below you will find your order details'); ?>.
            </td>
          </tr>
          <tr>
            <td class="button">
              <!-- <div> -->
              <!--[if mso]>
                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://" style="height:45px;v-text-anchor:middle;width:155px;" arcsize="15%" strokecolor="#ffffff" fillcolor="#ff6f6f">
                  <w:anchorlock/>
                  <center style="color:#ffffff;font-family:Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;">Track Order</center>
                </v:roundrect>
              <![endif]-->
              <!-- <a href="http://"
              style="background-color:#ff6f6f;border-radius:5px;color:#ffffff;display:inline-block;font-family:'Cabin', Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;">Track Order</a></div> -->
            </td>
          </tr>
          <tr>
            <td class="w320">
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td class="mini-container-left" style="text-align: right;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                                <span class="header-sm"><?php echo app('translator')->getFromJson('Order Details'); ?></span><br />
                                <?php echo app('translator')->getFromJson('ID'); ?> : #<?php echo e($order->id); ?> <br />
                                <?php echo app('translator')->getFromJson('Status'); ?> : <?php echo e($order->currentStatus->theName); ?> <br />
                                <?php echo app('translator')->getFromJson('Date'); ?> : <?php echo e($order->formatted_created_at); ?> <br />
                                <?php echo app('translator')->getFromJson('Shipping Method'); ?> : <?php echo e($order->shipping_method); ?> <br />
                                <?php echo app('translator')->getFromJson('Payment Method'); ?> : <?php echo e($order->paymentMethod->theName); ?> <br />
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td class="mini-container-right">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                                <span class="header-sm"><?php echo app('translator')->getFromJson('User Information'); ?></span><br />
                                <?php echo e($order->username); ?> <br />
                                <?php echo e($order->mobile); ?>

                                <br />
                                <span class="header-sm"><?php echo app('translator')->getFromJson('Shipping Address'); ?></span> <br />
                                <?php echo e($order->address_owner); ?> <br />
                                <?php echo e($order->city->name_ar); ?> <br />
                                <?php echo e($order->address_details); ?>

                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
      <center>
        <table cellpadding="0" cellspacing="0" width="600" class="w320">
            <tr>
              <td class="item-table">
                <table cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <td class="title-dark" width="300">
                      <?php echo app('translator')->getFromJson('Items'); ?>
                    </td>
                    <td class="title-dark" width="97"  style="text-align: center;">
                      <?php echo app('translator')->getFromJson('Price'); ?>
                    </td>
                    <td class="title-dark" width="97"  style="text-align: center;">
                      <?php echo app('translator')->getFromJson('Quantity'); ?>
                    </td>
                    <td class="title-dark" width="97"  style="text-align: center;">
                      <?php echo app('translator')->getFromJson('Discount'); ?>
                    </td>
                    <td class="title-dark" width="97"  style="text-align: left;">
                      <?php echo app('translator')->getFromJson('Total'); ?>
                    </td>
                  </tr>

                  <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td class="item-col item">
                      <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td class="mobile-hide-img">
                          <?php if($item->orderable->getFirstMedia('images')): ?>
                            <img src="<?php echo e($item->orderable->getFirstMedia('images')->getUrl()); ?>">
                          <?php endif; ?>
                          </td>
                          <td class="product">
                            <span style="color: #4d4d4d; font-weight:bold;"><?php echo e($item->orderable->name); ?></span>
                            <?php if($item->property_value): ?>
                                <?php if($item->property_value->property->type == 'selection'): ?>
                                    <span>[ <?php echo e($item->property_value->value); ?> ]</span>
                                <?php else: ?> 
                                    <span style="width:25px; height:15px; border:1px solid #b9b9b9; vertical-align: middle; display:inline-block; margin:0 10px; background:<?php echo e($item->property_value->value); ?>"></span>
                                <?php endif; ?>
                            <?php endif; ?>
                            <br />
                            <?php echo e($item->orderable->product_code); ?>

                          </td>
                        </tr>
                      </table>
                    </td>
                    <td class="item-col unit_price" style="text-align: center;">
                      <?php echo e($item->unit_price); ?> <?php echo app('translator')->getFromJson('SR'); ?>
                    </td>
                    <td class="item-col quantity" style="text-align: center;">
                      <?php echo e($item->count); ?>

                    </td>
                    <td class="item-col discount" style="text-align: center;">
                      <?php echo e($item->discount); ?> <?php echo app('translator')->getFromJson('SR'); ?>
                    </td>
                    <td class="item-col" style="text-align: left;">
                      <?php echo e(($item->unit_price * $item->count) - $item->discount); ?> <?php echo app('translator')->getFromJson('SR'); ?>
                    </td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  <!-- <tr>
                    <td class="item-col item">
                      <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td class="mobile-hide-img">
                            <img src="http://s3.amazonaws.com/swu-filepicker/RPezUIwPRv8pjatAAH1E_item_images_19.jpg" alt="item1">
                          </td>
                          <td class="product">
                            <span style="color: #4d4d4d; font-weight:bold;">Golden Earings</span> <br />
                            Hot city looks
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td class="item-col quantity">
                      1
                    </td>
                    <td class="item-col">
                      $2.52
                    </td>
                  </tr>

                  <tr>
                    <td class="item-col item">
                      <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td class="mobile-hide-img">
                            <img src="http://s3.amazonaws.com/swu-filepicker/9wRy50HQTg2CTyZA5Ozi_item_images_16.jpg" alt="item2">
                          </td>
                          <td class="product">
                            <span style="color: #4d4d4d; font-weight: bold;">Pink Shoes</span> <br />
                            Newest styles
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td class="item-col quantity">
                      1
                    </td>
                    <td class="item-col price">
                      $10.50
                    </td>
                  </tr> -->


                  <tr>
                    <td class="item-col item mobile-row-padding"></td>
                    <td class="item-col unit_price"></td>
                    <td class="item-col quantity"></td>
                    <td class="item-col discount"></td>
                    <td class="item-col total"></td>
                  </tr>


                  <tr>
                    <td class="item-col item">
                    </td>
                    <td colspan="2" class="item-col discount" style="text-align:right; padding-right: 10px; border-top: 1px solid #cccccc;">
                      <span class="total-space"><?php echo app('translator')->getFromJson('Total Items'); ?></span> <br />
                      <?php if(!empty($order->coupon)): ?>
                      <span class="total-space"><?php echo app('translator')->getFromJson('Discount'); ?></span>  <br />
                      <?php endif; ?>
                      <!-- <span class="total-space">ضريبة القيمة المضافة</span> <br /> -->
                      <span class="total-space"><?php echo app('translator')->getFromJson('Shipping Fee'); ?></span>  <br />
                      <span class="total-space" style="font-weight: bold; color: #4d4d4d"><?php echo app('translator')->getFromJson('Total'); ?></span>
                    </td>
                    <td colspan="2" class="item-col total" style="text-align: left; border-top: 1px solid #cccccc;">
                      <span class="total-space"><?php echo e($order->items_price); ?> <?php echo app('translator')->getFromJson('SAR'); ?></span> <br />
                      <?php if(!empty($order->coupon)): ?>
                      <span class="total-space">- <?php echo e($order->discount); ?> <?php echo app('translator')->getFromJson('SAR'); ?></span>  <br />
                      <?php endif; ?>
                      <!-- <span class="total-space"><?php echo e($order->vat); ?> <?php echo app('translator')->getFromJson('SAR'); ?></span>  <br /> -->
                      <span class="total-space"><?php echo e($order->shipping_price); ?> <?php echo app('translator')->getFromJson('SAR'); ?></span>  <br />
                      <span class="total-space" style="font-weight:bold; color: #4d4d4d"><?php echo e($order->total_price); ?> <?php echo app('translator')->getFromJson('SAR'); ?></span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

        </table>
      </center>
    </td>
  </tr>
<?php echo $__env->renderComponent(); ?>