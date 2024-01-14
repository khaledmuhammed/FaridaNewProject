<?php $__env->startSection('top-content'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div id="checkout">
        <div class="container">
            <div class="row" v-if="$store.state.cart.items.length">
                <div class="col-sm-4 border-left">
                    <?php if(auth()->guard()->check()): ?>
                        <v-address :addresses="<?php echo e($addresses); ?>" route="<?php echo e(route('addresses.store')); ?>"
                                    ref="address"></v-address>
                    <?php else: ?>
                        <guest-info ref="guest"></guest-info>
                        
                    <?php endif; ?>
                    <receiver-info ref="receiver"></receiver-info>
                    
                </div>
                <div class="col-sm-4 ">
                    <shipping ref="shipping" free_shipping_limit="<?php echo e($settings['free_shipping_limit']); ?>"></shipping>
                    <br>
                    <hr class="visible-xs">
                    <br>

                    <payment ref="payment" user_id="<?php echo e(auth()->id()); ?>"></payment>
                </div>
                <br class="visible-xs">
                <hr class="visible-xs">
                <br class="visible-xs">
                <div class="col-sm-4 no-padding border-right">
                    <v-summary :addresses="<?php echo e($addresses); ?>" <?php if(auth()->guard()->check()): ?> :user="<?php echo e(auth()->user()); ?>" <?php endif; ?>
                                payments_redirect_url="<?php echo e(route('moyasar.payments_redirect')); ?>"
                                moyasar_publishable_api_key="<?php echo e(config('services.moyasar.publishable_api_key')); ?>"
                                ref="summary"
                                ></v-summary>
                </div>
            </div>
            <div class="row" v-else>
                <div class="col-xs-12">
                    <h3 class="text-center"> <?php echo app('translator')->getFromJson('Cart Empty'); ?></h3>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('frontend.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>