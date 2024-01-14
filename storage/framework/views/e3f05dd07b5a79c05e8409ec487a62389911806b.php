<?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Positions'); ?></h1>
<?php $__env->stopSection(); ?> <?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->getFromJson('English Name'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Arabic Name'); ?></th>
                                <th>#<?php echo app('translator')->getFromJson('NO. positionables'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Controller'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($position->id); ?></td>
                                    <td><?php echo e($position->name); ?></td>
                                    <td><?php echo e($position->name_ar); ?></td>
                                    <td><?php echo e($position->banners->count() + $position->featuredProducts->count()); ?></td>

                                    <td nowrap="">
                                        <a class="btn btn-primary btn-xs"
                                           href="<?php echo e(action('Admin\PositionController@edit',$position->id)); ?>"><?php echo app('translator')->getFromJson('Edit'); ?></a>
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

<?php $__env->startSection('js'); ?>
    <?php echo $__env->make('includes.delete', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>