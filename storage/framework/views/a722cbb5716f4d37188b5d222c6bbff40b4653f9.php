<?php $__env->startSection('content_header'); ?>

    <h1><?php echo app('translator')->getFromJson('Users'); ?></h1>
<?php $__env->stopSection(); ?> <?php $__env->startSection('content'); ?>
<?php if(Session::has('success')): ?>
    <div class="alert alert-success">
        <?php echo e(Session::get('success')); ?>

    </div>
    <div class="clearfix"></div>
<?php endif; ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">
                    <a class="btn btn-sm btn-success btn-lg btn-new-element"
                       href="<?php echo e(action('Admin\UserController@create')); ?>"><?php echo app('translator')->getFromJson('Add'); ?> <?php echo app('translator')->getFromJson('User'); ?></a>
                    <a class="btn btn-sm btn-default btn-lg btn-new-element pull-left"
                        href="<?php echo e(route('admin.users.export')); ?>">تصدير العملاء</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->getFromJson('Name'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Email'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Mobile'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Gender'); ?></th>
                                <th><?php echo app('translator')->getFromJson('City'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Controllers'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($user->id); ?></td>
                                    <td><?php echo e($user->name); ?></td>
                                    <td><?php echo e($user->email); ?></td>
                                    <td><?php echo e($user->mobile); ?></td>
                                    <td><?php if($user->gender == "M"): ?> <?php echo app('translator')->getFromJson('Male'); ?> <?php else: ?> <?php echo app('translator')->getFromJson('Female'); ?> <?php endif; ?></td>
                                    <td><?php echo e($user->city->name_ar); ?></td>
                                    <td nowrap>
                                        <a class="btn btn-success btn-xs"
                                           href="<?php echo e(action('Admin\UserController@edit',$user->id)); ?>"><?php echo app('translator')->getFromJson('Edit'); ?></a>
                                        <button class="delete-model btn  btn-danger  btn-xs"
                                                data-obj="<?php echo e($user->id); ?>"><?php echo app('translator')->getFromJson('Delete'); ?></button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($users->links()); ?>

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