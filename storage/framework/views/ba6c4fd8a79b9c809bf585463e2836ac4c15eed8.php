<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo app('translator')->getFromJson('Add'); ?> <?php echo app('translator')->getFromJson('Category'); ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo Form::open(['action' => 'Admin\CategoryController@store','class'=>'form-horizontal','method' => 'POST','enctype'=>'multipart/form-data']); ?>

                <?php echo e(csrf_field()); ?>

                <div class="box-body">
                    <div class="form-group <?php echo e($errors->first('name') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('name', __('Name'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('name', old('name'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Name' )]); ?>

                            <?php if($errors->first('name')): ?>
                                <div class="help-block"><?php echo e($errors->first('name')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('name_ar') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('name_ar', __('Arabic Name'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('name_ar', old('name_ar'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Arabic Name' )]); ?>

                            <?php if($errors->first('name_ar')): ?>
                                <div class="help-block"><?php echo e($errors->first('name_ar')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group ">
                        <?php echo Form::label('super_category_id', __('Super Category Name'), ['class' => 'control-label col-sm-2 ']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::select('super_category_id',$categories , null, ['placeholder' => __('select'),'class' => 'form-control']); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('is_active', __('Is Active?'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::radio('is_active', '1' , false  , ['required'=>'required' ]); ?>

                            <?php echo app('translator')->getFromJson('Yes'); ?>
                            <?php echo Form::radio('is_active', '0' , true  , ['required'=>'required' ]); ?>

                            <?php echo app('translator')->getFromJson('No'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('is_featured', __('Is Featured?'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::radio('is_featured', '1' , false  , ['required'=>'required' ]); ?>

                            <?php echo app('translator')->getFromJson('Yes'); ?>
                            <?php echo Form::radio('is_featured', '0' , true  , ['required'=>'required' ]); ?>

                            <?php echo app('translator')->getFromJson('No'); ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('thumbnail') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('thumbnail',__('Thumbnail'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::file('thumbnail', ['class' => 'form-control']); ?>

                            <?php if($errors->first('thumbnail')): ?>
                                <div class="help-block"><?php echo e($errors->first('thumbnail')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat"><?php echo app('translator')->getFromJson('Add'); ?></button>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>