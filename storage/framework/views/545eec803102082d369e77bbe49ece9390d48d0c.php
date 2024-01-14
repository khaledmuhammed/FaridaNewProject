<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo app('translator')->getFromJson('Add'); ?> <?php echo app('translator')->getFromJson('Coupon'); ?></h3>
                </div>
                <?php echo Form::open(['action' => 'Admin\CouponController@store','class'=>'form-horizontal','method' => 'POST']); ?> <?php echo e(csrf_field()); ?>

                <div class="box-body">
                    <div class="form-group <?php echo e($errors->first('title') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('title', __('Title'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('title', old('title'), ['class' => 'form-control','required'=>'required']); ?>

                            <?php if($errors->first('title')): ?>
                                <div class="help-block"><?php echo e($errors->first('title')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('code') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('code', __('Code'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('code', old('code'), ['class' => 'form-control','required'=>'required']); ?>

                            <?php if($errors->first('code')): ?>
                                <div class="help-block"><?php echo e($errors->first('code')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('type') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('type', __('Apply On'), ['class' => 'control-label col-sm-2 ']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::select('type', $couponTypes ,old('type','product'), ['class' => 'form-control','required'=>'required'  ,]); ?>

                            <?php if($errors->first('type')): ?>
                                <div class="help-block"><?php echo e($errors->first('type')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('calc') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('calc', __('Calc Method'), ['class' => 'control-label col-sm-2 ']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::select('calc', $couponCalc ,old('calc','fixed'), ['class' => 'form-control','required'=>'required'  ,]); ?>

                            <?php if($errors->first('calc')): ?>
                                <div class="help-block"><?php echo e($errors->first('calc')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('amount') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('amount', __('Amount'), ['class' => 'control-label col-sm-2 ']); ?>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <?php echo Form::number('amount',old('amount',0), ['class' => 'form-control flat','required'=>'required' ,'step'=>'0.01']); ?>

                                <span class="input-group-addon flat"><?php echo app('translator')->getFromJson('SR'); ?></span>
                            </div>
                            <?php if($errors->first('amount')): ?>
                                <div class="help-block"><?php echo e($errors->first('amount')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group  <?php echo e($errors->first('minimum') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('minimum', __('Minimum Amount'), ['class' => 'control-label col-sm-2 ']); ?>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <?php echo Form::number('minimum',old('minimum',0), ['class' => 'form-control flat','required'=>'required','step'=>'0.01']); ?>

                                <span class="input-group-addon flat"><?php echo app('translator')->getFromJson('SR'); ?></span>
                            </div>
                            <h6 class="help-block">0 = <?php echo app('translator')->getFromJson('no minimum amount applied'); ?></h6>
                            <?php if($errors->first('minimum')): ?>
                                <div class="help-block"><?php echo e($errors->first('minimum')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('start_date') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('start_date', __('Start Date'), ['class' => 'control-label col-sm-2 ']); ?>

                        <div class="col-sm-10">
                            <datepicker name="start_date"
                                        :format="$root.dateFormatter"
                                        input-class="form-control not-readonly"
                                        :language="lang.<?php echo e(app()->getLocale()); ?>"
                                        :value="dateFormatter('<?php echo e(old('start_date',now()->toDateString())); ?>')"
                            ></datepicker>
                            <?php if($errors->first('start_date')): ?>
                                <div class="help-block"><?php echo e($errors->first('start_date')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('end_date') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('end_date', __('End Date'), ['class' => 'control-label col-sm-2 ']); ?>

                        <div class="col-sm-10">
                            <datepicker name="end_date"
                                        :format="$root.dateFormatter"
                                        input-class="form-control not-readonly"
                                        :language="lang.<?php echo e(app()->getLocale()); ?>"
                                        :value="dateFormatter('<?php echo e(old('end_date','')); ?>')"
                            ></datepicker>
                            <?php if($errors->first('end_date')): ?>
                                <div class="help-block"><?php echo e($errors->first('end_date')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('usage_limit') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('usage_limit', __('Usage Limit'), ['class' => 'control-label col-sm-2 ']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::number('usage_limit',old('usage_limit',0), ['class' => 'form-control','required'=>'required'  ,]); ?>

                            <h6 class="help-block">0 = <?php echo app('translator')->getFromJson('unlimited usage'); ?></h6>
                            <?php if($errors->first('usage_limit')): ?>
                                <div class="help-block"><?php echo e($errors->first('usage_limit')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <couponables
                            :types="<?php echo e($couponableTypes); ?>"
                            old="<?php echo e(old('couponable_type','product')); ?>"
                            :old_product="<?php echo json_encode(old('product_id', [])); ?>"
                            :old_category="<?php echo json_encode(old('category_id', [])); ?>"
                            :old_manufacturer="<?php echo json_encode(old('manufacturer_id', [])); ?>"
                            :old_payment_method="<?php echo json_encode(old('payment_method_id', [])); ?>"
                            :categories="<?php echo e($categories); ?>"
                            :manufacturers="<?php echo e($manufacturers); ?>"
                            :payment_methods="<?php echo e($paymentMethods); ?>"
                    ></couponables>
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat">
                            <?php echo app('translator')->getFromJson('Add'); ?>
                        </button>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>