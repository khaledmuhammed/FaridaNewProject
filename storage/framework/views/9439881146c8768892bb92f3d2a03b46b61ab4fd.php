<?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Pages'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(Session::has('success')): ?>
    <div class="alert alert-success">
        <?php echo e(Session::get('success')); ?>

    </div>
    <div class="clearfix"></div>
<?php endif; ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-new-element pull-left"
                       href="<?php echo e(action('Admin\PageController@create')); ?>"><?php echo app('translator')->getFromJson('Add'); ?> <?php echo app('translator')->getFromJson('Page'); ?></a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->getFromJson('Title'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Controllers'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($page->id); ?></td>
                                    <td><?php echo e($page->theTitle); ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" onclick="location.href='<?php echo e(action('Admin\PageController@edit',$page->id)); ?>'"><?php echo app('translator')->getFromJson('Edit'); ?></button>
                                        <button class="delete-model btn  btn-danger  btn-xs" data-obj="<?php echo e($page->id); ?>"><?php echo app('translator')->getFromJson('Delete'); ?></button>
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