<?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Reports'); ?> <?php echo app('translator')->getFromJson('Coupons'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->getFromJson('Code'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Usage Limit'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Controller'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($coupon->id); ?></td>
                                    <td><?php echo e($coupon->code); ?></td>
                                    <td><?php echo e($coupon->orders_count); ?></td>
                                    <td nowrap>
                                        <a class="btn btn-primary btn-xs"
                                           href="<?php echo e(action('Admin\ReportsController@couponsShow',$coupon->id)); ?>"><?php echo app('translator')->getFromJson('Show'); ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($coupons->links()); ?>

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
                        if (data.error) {
                            alert(data.error)
                        } else {

                            if (data.url !== 'undefined') {
                                window.location.replace(`<?php echo e(url('/')); ?>/admin/${data.url}`);
                            } else {
                                window.location.replace(`<?php echo e(url('/')); ?>/admin/${path}`);
                            }
                        }
                    }
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>