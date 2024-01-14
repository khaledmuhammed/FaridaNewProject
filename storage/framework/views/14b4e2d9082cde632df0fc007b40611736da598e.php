<?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Ratings'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th><?php echo app('translator')->getFromJson('Product Name'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Rating'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Comment'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Client Name'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Approved?'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Controller'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($rating->Product->name); ?></td>
                                    <td><?php echo e($rating->rating); ?></td>
                                    <td><?php echo e($rating->comment); ?></td>
                                    <td><?php echo e($rating->User->first_name); ?></td>
                                    <td> <?php if($rating->approved == 1): ?>
                                            <span class="label label-success"><?php echo app('translator')->getFromJson('Yes'); ?></span> <?php else: ?>
                                            <span class="label label-danger"><?php echo app('translator')->getFromJson('No'); ?></span> <?php endif; ?>
                                    </td>
                                    <td nowrap>
                                        <a class="btn btn-primary btn-xs"
                                           href="<?php echo e(action('Admin\RatingController@edit',$rating->id)); ?>"><?php echo app('translator')->getFromJson('Edit'); ?></a>
                                        <button class="remove-model delete-model btn  btn-danger  btn-xs"
                                                data-path="ratings" data-obj="<?php echo e($rating->id); ?>"
                                                href="javascript:void(0);"><?php echo app('translator')->getFromJson('Delete'); ?></button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($ratings->links()); ?>

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