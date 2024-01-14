<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo app('translator')->getFromJson('Edit'); ?> <?php echo app('translator')->getFromJson('Payment Method'); ?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php echo Form::model($paymentMethod, ['action' => ['Admin\PaymentMethodController@update', $paymentMethod->id], 'method' => 'put','class'=>'form-horizontal']); ?>

                <div class="box-body">
                    <div class="form-group <?php echo e($errors->first('name') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('name', __('Name'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('name', $paymentMethod->name, ['class' => 'form-control','required'=>'required']); ?>

                            <?php if($errors->first('name')): ?>
                                <div class="help-block"><?php echo e($errors->first('name')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('name_ar') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('name_ar', __('Arabic Name'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('name_ar', $paymentMethod->name_ar, ['class' => 'form-control','required'=>'required']); ?>

                            <?php if($errors->first('name_ar')): ?>
                                <div class="help-block"><?php echo e($errors->first('name_ar')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('price') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('price', __('Cost'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::number('price', $paymentMethod->price, ['class' => 'form-control','required'=>'required']); ?>

                            <?php if($errors->first('price')): ?>
                                <div class="help-block"><?php echo e($errors->first('price')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('is_active', __('Active?'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <div class="form-control-static">
                                <toggler name="is_active" :old="<?php echo e($paymentMethod->is_active); ?>"></toggler>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat"><?php echo app('translator')->getFromJson('Save'); ?></button>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>