 <?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Order'); ?> #<?php echo e($order->id); ?></h1>
<?php $__env->stopSection(); ?> <?php $__env->startSection('content'); ?>
    <div class="row">
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success">
            <?php echo e(Session::get('success')); ?>

        </div>
        <div class="clearfix"></div>
        <?php endif; ?>
        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(Session::get('error')); ?>

        </div>
        <div class="clearfix"></div>
        <?php endif; ?>
        <div class="col-xs-12">
            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                    <h2 class="page-header">
                        <img src="/imgs/logo.png" height="70" />
                        
                    </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col">
                        <h5>بيانات الطلب</h5>
                        <b>رقم الطلب :</b> #<?php echo e($order->id); ?><br>
                        <b>حالة الطلب :</b> <?php if($order->currentStatus): ?> <?php echo e($order->currentStatus->name_ar); ?> <?php endif; ?><br>
                        <b>تاريخ ووقت الطلب :</b> <?php echo e($order->created_at); ?><br>
                        <b>طريقة التوصيل :</b> <?php echo e($order->shipping_method); ?><br>
                        <b>طريقة الدفع :</b> <?php echo e($order->paymentMethod->theName); ?><br><br>
                        <?php if($order->is_gift): ?>
                            <tr>
                                <th><span class="label label-danger">أرجو عدم وضع الفاتورة مع الطلب</span></th>
                                <td></td>
                            </tr>
                            <?php endif; ?>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col">
                        <h5>بيانات العميل</h5>
                        <b>اسم العميل :</b> <?php echo e($order->username); ?><br>
                        <b>رقم الجوال :</b> <?php echo e($order->mobile); ?><br>
                        <b>البريد الإلكتروني :</b> <?php echo e($order->email); ?>

                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col">
                        <h5>العنوان</h5>
                        <b>الاسم : </b> <?php echo e($order->address_owner); ?><br>
                        <b>المدينة :</b> <?php echo e($order->city->name_ar); ?><br>
                        <b>الحي :</b> <?php echo e($order->district->name_ar); ?><br>
                       
                        <b>العنوان :</b> <?php echo e($order->address_details); ?><br>
                        <b>تاريخ التوصيل :</b> <?php echo e(date('F j, Y', strtotime($order->shipping_date))); ?><br>
                        <b>وقت التوصيل :</b> <?php echo e(date('g:i a', strtotime($order->shipping_time))); ?><br>
                    </div>
                    <!-- /.col -->
                    <?php if($order->orderReceiver): ?>
                        <div class="col-sm-3 invoice-col">
                            <h5>عنوان مستلم الطلب</h5>
                            <b>الاسم : </b> <?php echo e($order->orderReceiver->receiver_name); ?><br>
                            <b>رقم الجوال  :</b> <?php echo e($order->orderReceiver->receiver_mobile); ?><br>
                            <b>المدينة :</b> <?php echo e($order->orderReceiver->city->name_ar); ?><br>
                            <b>الحي :</b> <?php echo e($order->orderReceiver->district->name_ar); ?><br>
                           
                        </div>
                    <?php endif; ?>
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row" style="margin: 40px 0 0 0;">
                    <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th><?php echo app('translator')->getFromJson('Product Image'); ?></th>
                        <th><?php echo app('translator')->getFromJson('Product Name'); ?></th>
                        <th><?php echo app('translator')->getFromJson('Price'); ?></th>
                        <th><?php echo app('translator')->getFromJson('Quantity'); ?></th>
                        <th><?php echo app('translator')->getFromJson('Discount'); ?></th>
                        <th><?php echo app('translator')->getFromJson('Total'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i); ?></td>
                                <td>
                                    <?php if($orderItem->orderable->getMedia('images')->first()): ?>
                                    <img src="<?php echo e($orderItem->orderable->getMedia('images')->first()->getUrl()); ?>" width="100" />
                                    <?php endif; ?>
                                    
                                    <?php if($orderItem->orderable->getMedia('image')->first()): ?>
                                    <img src="<?php echo e($orderItem->orderable->getMedia('image')->first()->getUrl()); ?>" width="100" />
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e($orderItem->orderable->name); ?> 
                                    <?php if($orderItem->property_value): ?>
                                        <?php if($orderItem->property_value->property->type == 'selection'): ?>
                                            <span>[ <?php echo e($orderItem->property_value->value); ?> ]</span>
                                        <?php else: ?> 
                                            <span style="width:25px; height:15px; border:1px solid #b9b9b9; vertical-align: middle; display:inline-block; margin:0 10px; background:<?php echo e($orderItem->property_value->value); ?>"></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <br/> 
                                    <?php if($orderItem->intoPackageItems): ?>
                                        <?php $__currentLoopData = $orderItem->intoPackageItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <img src="<?php echo e($product['image']); ?>" width="60" />
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($orderItem->unit_price); ?> <?php echo app('translator')->getFromJson('SR'); ?></td>
                                <td><?php echo e($orderItem->count); ?></td>
                                <td><?php echo e($orderItem->discount); ?> <?php echo app('translator')->getFromJson('SR'); ?></td>
                                <td><?php echo e(($orderItem->unit_price * $orderItem->count) - $orderItem->discount); ?> <?php echo app('translator')->getFromJson('SR'); ?>
                                
                                    <br/><br/>
                                    <?php if($orderItem->orderable_type === \App\Models\Package::class): ?>
                                        <button type="button" class="btn" data-toggle="modal" data-target="#packageDetails<?php echo e($i); ?>">
                                            التفاصيل
                                        </button>
                                        <div class="modal fade" id="packageDetails<?php echo e($i); ?>" tabindex="-1" role="dialog" aria-labelledby="packageDetails" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="packageDetails">تفاصيل الباقة</h4>
                                                </div>
                                                <div class="modal-body">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo app('translator')->getFromJson('Product Image'); ?></th>
                                                            <th><?php echo app('translator')->getFromJson('Product Name'); ?></th>
                                                            <th><?php echo app('translator')->getFromJson('Delivery Day'); ?></th>
                                                            <th><?php echo app('translator')->getFromJson('Delivery Time'); ?></th>
                                                            <th><?php echo app('translator')->getFromJson('Delivery Date'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $j = 0; 
                                                        $orderItem->into_package = json_decode($orderItem->into_package);
                                                        ?>
                                                        <?php $__currentLoopData = $orderItem->orderable->intoPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td>
                                                                    <?php if($product->getFirstMedia('images')): ?>
                                                                    <a href="/products/<?php echo e($product->id); ?>"><img
                                                                                    src="<?php echo e($product->getFirstMedia('images')->getUrl()); ?>"
                                                                                    width="60px" class="" /></a>
                                                                    <?php endif; ?>
                                                                
                                                                </td>
                                                                <td>
                                                                    <p><a href="/products/<?php echo e($product->id); ?>"><?php echo e($product->name); ?></a>
                                                                    </p>
                                                                    <p><?php echo e($product->product_code); ?></p>
                                                                </td>
                                                                <td>
                                                                    <?php echo app('translator')->getFromJson($orderItem->into_package[$j]->delivery_day); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo e(date('g:i a', strtotime($orderItem->into_package[$j]->delivery_time))); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e(date('F j, Y', strtotime($orderItem->into_package[$j]->delivery_date))); ?>

                                                                </td>
                                                            </tr>
                                                            <?php $j++; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo app('translator')->getFromJson('Close'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                </td>                                                          
                            </tr>           
                            <?php $i++; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </tbody>
                    </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <?php if($order->notes): ?>
                <div class="row">                    
                    <div class="col-xs-12">
                        <h5>ملاحظات مع الطلب:</h5>
                        <p><?php echo e($order->notes); ?></p>
                        <hr>
                    </div>
                </div>
                <?php endif; ?>
                <div class="row">                    
                    <div class="col-xs-6">
                        <h4>الإجمالي</h4>
                        <div class="table-responsive">
                            <table class="table">
                            <tbody><tr>
                                <th style="width:50%">مجموع المنتجات :</th>
                                <td><?php echo e($order->items_price); ?> <?php echo app('translator')->getFromJson('SR'); ?></td>
                            </tr>
                            <!-- <tr>
                                <th>ضريبة القيمة المضافة :</th>
                                <td><?php echo e($order->vat); ?> <?php echo app('translator')->getFromJson('SR'); ?></td>
                            </tr> -->
                            <tr>
                                <th>التوصيل :</th>
                                <td><?php echo e($order->shipping_price); ?> <?php echo app('translator')->getFromJson('SR'); ?></td>
                            </tr>
                            <?php if($order->payment_price > 0): ?>
                                <tr>
                                    <th>رسوم الدفع عند الاستلام :</th>
                                    <td><?php echo e($order->payment_price); ?> <?php echo app('translator')->getFromJson('SR'); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if(!empty($order->coupon)): ?>
                            <tr>
                                <th>الخصم <small>( كوبون الخصم : <?php echo e($order->coupon_code); ?> )</small></th>
                                <td><?php echo e($order->discount); ?> ريال</td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <th>الإجمالي :</th>
                                <td><b><?php echo e($order->total_price); ?> <?php echo app('translator')->getFromJson('SR'); ?></b></td>
                            </tr>
                            </tbody></table>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <?php if($order->bankTransfer): ?>
                        <h4>بيانات الحوالة البنكية</h4>
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
                                    <td><?php echo e($order->bankTransfer->amount); ?> <?php echo app('translator')->getFromJson('SR'); ?></td>
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
                        <?php endif; ?>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-xs-12">
                    <!-- <a target="_blank" class="btn btn-default"><i class="fa fa-print"></i> طباعة</a> -->
                    <!-- <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                        <i class="fa fa-download"></i> Generate PDF
                    </button> -->
                    </div>
                </div>

                
                <div class="row no-print">
                    <hr>
                    <div class="col-xs-12 table-responsive">
                        <h4><?php echo app('translator')->getFromJson('Order Histories'); ?></h4>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                            <th><?php echo app('translator')->getFromJson('Order Status'); ?></th>
                            <th><?php echo app('translator')->getFromJson('Date'); ?></th>
                            <th><?php echo app('translator')->getFromJson('Notes'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $order->orderHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($history->status->name_ar); ?> <br/></td>
                                    <td><?php echo e($history->created_at); ?> </td>
                                    <td><?php echo e($history->notes); ?></td>
                                </tr>           
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12">
                        <h4><?php echo app('translator')->getFromJson('Add Order History'); ?></h4>
                        <?php echo Form::open(['action' => 'Admin\OrderController@addOrderHistory','class'=>'form-horizontal','method' => 'POST']); ?>

                        <div class="form-group <?php echo e($errors->first('status_id') ? 'has-error' :  ''); ?>">
                            <?php echo Form::label('status_id', __('Order Status'), ['class' => 'control-label col-sm-2']); ?>

                            <div class="col-sm-10">
                                <?php echo Form::select('status_id', $statuses, null, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Select') ]); ?>

                                <?php if($errors->first('status_id')): ?>
                                    <div class="help-block"><?php echo e($errors->first('status_id')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo e($errors->first('notes') ? 'has-error' :  ''); ?>">
                            <?php echo Form::label('notes', __('Notes'), ['class' => 'control-label col-sm-2']); ?>

                            <div class="col-sm-10">
                                <?php echo Form::textarea('notes', '', ['class' => 'form-control', 'placeholder'=>__('Notes') ]); ?>

                                <?php if($errors->first('notes')): ?>
                                    <div class="help-block"><?php echo e($errors->first('notes')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-sm-2 col-sm-offset-10 no-padding">
                            <button type="submit" class="btn btn-info btn-block btn-flat"><?php echo app('translator')->getFromJson('Add'); ?></button>
                        </div>
                        <?php echo Form::hidden('order_id', $order->id, ['class' => 'form-control delete_image' ]); ?>

                        <?php echo Form::close(); ?>

                    </div>
                </div>
                <!-- this row will not appear when printing -->
                
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>