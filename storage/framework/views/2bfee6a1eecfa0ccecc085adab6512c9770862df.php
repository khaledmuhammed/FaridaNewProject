<?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Edit'); ?> <?php echo e(app()->isLocale('ar') ? $position->name_ar : $position->name); ?></h1>
<?php $__env->stopSection(); ?> <?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <?php echo Form::model($position, ['action' => ['Admin\PositionController@sort', $position->id], 'method' => 'post','class'=>'form-horizontal']); ?>

                <div class="box-body">
                    <positionables :position="<?php echo e($position); ?>"></positionables>
                </div>
                <div class="box-footer">
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat "><?php echo app('translator')->getFromJson('Save'); ?></button>
                    </div>

                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>
        $('.sort').keyup(function () {
            clearTimeout($.data(this, 'timer'));
            var wait = setTimeout(saveData, 500); // delay after user types
            $(this).data('timer', wait);
        });

        function saveData() {
            // ... ajax ...
            console.log($('.sort'))
        }
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>