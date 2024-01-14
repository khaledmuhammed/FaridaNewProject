<?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Coupons'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-new-element"
                       href="<?php echo e(action('Admin\CouponController@create')); ?>"><?php echo app('translator')->getFromJson('Add'); ?> <?php echo app('translator')->getFromJson('Coupon'); ?></a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->getFromJson('Code'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Type'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Amount'); ?></th>
                                <th><?php echo app('translator')->getFromJson('End Date'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Start Date'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Controller'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($coupon->id); ?></td>
                                    <td><?php echo e($coupon->code); ?></td>
                                    <td><?php echo e(__($coupon->type)); ?></td>
                                    <td><?php echo e($coupon->amount); ?></td>
                                    <td><?php echo e($coupon->end_date); ?></td>
                                    <td><?php echo e($coupon->start_date); ?></td>
                                    <td nowrap>
                                        <a class="btn btn-primary btn-xs"
                                           href="<?php echo e(action('Admin\CouponController@edit',$coupon->id)); ?>"><?php echo app('translator')->getFromJson('Edit'); ?></a>
                                        <button class="remove-model delete-model btn  btn-danger  btn-xs"
                                                data-path="coupons" data-obj="<?php echo e($coupon->id); ?>"
                                                href="javascript:void(0);"><?php echo app('translator')->getFromJson('Delete'); ?></button>
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