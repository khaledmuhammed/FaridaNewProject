<?php $__env->startSection('content_header'); ?>
    <h1><?php echo app('translator')->getFromJson('Products'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(Session::has('success')): ?>
        <div class="alert alert-success">
            <?php echo e(Session::get('success')); ?>

        </div>
        <div class="clearfix"></div>
    <?php endif; ?>
    <?php if(Session::has('error')): ?>
        <div class="alert alert-error">
            <?php echo e(Session::get('error')); ?>

        </div>
        <div class="clearfix"></div>
    <?php endif; ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-sm-6">
                        <form action="<?php echo e(action('Admin\ProductController@index')); ?>" method="GET" class="form-horizontal">
                            <div class="col-sm-9">
                                <input type="text" name="name" value="<?php echo e(isset($name) ? $name : ''); ?>" placeholder="اسم أو رمز المنتج"
                                       class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <button value="submit" type="submit" class="btn btn-block btn-info">بحث</button>
                            </div>
                        </form>
                    </div>
                    <a class="btn btn-success pull-left btn-new-element"
                       href="<?php echo e(action('Admin\ProductController@create')); ?>"><?php echo app('translator')->getFromJson('Add'); ?> <?php echo app('translator')->getFromJson('Product'); ?></a>
                    <a class="btn btn-info"
                       href="<?php echo e(action('Admin\ProductController@index' , ['excel'])); ?>"
                    >
                     Excel file
                        <i class="fa fa-fw fa-download"></i>
                    </a>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->getFromJson('Product Image'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Product Name'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Product Code'); ?></th>
                                <th><?php echo app('translator')->getFromJson('Original Price'); ?></th>
                                
                                <th><?php echo app('translator')->getFromJson('Quantity'); ?></th>
                                
                                
                                
                                
                                
                                <th><?php echo app('translator')->getFromJson('Controllers'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($product->id); ?></td>
                                    <td>
                                        <?php if($product->getMedia('images')->first()): ?>
                                        <img src="<?php echo e($product->getMedia('images')->first()->getUrl()); ?>" width="80" />
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($product->name); ?></td>
                                    <td><?php echo e($product->product_code); ?></td>
                                    <td><?php echo e($product->original_price); ?></td>
                                    
                                    <td><?php echo e($product->quantity); ?></td>
                                    
                                    
                                    
                                    
                                    <td>
                                        <a class="btn btn-primary btn-xs"
                                           href="<?php echo e(action('Admin\ProductController@edit',$product->id)); ?>"><?php echo app('translator')->getFromJson('Edit'); ?></a>
                                        <button class="remove-model delete-model btn  btn-danger  btn-xs"
                                                data-path="products" data-obj="<?php echo e($product->id); ?>"
                                                href="javascript:void(0);"><?php echo app('translator')->getFromJson('Delete'); ?></button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo e($products->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>//delete a model object
        //delete a model object
        //-- data-path : model route
        //-- data-obj : object id
        $('.delete-model').click(function (e) {
            e.preventDefault();

            let r = confirm("<?php echo app('translator')->getFromJson("Do you want to delete it ?"); ?>");
            if (r == true) {

                let object_id = $(this).data('obj');
                let path      = $(this).data('path');

                $.ajax({
                    url     : `<?php echo e(url('/')); ?>/admin/${path}/${object_id}`,
                    type    : 'POST',
                    dataType: "JSON",
                    data    : {
                        "_method": 'DELETE',
                        "_token" : '<?php echo csrf_token() ?>',
                    },
                    success : function (data) {
                        if (data.url !== 'undefined') {
                            window.location.replace(`<?php echo e(url('/')); ?>/admin/${data.url}`);
                        } else {
                            window.location.replace(`<?php echo e(url('/')); ?>/admin/${path}`);
                        }
                    },
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>