<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo app('translator')->getFromJson('Add'); ?> <?php echo app('translator')->getFromJson('District'); ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo Form::open(['action' => 'Admin\DistrictController@store','class'=>'form-horizontal','method' => 'POST']); ?> <?php echo e(csrf_field()); ?>

                <div class="box-body">
                    <div class="form-group <?php echo e($errors->first('name') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('name', __('Name'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('name', old('name'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Name') ]); ?> <?php if($errors->first('name')): ?>
                                <div class="help-block"><?php echo e($errors->first('name')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('name_ar') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('name_ar', __('Arabic Name'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('name_ar', old('name_ar'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Arabic Name') ]); ?> <?php if($errors->first('name_ar')): ?>
                                <div class="help-block"><?php echo e($errors->first('name_ar')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('city_id') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('city_id', __('City'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::select('city_id', $cities, null,['class' => 'form-control','required'=>'required' , 'placeholder'=>__('City') ]); ?> <?php if($errors->first('city_id')): ?>
                                <div class="help-block"><?php echo e($errors->first('city_id')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('district_zone_id') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('district_zone_id', __('Zone'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::select('district_zone_id', $districtZones, null,['class' => 'form-control','required'=>'required', 'placeholder'=>__('Zone') ]); ?> 
                            <?php if($errors->first('district_zone_id')): ?>
                                <div class="help-block"><?php echo e($errors->first('district_zone_id')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat pull-left"><?php echo app('translator')->getFromJson('Save'); ?></button>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>