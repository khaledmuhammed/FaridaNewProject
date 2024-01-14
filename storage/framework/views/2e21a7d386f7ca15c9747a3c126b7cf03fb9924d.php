<?php $__env->startSection('css'); ?>
    <style>
        .img-viewer {
            width   : 200px;
            display : block;
            margin  : 10px auto;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xs-12">
        <div class="box box-info ">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo app('translator')->getFromJson('Category Edit'); ?></h3>
            </div>
            <?php echo Form::model($category, ['action' => ['Admin\CategoryController@update', $category->id], 'method' => 'put','class'=>'form-horizontal','enctype'=>'multipart/form-data']); ?>

            <div class="box-body">
                <div class="form-group <?php echo e($errors->first('name') ? 'has-error' :  ''); ?>">
                    <?php echo Form::label('name', __('Name'), ['class' => 'control-label col-sm-2']); ?>

                    <div class="col-sm-10">
                        <?php echo Form::text('name', $category->name, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Name' )]); ?> <?php if($errors->first('name')): ?>
                            <div class="help-block"><?php echo e($errors->first('name')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group <?php echo e($errors->first('name_ar') ? 'has-error' :  ''); ?>">
                    <?php echo Form::label('name_ar', __('Arabic Name'), ['class' => 'control-label col-sm-2']); ?>

                    <div class="col-sm-10">
                        <?php echo Form::text('name_ar', $category->name_ar, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Arabic Name' )]); ?> <?php if($errors->first('name_ar')): ?>
                            <div class="help-block"><?php echo e($errors->first('name_ar')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group ">
                    <?php echo Form::label('super_category_id', __('Super Category Name'), ['class' => 'control-label col-sm-2 ']); ?>

                    <div class="col-sm-10">

                        <?php echo Form::select('super_category_id',$categories,$category->super_category_id , ['placeholder' => 'select','class' => 'form-control']); ?>

                    </div>
                </div>
                <div class="col-sm-12">
                    <img class="img-viewer" src="<?php echo e($thumbnail); ?>">
                </div>

                <div class="form-group <?php echo e($errors->first('thumbnail') ? 'has-error' :  ''); ?>">
                    <?php echo Form::label('thumbnail', __('Thumbnail'), ['class' => 'control-label col-sm-2']); ?>

                    <div class="col-sm-10">
                        <?php echo Form::file('thumbnail', ['class' => 'form-control img-updater','accept'=>'image/*']); ?>

                        <?php if($errors->first('thumbnail')): ?>
                            <div class="help-block"><?php echo e($errors->first('thumbnail')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group ">
                    <?php echo Form::label('is_active', __('Is Active?'), ['class' => 'control-label col-sm-2']); ?>

                    <div class="col-sm-10">
                        <label class="radio-inline"><input type="radio" name="is_active" value="1"
                                                           required <?php echo e($category->is_active == '1'? 'checked' : ''); ?>><?php echo app('translator')->getFromJson('Yes'); ?>
                        </label>
                        &nbsp;
                        <label class="radio-inline"><input type="radio" name="is_active" value="0"
                                                           required <?php echo e($category->is_active == '0' ? 'checked' : ''); ?>><?php echo app('translator')->getFromJson('No'); ?>
                        </label>
                    </div>
                </div>
                <div class="form-group ">
                    <?php echo Form::label('is_featured', __('Is Featured?'), ['class' => 'control-label col-sm-2']); ?>

                    <div class="col-sm-10">
                        <label class="radio-inline"><input type="radio" name="is_featured" value="1"
                                                           required <?php echo e($category->is_featured == '1'? 'checked' : ''); ?>><?php echo app('translator')->getFromJson('Yes'); ?>
                        </label>
                        &nbsp;
                        <label class="radio-inline"><input type="radio" name="is_featured" value="0"
                                                           required <?php echo e($category->is_featured == '0' ? 'checked' : ''); ?>><?php echo app('translator')->getFromJson('No'); ?>
                        </label>
                    </div>
                </div>
                <div class="form-group <?php echo e($errors->first('filter_id') ? 'has-error' :  ''); ?>">
                    <?php echo Form::label('filter_id', __('Filters'), ['class' => 'control-label col-sm-2']); ?>

                    <div class="col-sm-10">
                        <?php echo Form::select('filter_id[]',$filters , $category->filters, ['placeholder' => __('select'),'class' => 'form-control','multiple']); ?>

                        <?php if($errors->first('filter_id')): ?>
                            <div class="help-block"><?php echo e($errors->first('filter_id')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-sm-2 col-sm-offset-10 no-padding">
                    <button type="submit" class="btn btn-info btn-block btn-flat"><?php echo app('translator')->getFromJson('Save'); ?></button>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>

        //remove old image preview
        $('.img-updater').change(function () {
            readURL(this, $(this).closest('.box-body').find('.img-viewer'));
        });

        function readURL(input, el) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(el).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

    </script><?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>