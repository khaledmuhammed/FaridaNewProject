<?php $__env->startSection('content'); ?>
    <h1 class="text-center text-primary"><?php echo app('translator')->getFromJson('Bank Transfer Form'); ?></h1>
    <div class="row">
        <?php if($msg): ?>
            <div class="text-center">
                <?php echo $msg; ?>

            </div>
        <?php else: ?>
            <?php if($order): ?>
                <?php if($order->bankTransfer): ?>
                <div class="text-center">
                    <?php echo app('translator')->getFromJson('The bank transfer form has been submitted previously'); ?>.
                </div>
                <?php else: ?>
                <bank-transfer order_id="<?php echo e($order->id); ?>"></bank-transfer>
                <?php endif; ?>
            <?php else: ?>
            <div class="text-center">
                <?php echo app('translator')->getFromJson('Sorry! The order does not exist'); ?>.
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>