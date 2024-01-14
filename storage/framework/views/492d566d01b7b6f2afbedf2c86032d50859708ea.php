<?php $__env->startSection('content'); ?>
    <div id="category" class="container category-page">
        <div class="row">
            <?php echo e(Breadcrumbs::render('category', $category)); ?>

        </div>

        <div class="row">
            <?php if($category->filters->count()): ?>
                <div class="col-sm-3">
                    <v-filter :filters="<?php echo e($category->filters); ?>"></v-filter>
                    <position name="category.under.filter"
                              checkout_route="<?php echo e(route('checkout')); ?>" size="12"></position>
                </div>
            <?php endif; ?>
            <div class="<?php if($category->filters->count()): ?> col-sm-9 <?php else: ?> col-sm-12 <?php endif; ?> no-padding">
                <div class="row">
                    <v-products ref="products" class="products" category_id="<?php echo e($category->id); ?>" :items="<?php echo e($products); ?>"
                               :auth="<?php if(auth()->guard()->check()): ?> true <?php else: ?> false <?php endif; ?>" size="3"></v-products>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>