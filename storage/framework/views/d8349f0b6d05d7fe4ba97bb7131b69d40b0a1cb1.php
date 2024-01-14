<?php $__env->startSection('content'); ?>
    <h1 class="text-center text-primary"><?php echo e($page->theTitle); ?></h1>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-xs-12">
            <?php echo $page->theContent; ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>