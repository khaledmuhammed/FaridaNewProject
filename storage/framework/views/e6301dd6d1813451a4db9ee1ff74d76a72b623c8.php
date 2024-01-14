<?php $__env->startSection('content'); ?>
    <div id="daily-deals">
        <h3 class="text-center text-primary">
            <?php echo app('translator')->getFromJson('Wish List'); ?>
        </h3>
        <div class="container-fluid">
            <div class="row">
            <v-products ref="products" class="products" category_id="null" :items="<?php echo e($products); ?>"
                               :auth="<?php if(auth()->guard()->check()): ?> true <?php else: ?> false <?php endif; ?>" size="3"></v-products>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>