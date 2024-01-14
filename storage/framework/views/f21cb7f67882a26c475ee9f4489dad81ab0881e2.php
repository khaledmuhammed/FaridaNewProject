<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="product">
            
            <div class="row">
                <?php echo e(Breadcrumbs::render('product', $product)); ?>

            </div>
            
            <div class="row">
                <div class="col-sm-7 col-xs-12 pull-right">
                    <media :imgs="<?php echo e($product->getMedia('images')); ?>"></media>
                </div>
                <div class="col-sm-5 col-xs-12 pull-right">
                    <actions :product="<?php echo e($product); ?>" id="actions" :auth="<?php if(auth()->guard()->check()): ?> true <?php else: ?> false <?php endif; ?>"></actions>
                </div>
            </div>
            
            <?php if(!empty($product->description)): ?>
            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <div class="collapse-header">
                            <a href="#description" class="collapsed" data-toggle="collapse" role="button">وصف المنتج</a>
                        </div>
                        <div class="collapse" id="description">
                            <div class="description"><?php echo $product->description; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if(count($packages)): ?>
                <div class="row">
                    <div class="col-xs-12">
                        <packages :product="<?php echo e($product); ?>"
                                  :packages="<?php echo e($packages); ?>"
                                  :auth="<?php if(auth()->guard()->check()): ?> true <?php else: ?> false <?php endif; ?>"></packages>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-xs-12">
                    <attributes :attributes="<?php echo e($product->productAttributes); ?>"></attributes>
                </div>
            </div>
           
            <?php if( count($relatedProducts)  ): ?>
                <div class="row">
                    <div class="col-xs-12">
                        <related
                                :related_products="<?php echo e($relatedProducts); ?>"
                                :auth="<?php if(auth()->guard()->check()): ?> true <?php else: ?> false <?php endif; ?>">
                        </related>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-xs-12">
                    <rating :ratings="<?php echo e($product->ratings); ?>" :rate_avg="<?php echo e($product->rating); ?>"
                            :product_id="<?php echo e($product->id); ?>"></rating>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>