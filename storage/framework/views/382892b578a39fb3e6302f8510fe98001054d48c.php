<?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Product Labels'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">
                    <a class="btn btn-success btn-new-element"
                       href="<?php echo e(action('Admin\ProductLabelController@create')); ?>"><?php echo app('translator')->getFromJson('Add'); ?> <?php echo app('translator')->getFromJson('Product Labels'); ?></a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->getFromJson('Name'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Color'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Controllers'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $productLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($productLabel->id); ?></td>
                                    <td><?php echo e($productLabel->theName); ?></td>
                                    <td><?php echo e($productLabel->color); ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"
                                                onclick="location.href='<?php echo e(action('Admin\ProductLabelController@edit',$productLabel->id)); ?>'"><?php echo app('translator')->getFromJson('Edit'); ?></button>
                                        <button class="delete-model btn btn-danger btn-xs" data-path="product-labels"
                                                data-obj="<?php echo e($productLabel->id); ?>"><?php echo app('translator')->getFromJson('Delete'); ?></button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($productLabels->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        //delete a model object
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