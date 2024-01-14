<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo app('translator')->getFromJson('Edit'); ?> <?php echo app('translator')->getFromJson('Banner'); ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo Form::model($banner, ['action' => ['Admin\BannerController@update', $banner->id], 'method' => 'put','class'=>'form-horizontal','enctype'=>'multipart/form-data']); ?>

                <div class="box-body">
                    <div class="form-group <?php echo e($errors->first('title') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('title', __('Title'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('title', $banner->title, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Title') ]); ?>

                            <?php if($errors->first('title')): ?>
                                <div class="help-block"><?php echo e($errors->first('title')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('size') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('size', __('Size'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::select('size',["3"=>3,"6"=>6,"9"=>9,"12"=>12] , $banner->size, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Size') ]); ?>

                            <?php if($errors->first('size')): ?>
                                <div class="help-block"><?php echo e($errors->first('size')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <linked-images></linked-images>

                </div>
                <div class="box-footer">
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat "><?php echo app('translator')->getFromJson('Save'); ?></button>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo app('translator')->getFromJson('Edit'); ?> <?php echo app('translator')->getFromJson('Banner Images'); ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <linked-images-edit :images="<?php echo e($banner->getMedia('banners')); ?>"></linked-images-edit>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>