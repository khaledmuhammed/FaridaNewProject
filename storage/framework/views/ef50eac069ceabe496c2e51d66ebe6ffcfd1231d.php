<?php $__env->startSection('content'); ?>
    <div id="category" class="container category-page">
        <div class="row">
            <div class="col-sm-12 no-padding">
                <div class="row">
                    <?php if(!empty($package)): ?>
                    <v-package ref="package" :item="<?php echo e($package); ?>"
                               :auth="<?php if(auth()->guard()->check()): ?> true <?php else: ?> false <?php endif; ?>"></v-package>
                    <?php else: ?>
                    <h3 class="text-center"><?php echo app('translator')->getFromJson('Package not available now'); ?></h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>