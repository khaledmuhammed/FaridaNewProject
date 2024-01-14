<?php $__env->startSection('content'); ?>
    <div id="category" class="container category-page">
        <h3 class="text-center text-primary">
        <?php echo app('translator')->getFromJson('Packages'); ?>
        </h3>
        <div class="row">
            <div class="col-sm-12 no-padding">
                <div class="row">
                    <v-packages ref="packages" :items="<?php echo e($packages); ?>"
                               :auth="<?php if(auth()->guard()->check()): ?> true <?php else: ?> false <?php endif; ?>" size="3"></v-packages>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>