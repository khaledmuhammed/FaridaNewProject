<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo app('translator')->getFromJson('Edit'); ?> <?php echo app('translator')->getFromJson('Zone'); ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo Form::model($districtZone, ['action' => ['Admin\DistrictZoneController@update', $districtZone->id], 'method' => 'put','class'=>'form-horizontal']); ?>

                <div class="box-body">
                    <div class="form-group <?php echo e($errors->first('name') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('name', __('Name'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('name', $districtZone->name, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Name') ]); ?> <?php if($errors->first('name')): ?>
                                <div class="help-block"><?php echo e($errors->first('name')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('shipping_price') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('shipping_price', __('Shipping Price'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('shipping_price', $districtZone->shipping_price, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Shipping Price') ]); ?> <?php if($errors->first('shipping_price')): ?>
                                <div class="help-block"><?php echo e($errors->first('shipping_price')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('city_id') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('city_id', __('City'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::select('city_id', $cities, $districtZone->city_id,['class' => 'form-control','required'=>'required' , 'placeholder'=>__('City') ]); ?> <?php if($errors->first('city_id')): ?>
                                <div class="help-block"><?php echo e($errors->first('city_id')); ?></div>
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