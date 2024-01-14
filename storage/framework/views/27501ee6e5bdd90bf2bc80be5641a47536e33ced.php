<?php $__env->startSection('content'); ?>
    <div id="home">
        
        <div class="row">
            <div class="position ">
                <position name="home.under.menu"></position>
            </div>
        </div>
        <div class="row">
            <browser :categories="<?php echo e(\App\Models\Category::where('is_featured',true)->where('is_active',true)->take(6)->get()); ?>"></browser>
        </div>
        <div class="row">
            <div class="position ">
                <position name="home.under.categories"></position>
            </div>
        </div>
        <div class="row">
            <br>
            <h2 class="text-center text-primary">آراء العملاء</h2>
            <carousel :autoplay="true" dir="ltr"
                  :responsive="{0:{items:1,nav:false},600:{items:3,nav:true},800:{items:4,nav:true}}"
                  :loop="false"
                  :dots="false"
                  :stagePadding="0">
                <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src="<?php echo e($testimonial->getFirstMedia('thumbnail')->getUrl()); ?>" width="200" />
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </carousel>
        </div>
        
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>