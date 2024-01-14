<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo e(__('Add')); ?> <?php echo e(__('Attribute Group')); ?> </h3>
                </div>
                <?php echo Form::open(['action' => 'Admin\AttributeGroupController@store','class'=>'form-horizontal']); ?>

                <?php echo e(csrf_field()); ?>

                <div class="box-body">
                    <div class="form-group <?php echo e($errors->first('name') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('name', __('Attribute Group Name'), ['class' => 'control-label col-sm-3 ']); ?>

                        <div class="col-sm-7">
                            <?php echo Form::text('name', old('name'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Attribute Group Name') ]); ?>

                            <span class="help-block"><?php echo e($errors->first('name')); ?></span>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-info btn-block btn-md"><?php echo app('translator')->getFromJson('Add'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo app('translator')->getFromJson('Attribute Group List'); ?>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->getFromJson('Name'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Controllers'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $attributeGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attributeGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($attributeGroup->id); ?></td>
                                    <td><?php echo e($attributeGroup->name); ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"
                                                onclick="location.href='<?php echo e(action('Admin\AttributeGroupController@edit',$attributeGroup->id)); ?>'"><?php echo app('translator')->getFromJson('Edit'); ?></button>
                                        <button class="remove-model delete-model btn  btn-danger  btn-xs"
                                                data-path="attributeGroups" data-obj="<?php echo e($attributeGroup->id); ?>"
                                                href="javascript:void(0);"><?php echo app('translator')->getFromJson('Delete'); ?></button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($attributeGroups->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function () {
            $('.dataTable').DataTable()
        });

    </script>
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