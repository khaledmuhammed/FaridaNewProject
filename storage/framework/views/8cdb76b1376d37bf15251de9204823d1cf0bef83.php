<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Banner</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <?php echo Form::open(['action' => 'Admin\BannerController@store','class'=>'form-horizontal','method' => 'POST','enctype'=>'multipart/form-data']); ?>

                    <?php echo e(csrf_field()); ?>

                    <div class="form-group <?php echo e($errors->first('title') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('title', 'title', ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('title', old('title'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>'title' ]); ?>

                            <?php if($errors->first('title')): ?>
                                <div class="help-block"><?php echo e($errors->first('title')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('size') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('size', 'Size', ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::select('size',["3"=>3,"6"=>6,"9"=>9,"12"=>12] , old('size'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>'size' ]); ?>

                            <?php if($errors->first('size')): ?>
                                <div class="help-block"><?php echo e($errors->first('size')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <linked-images></linked-images>

                    <div class="row">
                        <div class="col-sm-2 pull-right">
                            <button type="submit" class="  btn btn-info btn-block btn-flat">Add</button>
                        </div>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>