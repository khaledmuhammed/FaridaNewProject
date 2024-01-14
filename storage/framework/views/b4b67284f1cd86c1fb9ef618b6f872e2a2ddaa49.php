<?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Products Properties'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <products-properties
                properties = '<?php echo json_encode($properties, 15, 512) ?>'
            ></products-properties>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>