<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo app('translator')->getFromJson('Edit'); ?> <?php echo app('translator')->getFromJson('Featured Products'); ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <?php echo Form::model($featuredProducts, ['action' => ['Admin\FeaturedProductController@update', $featuredProducts->id], 'method' => 'put','class'=>'form-horizontal','enctype'=>'multipart/form-data']); ?>

                    <div class="form-group <?php echo e($errors->first('title') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('title', __('Title'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('title', $featuredProducts->title, ['class' => 'form-control','required'=>'required' , 'placeholder'=>'title' ]); ?>

                            <?php if($errors->first('title')): ?>
                                <div class="help-block"><?php echo e($errors->first('title')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('title_ar') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('title_ar', __('Arabic Title'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('title_ar', $featuredProducts->title_ar, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Arabic Title') ]); ?>

                            <?php if($errors->first('title_ar')): ?>
                                <div class="help-block"><?php echo e($errors->first('title_ar')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    

                    <featured-products
                        :products-error="<?php echo e($errors->first('products') ? 'true':'false'); ?>"
                        :category-error="<?php echo e($errors->first('category') ? 'true':'false'); ?>"
                        :old-category="<?php echo e($oldCategory ?? 'null'); ?>"
                        :old-products="<?php echo e($oldProducts); ?>"
                        :categories="<?php echo e($categories); ?>"
                    ></featured-products>

                    <div class="row">
                        <div class="col-sm-2 pull-end">
                            <button type="submit" class="btn btn-info btn-block btn-flat "><?php echo app('translator')->getFromJson('Save'); ?></button>
                        </div>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <!-- Latest compiled and minified JavaScript -->
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>