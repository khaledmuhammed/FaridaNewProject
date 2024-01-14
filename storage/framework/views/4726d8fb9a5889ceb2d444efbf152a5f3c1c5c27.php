<?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Testimonials'); ?></h1>
<?php $__env->stopSection(); ?> <?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">
                    <a class="btn btn-sm btn-success btn-lg btn-new-element"
                       href="<?php echo e(action('Admin\TestimonialController@create')); ?>"><?php echo app('translator')->getFromJson('Add'); ?> <?php echo app('translator')->getFromJson('Testimonial'); ?></a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th width="150"><?php echo app('translator')->getFromJson('Username'); ?></th>
                                <th width="250"><?php echo app('translator')->getFromJson('Title'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Comment'); ?></th>
                                <th width="70"><?php echo app('translator')->getFromJson('Featured'); ?><?php echo app('translator')->getFromJson('?'); ?></th>
                                <th width="100"><?php echo app('translator')->getFromJson('Controller'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($testimonial->id); ?></td>
                                    <td><?php echo e($testimonial->username); ?></td>
                                    <td><?php echo e($testimonial->title); ?></td>
                                    <td><?php echo e($testimonial->comment); ?></td>
                                    <td>
                                        <?php if($testimonial->featured == 1): ?>
                                            <span class="label label-success"><?php echo app('translator')->getFromJson('Yes'); ?></span>
                                        <?php else: ?>
                                            <span class="label label-danger"><?php echo app('translator')->getFromJson('No'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"
                                                onclick="location.href='<?php echo e(action('Admin\TestimonialController@edit',$testimonial->id)); ?>'"><?php echo app('translator')->getFromJson('Edit'); ?></button>
                                        <button class="delete-model btn  btn-danger  btn-xs"
                                                data-obj="<?php echo e($testimonial->id); ?>"><?php echo app('translator')->getFromJson('Delete'); ?></button>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($testimonials->links()); ?>

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