<?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Orders'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <script>
                function show(){
                    $('.todayOrders').css('display' , 'block');
                }
            </script>
            <button class="btn btn-block btn-success" onclick="show()" style="max-width: 200px; margin-bottom:10px">طلبات التوصيل اليوم</button>
            <div class="box todayOrders display-none" style="display: none;">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->getFromJson('Client Name'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Mobile'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Items Count'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Status'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Date'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Controllers'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($order->last_status_id == 3 && $order->shipping_date ==  Carbon\Carbon::now()->format('Y-m-d')): ?>
                                <tr>
                                    <td><?php echo e($order->id); ?></td>
                                    <td><?php echo e($order->username); ?></td>
                                    <td><?php echo e($order->mobile); ?></td>
                                    <td><?php echo e($order->orderItems->count()); ?></td>
                                    <td><?php echo e(title_case(__($order->currentStatus['name']))); ?></td>
                                    <td><?php echo e($order->created_at); ?></td>
                                    <td>
                                        <button class="btn btn-success btn-xs" onclick="location.href='<?php echo e(action('Admin\OrderController@show',$order->id)); ?>'"><?php echo app('translator')->getFromJson('Show'); ?></button>
                                        
                                    </td>
                                </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
             </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">
                    <div class="row">
                        <form action="<?php echo e(action('Admin\OrderController@index')); ?>" method="GET" class="form-inline">
                            <div class="col-sm-8">
                                <div class="pull-right">
                                    <input type="text" name="name" value="<?php echo e(Session::get('filter.name')); ?>" placeholder="اسم أو جوال العميل أو رقم الطلب" class="form-control" size="25">
                                </div>
                                <div class="pull-right">
                                <datepicker name="from"
                                        :format="$root.dateFormatter"
                                        input-class="form-control not-readonly"
                                        :language="lang.<?php echo e(app()->getLocale()); ?>"
                                        :value="dateFormatter('<?php echo e(Session::get('filter.from')); ?>')"
                                        placeholder="من تاريخ"
                                        :clear-button="true"
                                    ></datepicker>
                                </div>
                                <div class="pull-right">
                                <datepicker name="to"
                                        :format="$root.dateFormatter"
                                        input-class="form-control not-readonly"
                                        :language="lang.<?php echo e(app()->getLocale()); ?>"
                                        :value="dateFormatter('<?php echo e(Session::get('filter.to')); ?>')"
                                        placeholder="إلى تاريخ"
                                        :clear-button="true"
                                    ></datepicker>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button value="submit" type="submit" class="btn btn-block btn-success">بحث</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->getFromJson('Client Name'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Mobile'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Items Count'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Status'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Date'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Controllers'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($order->id); ?></td>
                                    <td><?php echo e($order->username); ?></td>
                                    <td><?php echo e($order->mobile); ?></td>
                                    <td><?php echo e($order->orderItems->count()); ?></td>
                                    <td><?php echo e(title_case(__($order->currentStatus['name']))); ?></td>
                                    <td><?php echo e($order->created_at); ?></td>
                                    <td>
                                        <button class="btn btn-success btn-xs" onclick="location.href='<?php echo e(action('Admin\OrderController@show',$order->id)); ?>'"><?php echo app('translator')->getFromJson('Show'); ?></button>
                                        
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($orders->appends(['name' => Session::get('filter.name'),'from' => Session::get('filter.from'),'to' => Session::get('filter.to')])->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>