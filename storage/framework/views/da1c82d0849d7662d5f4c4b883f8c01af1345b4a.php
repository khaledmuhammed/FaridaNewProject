<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo app('translator')->getFromJson('Add'); ?>  <?php echo app('translator')->getFromJson('Page'); ?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php echo Form::open(['action' => ['Admin\PageController@update', $page->id],'class'=>'form-horizontal','method' => 'PUT', 'enctype'=>'multipart/form-data']); ?>

                <?php echo e(csrf_field()); ?>

                <div class="box-body">
                    <div class="form-group <?php echo e($errors->first('title') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('title', __('Title'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('title', $page->title, ['class' => 'form-control','required'=>'required']); ?>

                            <?php if($errors->first('title')): ?>
                                <div class="help-block"><?php echo e($errors->first('title')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo e($errors->first('title_ar') ? 'has-error' :  ''); ?>">
                        <?php echo Form::label('title_ar', __('Arabic Title'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <?php echo Form::text('title_ar', $page->title_ar, ['class' => 'form-control','required'=>'required']); ?>

                            <?php if($errors->first('title_ar')): ?>
                                <div class="help-block"><?php echo e($errors->first('title_ar')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('content', __('Content Page'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <textarea id="content" name="content"><?php echo $page->content; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('content_ar', __('Arabic Content Page'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <textarea id="content_ar" name="content_ar"><?php echo $page->content_ar; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label('is_active', __('Is Show?'), ['class' => 'control-label col-sm-2']); ?>

                        <div class="col-sm-10">
                            <toggler name="is_active" :old="<?php echo e($page->is_active); ?>"></toggler>
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-success btn-block btn-flat"><?php echo app('translator')->getFromJson('Save'); ?></button>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<!-- include summernote css/js-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/lang/summernote-ar-AR.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#content').summernote({
          height: 150,      // set editor height
          minHeight: null,  // set minimum height of editor
          maxHeight: null,  // set maximum height of editor
          lang: 'ar-AR'     // default: 'en-US'
    });
    $('#content_ar').summernote({
          height: 150,      // set editor height
          minHeight: null,  // set minimum height of editor
          maxHeight: null,  // set maximum height of editor
          lang: 'ar-AR'     // default: 'en-US'
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>