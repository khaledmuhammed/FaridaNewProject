<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content_header'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="small-box bg-yellow-gradient">
                <div class="inner">
                    <h3 class="kpi-value"><?php echo e($users); ?></h3>

                    <h4><?php echo e(__('Users')); ?></h4>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-people-outline"></i>
                </div>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="small-box-footer" target="_blank">المزيد
                    <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="small-box bg-green-gradient">
                <div class="inner">
                    <h3 class="kpi-value"><?php echo e($orders); ?></h3>

                    <h4><?php echo e(__('Orders')); ?></h4>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="small-box-footer" target="_blank">المزيد
                    <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="small-box bg-blue-gradient">
                <div class="inner">
                    <h3 class="kpi-value"><?php echo e($todayOrders); ?></h3>

                    <h4><?php echo e(__('today orders')); ?></h4>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="small-box-footer" target="_blank">المزيد
                    <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="small-box bg-purple-gradient">
                <div class="inner">
                    <h3 class="kpi-value"><?php echo e($products); ?></h3>

                    <h4><?php echo e(__('products')); ?></h4>
                </div>
                <div class="icon">
                    <i class="fa fa-fw fa-cubes "></i>
                </div>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="small-box-footer" target="_blank">المزيد
                    <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <div class="box-title">
                        <b>
                            <a href="<?php echo e(route('admin.orders.index')); ?>"><?php echo e(__('Orders')); ?></a>
                        </b>
                    </div>
                    <button type="button" class="btn btn-box-tool pull-<?php echo e(__('direction_end')); ?>"
                            data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->getFromJson('Client Name'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Items Count'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Status'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Payment Method'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Controllers'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $lastOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($order->id); ?></td>
                                    <td><?php echo e($order->username); ?></td>
                                    <td><?php echo e($order->order_items_count); ?></td>
                                    <td><?php echo e(title_case(__($order->orderHistory->last()['status']['name']))); ?></td>
                                    <td><?php echo e($order->paymentMethod->theName); ?></td>
                                    <td>
                                        <button class="btn btn-success btn-xs"
                                                onclick="location.href='<?php echo e(action('Admin\OrderController@show',$order->id)); ?>'"><?php echo app('translator')->getFromJson('Show'); ?></button>
                                        
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>