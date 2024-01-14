<?php $__env->startSection('content'); ?>
    <div id="user-profile">
        <div class="row bg-gray-light">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <user-orders route="<?php echo e(route('latest-orders',Auth::id())); ?>" order_route="<?php echo e(route('order','')); ?>"></user-orders>
                    </div>
                    <div class="col-sm-4">
                        <div class="col-sm-12 no-padding">
                            <user-info :user="<?php echo e($user); ?>" route="<?php echo e(route('users.update',$user)); ?>"></user-info>
                        </div>
                        <div class="col-sm-12 no-padding">
                            <user-addresses :addresses="<?php echo e($addresses); ?>" route="<?php echo e(route('addresses.store')); ?>"></user-addresses>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>