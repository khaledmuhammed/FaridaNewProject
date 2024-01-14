<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="row">
            <div class="col-xs-12">
                <product-details
                        action="<?php echo e(action('Admin\ProductController@store')); ?>"
                        :manufacturers="<?php echo e($manufacturers); ?>"
                        :categories="<?php echo e($categories); ?>"
                        :properties="<?php echo e($properties); ?>"
                ></product-details>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>