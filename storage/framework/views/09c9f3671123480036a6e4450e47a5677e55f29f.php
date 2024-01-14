<?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Categories'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-new-element"
                       href="<?php echo e(action('Admin\CategoryController@create')); ?>"><?php echo app('translator')->getFromJson('Add'); ?> <?php echo app('translator')->getFromJson('Category'); ?></a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->getFromJson('Category Name'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Super Category Name'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Active?'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Featured?'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Controllers'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($category->id); ?></td>
                                    <td><?php echo e($category->theName); ?></td>
                                    <td>
                                        <?php if($category->superCategory): ?>
                                            <?php echo e($category->superCategory->theName); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($category->is_active): ?>
                                            <span class="label label-success"><?php echo app('translator')->getFromJson('Yes'); ?></span>
                                        <?php else: ?>
                                            <span class="label label-danger"><?php echo app('translator')->getFromJson('No'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($category->is_featured): ?>
                                            <span class="label label-success"><?php echo app('translator')->getFromJson('Yes'); ?></span>
                                        <?php else: ?>
                                            <span class="label label-danger"><?php echo app('translator')->getFromJson('No'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-xs"
                                           href="<?php echo e(action('Admin\CategoryController@edit',$category->id)); ?>"><?php echo app('translator')->getFromJson('Edit'); ?></a>
                                        <button class="remove-model delete-model btn  btn-danger  btn-xs"
                                                data-path="categories" data-obj="<?php echo e($category->id); ?>"
                                                href="javascript:void(0);"><?php echo app('translator')->getFromJson('Delete'); ?></button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($categories->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function () {
            $('#memoirs').DataTable()
        });
    </script>
    <script>//delete a model object
        //delete a model object
        //-- data-path : model route
        //-- data-obj : object id
        $('.delete-model').click(function (e) {
            e.preventDefault();

            let r = confirm("<?php echo app('translator')->getFromJson("Do you want to delete it ?"); ?>");
            if (r == true) {

                let object_id = $(this).data('obj');
                let path      = $(this).data('path');

                $.ajax({
                    url     : `<?php echo e(url('/')); ?>/admin/${path}/${object_id}`,
                    type    : 'POST',
                    dataType: "JSON",
                    data    : {
                        "_method": 'DELETE',
                        "_token" : '<?php echo csrf_token() ?>',
                    },
                    success : function (data) {
                        if (data.url !== 'undefined') {
                            window.location.replace(`<?php echo e(url('/')); ?>/admin/${data.url}`);
                        } else {
                            window.location.replace(`<?php echo e(url('/')); ?>/admin/${path}`);
                        }
                    },
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>