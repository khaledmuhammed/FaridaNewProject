
<?php $__env->startSection('content'); ?>
    <div class="container margin-top xs-no-padding">
        <?php if(Session::has('success')): ?>
            <sweet-modal icon="success" ref="modal" id="completeOrder">
                <h3><?php echo e(Session::get('success')); ?></h3>
                <br><br>
                <p class="col-sm-6 col-sm-offset-3">
                    <button @click="$refs.modal.close()" class="btn btn-primary btn-block">
                        <?php echo app('translator')->getFromJson('Show Order'); ?>
                    </button>
                </p>
            </sweet-modal>
        <?php endif; ?>
        <?php if(Session::has('error')): ?>
            <sweet-modal icon="error" ref="modal" id="completeOrder">
                <h3><?php echo e(Session::get('error')); ?></h3>
            </sweet-modal>
        <?php endif; ?>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-xs-12 xs-no-padding">
                <div class="box xs-no-padding">
                    <div class="box-header col-xs-12 xs-no-padding">
                        <div class="col-sm-8 col-xs-7">
                            <h4 class="float-right">#<?php echo e($order->id); ?></h4>
                            <span class="label
                            <?php if(in_array($order->currentStatus->id, [App\Models\Status::$PAYMENT_FAILED, App\Models\Status::$CANCELED, App\Models\Status::$IGNORED])): ?>
                                    label-danger
                            <?php else: ?>
                                    label-primary 
                            <?php endif; ?>
                                    float-right margin-top margin-right"><?php echo e($order->currentStatus->name_ar); ?></span>
                        </div>
                        <?php if($order->paymentMethod->id == 3): ?>
                        <div class="col-sm-2"><a href="<?php echo e($url); ?>" target="_blanck" class="btn btn-primary"><?php echo app('translator')->getFromJson('Bank Transfer Form'); ?></a></div>
                        <?php endif; ?>
                        
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <hr>
                    </div>
                    <div class="box-content col-xs-12 xs-no-padding">
                        <div class="col-sm-6">
                            <h4 class="text-primary"><?php echo app('translator')->getFromJson('Order Details'); ?></h4>
                            <table>
                                <tr>
                                    <td width="100"><b><?php echo app('translator')->getFromJson('Order Status'); ?></b></td>
                                    <td>
                                        
                                        <?php echo e($order->currentStatus->name_ar); ?>

                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100"><b><?php echo app('translator')->getFromJson('Order Date'); ?></b></td>
                                    <td><?php echo e($order->formatted_created_at); ?></td>
                                </tr>
                                <tr>
                                    <td width="100"><b><?php echo app('translator')->getFromJson('Shipping Method'); ?></b></td>
                                    <td><?php echo e($order->shipping_method); ?></td>
                                </tr>
                                <tr>
                                    <td width="100"><b><?php echo app('translator')->getFromJson('Payment Method'); ?></b></td>
                                    <td><?php echo e($order->paymentMethod->theName); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="text-primary"><?php echo app('translator')->getFromJson('Address'); ?></h4>
                            <table>
                                <tr>
                                    <td width="100"><b><?php echo app('translator')->getFromJson('Name'); ?></b></td>
                                    <td><?php echo e($order->address_owner); ?></td>
                                </tr>
                                <tr>
                                    <td width="100"><b><?php echo app('translator')->getFromJson('City'); ?></b></td>
                                    <td><?php echo e($order->city->name_ar); ?></td>
                                </tr>
                                <tr>
                                    <td width="100"><b><?php echo app('translator')->getFromJson('Address'); ?></b></td>
                                    <td><?php echo e($order->district->name_ar); ?> ، <?php echo e($order->address_details); ?></td>
                                </tr>
                                <tr>
                                    <td width="100"><b><?php echo app('translator')->getFromJson('Mobile'); ?></b></td>
                                    <td><?php echo e($order->mobile); ?></td>
                                </tr>
                                <tr>
                                    <td width="100"><b>تاريخ التوصيل</b></td>
                                    <td><?php echo e(date('F j, Y', strtotime($order->shipping_date))); ?></td>
                                </tr>
                                <tr>
                                    <td width="100"><b>وقت التوصيل</b></td>
                                    <td><?php echo e(date('g:i a', strtotime($order->shipping_time))); ?></td>
                                </tr>
                            </table>
                        </div>
                        <?php if($order->orderReceiver): ?>
                        <div class="col-sm-6">
                            <h4 class="text-primary">عنوان مستلم الطلب</h4>
                            <table>
                                <tr>
                                    <td width="100"><b><?php echo app('translator')->getFromJson('Name'); ?></b></td>
                                    <td><?php echo e($order->orderReceiver->receiver_name); ?></td>
                                </tr>
                                <tr>
                                    <td width="100"><b><?php echo app('translator')->getFromJson('City'); ?></b></td>
                                    <td><?php echo e($order->orderReceiver->city->name_ar); ?></td>
                                </tr>
                                <tr>
                                    <td width="100"><b><?php echo app('translator')->getFromJson('Address'); ?></b></td>
                                    <td><?php echo e($order->orderReceiver->district->name_ar); ?></td>
                                </tr>
                                <tr>
                                    <td width="100"><b><?php echo app('translator')->getFromJson('Mobile'); ?></b></td>
                                    <td><?php echo e($order->orderReceiver->receiver_mobile); ?></td>
                                </tr>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="box margin-top xs-no-padding">
                    <div class="box-header">
                        <div class="col-sm-12"><h4 class="text-primary"><?php echo app('translator')->getFromJson('Items'); ?></h4></div>
                    </div>
                    <div class="box-content">
                        <div class="col-sm-12">
                            <table class="table table-products">
                                <tr class="active">
                                    <th width="400"><?php echo app('translator')->getFromJson('Item'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('Price'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('Quantity'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('Discount'); ?></th>
                                    <th><?php echo app('translator')->getFromJson('Total'); ?></th>
                                </tr>
                                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($item->orderable_type === \App\Models\Product::class): ?>
                                        <tr class="visiable-lg visiable-md visiable-sm hidden-xs">
                                            <td>
                                                <div class="col-sm-4">
                                                    <?php if($item->orderable->getFirstMedia('images')): ?><a
                                                            href="/products/<?php echo e($item->orderable->slug); ?>"><img
                                                                src="<?php echo e($item->orderable->getFirstMedia('images')->getUrl()); ?>"
                                                                width="100%" class="" /></a><?php endif; ?>
                                                </div>
                                                <div class="col-sm-8 text-dark">
                                                    <p>
                                                        <a href="/products/<?php echo e($item->orderable->slug); ?>"><?php echo e($item->orderable->name); ?></a>
                                                        <?php if($item->property_value): ?>
                                                            <?php if($item->property_value->property->type == 'selection'): ?>
                                                                <span>[ <?php echo e($item->property_value->value); ?> ]</span>
                                                            <?php else: ?> 
                                                                <span style="width:25px; height:15px; border:1px solid #b9b9b9; vertical-align: middle; display:inline-block; margin:0 10px; background:<?php echo e($item->property_value->value); ?>"></span>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </p>
                                                    
                                                </div>
                                            </td>
                                            <td><?php echo e($item->unit_price); ?> <?php echo app('translator')->getFromJson('SAR'); ?></td>
                                            <td><?php echo e($item->count); ?></td>
                                            <td><?php echo e($item->discount); ?> <?php echo app('translator')->getFromJson('SAR'); ?> </td>
                                            <td><?php echo e(($item->unit_price * $item->count) - $item->discount); ?> <?php echo app('translator')->getFromJson('SAR'); ?></td>
                                        </tr>
                                        <tr class="visiable-xs hidden-lg hidden-md hidden-sm">
                                            <td colspan="5">
                                                <div class="col-xs-4 xs-no-padding">
                                                    <?php if($item->orderable->getFirstMedia('images')): ?><a
                                                            href="/products/<?php echo e($item->orderable->slug); ?>"><img
                                                                src="<?php echo e($item->orderable->getFirstMedia('images')->getUrl()); ?>"
                                                                width="100%" class="" /></a><?php endif; ?>
                                                </div>
                                                <div class="col-xs-8 text-dark">
                                                    <p>
                                                        <a href="/products/<?php echo e($item->orderable->slug); ?>"><?php echo e($item->orderable->name); ?></a>
                                                    </p>
                                                    <p><?php echo app('translator')->getFromJson('Price'); ?>: <?php echo e($item->unit_price); ?> <?php echo app('translator')->getFromJson('SAR'); ?></p>
                                                    <p><?php echo app('translator')->getFromJson('Quantity'); ?>: <?php echo e($item->count); ?></p>
                                                    <?php if($item->discount > 0): ?>
                                                    <p><?php echo app('translator')->getFromJson('Discount'); ?>: <?php echo e($item->discount); ?> <?php echo app('translator')->getFromJson('SAR'); ?></p>
                                                    <?php endif; ?>
                                                    <p><?php echo app('translator')->getFromJson('Total'); ?>: <?php echo e(($item->unit_price * $item->count) - $item->discount); ?> <?php echo app('translator')->getFromJson('SAR'); ?></p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php elseif($item->orderable_type === \App\Models\Package::class): ?>
                                        <tr class="visiable-lg visiable-md visiable-sm hidden-xs">
                                            <td>
                                                <div class="col-sm-4">
                                                    <?php if($item->orderable->thumbnail): ?>
                                                    <a href="/package/<?php echo e($item->orderable->id); ?>">
                                                        <img src="<?php echo e($item->orderable->thumbnail); ?>" width="100" class="" />
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-sm-8 text-dark">
                                                    <p>
                                                        <a href="/package/<?php echo e($item->orderable->id); ?>"><?php echo e($item->orderable->name); ?></a>
                                                    </p>
                                                    <?php if($item->intoPackageItems): ?>
                                                        <?php $__currentLoopData = $item->intoPackageItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <img src="<?php echo e($product['image']); ?>" width="60" />
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td><?php echo e($item->unit_price); ?> <?php echo app('translator')->getFromJson('SAR'); ?></td>
                                            <td><?php echo e($item->count); ?></td>
                                            <td><?php echo e($item->discount); ?> <?php echo app('translator')->getFromJson('SAR'); ?> </td>
                                            <td><?php echo e(($item->unit_price * $item->count) - $item->discount); ?> <?php echo app('translator')->getFromJson('SAR'); ?></td>
                                        </tr>
                                        <tr class="visiable-xs hidden-lg hidden-md hidden-sm">
                                            <td colspan="5">
                                                <div class="col-xs-4 xs-no-padding">
                                                    <?php if($item->orderable->thumbnail): ?>
                                                    <a href="/package/<?php echo e($item->orderable->id); ?>">
                                                        <img src="<?php echo e($item->orderable->thumbnail); ?>" width="100%" class="" />
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-xs-8 text-dark">
                                                    <p>
                                                        <a href="/package/<?php echo e($item->orderable->id); ?>"><?php echo e($item->orderable->name); ?></a>
                                                    </p>
                                                    <?php if($item->intoPackageItems): ?>
                                                        <?php $__currentLoopData = $item->intoPackageItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <img src="<?php echo e($product['image']); ?>" width="60" />
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                    <p><?php echo app('translator')->getFromJson('Price'); ?>: <?php echo e($item->unit_price); ?> <?php echo app('translator')->getFromJson('SAR'); ?></p>
                                                    <p><?php echo app('translator')->getFromJson('Quantity'); ?>: <?php echo e($item->count); ?></p>
                                                    <?php if($item->discount > 0): ?>
                                                    <p><?php echo app('translator')->getFromJson('Discount'); ?>: <?php echo e($item->discount); ?> <?php echo app('translator')->getFromJson('SAR'); ?></p>
                                                    <?php endif; ?>
                                                    <p><?php echo app('translator')->getFromJson('Total'); ?>: <?php echo e(($item->unit_price * $item->count) - $item->discount); ?> <?php echo app('translator')->getFromJson('SAR'); ?></p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr class="active">
                                    <th colspan="4"><?php echo app('translator')->getFromJson('Total Items'); ?></th>
                                    <td><?php echo e($order->items_price); ?> <?php echo app('translator')->getFromJson('SAR'); ?></td>
                                </tr>
                                <!-- <tr class="active">
                                    <th colspan="4">ضريبة القيمة المضافة</th>
                                    <td><?php echo e($order->vat); ?> ريال</td>
                                </tr> -->
                                <tr class="active">
                                    <th colspan="4"><?php echo app('translator')->getFromJson('Shipping Fee'); ?></th>
                                    <td><?php echo e($order->shipping_price); ?> <?php echo app('translator')->getFromJson('SAR'); ?></td>
                                </tr>
                                <?php if($order->payment_price > 0): ?>
                                    <tr class="active">
                                        <th colspan="4"><?php echo app('translator')->getFromJson('Cash On Delivery Fee'); ?></th>
                                        <td><?php echo e($order->payment_price); ?> <?php echo app('translator')->getFromJson('SAR'); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if(!empty($order->coupon)): ?>
                                    <tr class="active">
                                        <th colspan="4"><?php echo app('translator')->getFromJson('Discount'); ?> <small>( <?php echo app('translator')->getFromJson('Discount Code'); ?> : <?php echo e($order->coupon_code); ?> )</small></th>
                                        <td><?php echo e($order->discount); ?> <?php echo app('translator')->getFromJson('SAR'); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr class="active">
                                    <th colspan="4" class="background-primary text-white"><?php echo app('translator')->getFromJson('Final Total'); ?></th>
                                    <td class="background-primary text-white"><b><?php echo e($order->total_price); ?> <?php echo app('translator')->getFromJson('SAR'); ?></b></td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
                <?php if($order->bankTransfer): ?>
                <div class="box margin-top">
                    <div class="box-header">
                        <div class="col-sm-12"><h4><?php echo app('translator')->getFromJson('Bank Transfer Data'); ?></h4></div>
                    </div>
                    <div class="box-content">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class='table table-hover'>
                                    <tr>
                                        <th><?php echo app('translator')->getFromJson('Account Owner'); ?></th>
                                        <td><?php echo e($order->bankTransfer->account_owner); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->getFromJson('Account Number'); ?></th>
                                        <td><?php echo e($order->bankTransfer->account_number); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->getFromJson('Bank Name'); ?></th>
                                        <td><?php echo e($order->bankTransfer->bank_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->getFromJson('Amount Transferred'); ?></th>
                                        <td><?php echo e($order->bankTransfer->amount); ?> ريال</td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->getFromJson('Date'); ?></th>
                                        <td><?php echo e($order->bankTransfer->date); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo app('translator')->getFromJson('Notes'); ?></th>
                                        <td><?php echo e($order->bankTransfer->notes); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?> 
                <?php if($order->paymentMethod->id == 3): ?>
                <div class="box margin-top">
                    <div class="box-header">
                        <div class="col-sm-12"><h4>حساباتنا البنكية</h4></div>
                    </div>
                    <div class="box-content">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <p>مصرف الإنماء :</p>
                                <p>68201698498000</p>
                                <p>الآيبان : (مصرف الإنماء)</p>
                                <p>SA2405000068201698498000</p>
                                <p>مصرف الراجحي :</p>
                                <p>454000010006086033087</p>
                                <p>الآيبان : (مصرف الراجحي)</p>
                                <p>SA5880000454608016033087</p>
                                <p>(مؤسسة ورود فريدة للتجارة)</p>
                                <br/>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>