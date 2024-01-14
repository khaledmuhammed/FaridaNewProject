<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php echo app('translator')->getFromJson('Edit'); ?> <?php echo app('translator')->getFromJson('Package'); ?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php echo Form::model($package, ['action' => ['Admin\PackageController@update', $package->id], 'method' => 'put','class'=>'form-horizontal','enctype'=>'multipart/form-data']); ?>

                <div class="box-body">
                    <div class="form-group <?php echo e($errors->first('name') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('name', __('Package Name'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('name', $package->name, ['class' => 'form-control','required'=>'required' , 'placeholder'=> __('Package Name') ]); ?>

                            <?php if($errors->first('name')): ?>
                                <div class="help-block"><?php echo e($errors->first('name')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('name_en') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('name_en', __('Package English Name'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('name_en', $package->name_en, ['class' => 'form-control','required'=>'required' , 'placeholder'=> __('Package English Name') ]); ?>

                            <?php if($errors->first('name_en')): ?>
                                <div class="help-block"><?php echo e($errors->first('name_en')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('description') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('description', __('Description'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::textarea('description', $package->description, ['class' => 'form-control','required'=>'required' , 'placeholder'=> __('Description') ]); ?>

                            <?php if($errors->first('description')): ?>
                                <div class="help-block"><?php echo e($errors->first('description')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('description_en') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('description_en', __('English Description'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::textarea('description_en', $package->description_en, ['class' => 'form-control','required'=>'required' , 'placeholder'=> __('English Description') ]); ?>

                            <?php if($errors->first('description_en')): ?>
                                <div class="help-block"><?php echo e($errors->first('description_en')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('product_id') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('product_id', __('Products'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <package-product-select :multiple="true"
                                            :selected="<?php echo e($selectedProducts); ?>"
                                            :calc_total="true">
                            </package-product-select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <?php echo Form::label('price', __("Products' Total Price"), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10" style="padding-top: 7px;">
                            <span id="total" v-text="totalProductPrice"></span> ريال
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('price') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('price', __("Package Price"), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('price', $package->price, ['class' => 'form-control','required'=>'required' , 'placeholder'=>'price' ]); ?>

                            <?php if($errors->first('price')): ?>
                                <div class="help-block"><?php echo e($errors->first('price')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('quantity') ? 'has-error' :  ''); ?>">

                        <?php echo Form::label('quantity', __('Quantity'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::number('quantity', $package->quantity, ['class' => 'form-control','required'=>'required' , 'placeholder'=>'quantity' ]); ?>

                            <?php if($errors->first('name')): ?>
                                <div class="help-block"><?php echo e($errors->first('quantity')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('availability', __('Available?'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <toggler name="availability" :old="<?php echo e($package->availability); ?>"></toggler>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('availability_date') ? 'has-error' :  ''); ?>">

                        <?php echo Form::label('availability_date', __('Availability Date'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <datepicker name="availability_date"
                                        :format="$root.dateFormatter"
                                        input-class="form-control not-readonly"
                                        :language="lang.<?php echo e(app()->getLocale()); ?>"
                                        :value="dateFormatter('<?php echo e($package->availability_date); ?>')"
                            ></datepicker>
                            <?php if($errors->first('name')): ?>
                                <div class="help-block"><?php echo e($errors->first('availability_date')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('shipping_free', __('Shipping Free?'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <toggler name="shipping_free" :old="<?php echo e($package->shipping_free); ?>"></toggler>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('payment_free', __('Payment Free?'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <toggler name="payment_free" :old="<?php echo e($package->payment_free); ?>"></toggler>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('image', __('Thumbnail'), ['class' => 'control-label col-sm-2 ']); ?>

                        <div class="col-sm-10">
                            <?php if($package->getFirstMedia('image')): ?>
                            <img class="img-viewer" src="<?php echo e($package->getFirstMedia('image')->getUrl()); ?>" width="300" />
                            <?php endif; ?>
                            <?php echo Form::file('image', ['class' => 'form-control img-updater']); ?>

                            <?php echo Form::hidden('delete_image', false, ['class' => 'form-control delete_image' ]); ?>

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
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>