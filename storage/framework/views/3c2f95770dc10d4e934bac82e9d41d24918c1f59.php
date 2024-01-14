<?php $__env->startSection('content'); ?>
<?php if(Session::has('success')): ?>
    <div class="alert alert-success">
        <?php echo e(Session::get('success')); ?>

    </div>
    <div class="clearfix"></div>
<?php endif; ?>
<div class="row">
    <div class="col-xs-12 col-sm-8">
        <div class="box box-default ">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo app('translator')->getFromJson('General Settings'); ?></h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php echo Form::model($settings, ['action' => ['Admin\SettingsController@update'], 'method' => 'put','class'=>'form-horizontal']); ?>

            <div class="box-body">
                <h5># التوصيل المجاني</h5>
                
                <div class="form-group <?php echo e($errors->first('free_shipping_limit') ? 'has-error' :  ''); ?>">
                    <?php echo Form::label('free_shipping_text', 'قيمة التوصيل المجاني', ['class' => 'control-label col-sm-3']); ?>

                    <div class="col-sm-9">
                        <?php echo Form::number('free_shipping_limit', !empty($settings['free_shipping_limit']) ? $settings['free_shipping_limit'] : '', ['class' => 'form-control' ]); ?>

                        <?php if($errors->first('free_shipping_limit')): ?>
                        <div class="help-block"><?php echo e($errors->first('free_shipping_limit')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <hr>
                <div class="col-sm-2 col-sm-offset-10">
                    <button type="submit" class="btn btn-success btn-block btn-flat"><?php echo app('translator')->getFromJson('Save'); ?></button>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>