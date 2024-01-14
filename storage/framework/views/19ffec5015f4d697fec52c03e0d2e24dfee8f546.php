<!DOCTYPE html>
<?php setlocale(LC_ALL, 'ar_AE.utf8');?>

<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="login-status" content="<?php echo e(Auth::check()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Styles -->
    <link href="<?php echo e(mix('css/app.css')); ?>" rel="stylesheet">
    <meta name="theme-color" content="#9a0120">
    <link rel="icon" sizes="192x192" href="<?php echo e(asset('imgs/logo-icon.png')); ?>">
    <?php if(app()->getLocale() == 'en'): ?>
    <link href="<?php echo e(mix('css/ltr-style.css')); ?>" rel="stylesheet">
    <?php endif; ?>

    <?php if(request()->is('checkout')): ?>

    <link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.12.0/moyasar.css">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=fetch"></script>

    <?php endif; ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-159441363-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-159441363-1');
    </script>
</head>
<body>
<div id="app">
    <div class="visible-xs">
        <sidebar ref="sidebar" :categories="<?php echo e($superCategories); ?>"></sidebar>
    </div>
    <transition name="slide-fade">
        <sticky-bar v-if="displayBar" :super-categories="<?php echo e($superCategories); ?>"></sticky-bar>
    </transition>
    <div class="c-navbar">
        <div class="container bar">
            <div class="visible-xs">
                <div class="hamburger" @click="$refs.sidebar.showSideMenu = true">&#9776;</div>
            </div>

            <div class="flex ">
                <div class="logo col-sm-4 text-center">
                    <a href="/"><img src="<?php echo e(asset('imgs/logo.png')); ?>" alt=""></a>
                </div>
                <div class="search-component col-sm-4">
                    <search route="<?php echo e(route('product',"")); ?>"></search>
                </div>
                <div class="links col-sm-3 col-sm-offset-1">
                    <div class="col-xs-3 col-xs-3 lang"><a href="<?php echo e(route('lang')); ?>"><?php echo app('translator')->getFromJson('عربي'); ?></a></div>
                    <div class="col-sm-3 col-xs-3">
                        <ul class="nav">
                            <li class=" dropdown">
                                <span class="dropdown-toggle" data-toggle="dropdown" role="button"
                                      aria-haspopup="true" aria-expanded="false">
                                    <h4 class="no-margin fi flaticon-user"></h4>
                                </span><?php if(auth()->guard()->check()): ?>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo e(route('profile')); ?>">
                                                <?php echo app('translator')->getFromJson('My Account'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(route('logout')); ?>"
                                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                <?php echo app('translator')->getFromJson('Logout'); ?>
                                            </a>
                                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                                  style="display: none;">
                                                <?php echo e(csrf_field()); ?>

                                            </form>
                                        </li>
                                    </ul>
                                <?php else: ?>
                                    <ul class="dropdown-menu">
                                        <li @click="showLogin = true">
                                            <a><?php echo app('translator')->getFromJson('Login'); ?></a>
                                        </li>
                                        <li @click="showRegister = true">
                                            <a><?php echo app('translator')->getFromJson('Register'); ?></a>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="col-sm-3 col-xs-3">
                        <div class="wishlist">
                            <a href="<?php if(auth()->guard()->check()): ?> /latest-wishlist <?php endif; ?>">
                            <h4 class="no-margin fi flaticon-heart"
                                <?php if(auth()->guard()->check()): ?>

                                <?php if(\App\Models\WishlistItem::where('user_id',Auth::id())->count() > 0): ?>
                                :class="{filled:true}"
                                    <?php endif; ?>
                                    <?php endif; ?>
                            ></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-3">
                        <div id="cart">
                            <cart ref="cart"></cart>
                        </div>
                        <div class="cart" @show="$refs.cart.show()" v-tippy='{html: "#cart",
                                                                        reactive : true,
                                                                        animateFill: true,
                                                                        theme :"light bordered",
                                                                        animation : "shift-away",
                                                                        duration : "[300,300]" ,
                                                                        placement : "bottom-start",
                                                                        interactive : true,
                                                                        trigger : "click" }'>
                            <h4 class="no-margin fi flaticon-bag"
                                :class="{'filled':$store.state.cart.items.length}"></h4>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="categories-bar">
        <div class="container">
        <ul class="nav navbar-nav hidden-xs">
            <li>
                <a href="/"><?php echo app('translator')->getFromJson('Home'); ?></a>
            </li>
            <?php $__currentLoopData = $superCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $superCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="dropdown">
                    <a href="<?php echo e(route('category',$superCategory->id)); ?>"><?php echo e($superCategory->theName); ?></a>
                    <?php if(count($superCategory->categories) > 0 ): ?>
                    <ul class="dropdown-content">
                        <?php $__currentLoopData = $superCategory->categoriesActive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(route('category',$category->id)); ?>"><?php echo e($category->theName); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="/packages">الإشتراكات</a>
            </li>
        </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <footer>
        
        <div class="container-fluid">
            
            <div class="row">
                <div class="about flex">
                    <div class="brief text-dark">
                        
                        <h4>ورود فريدة</h4>
                        <p class="text-justify">
                            <p>الورود هي مساحيق تجميلية على وجه الكرة الأرضية ، ومن هذا المنطلق أسسنا متجرنا بإعتبارنا نضيف لمسات تجميلية على أرضنا ومشاعرنا ،نسعى لإثراء الجمال بكافة أشكاله وصنع إبتسامة على الشفاة وإنشراح في الروح .</p>
                            <p>هذا شغفنا وأنتم جماله ..</p>
                        </p>
                        <p class="text-center">
                            <a href="#" target="_blank"><img src="<?php echo e(asset('imgs/maroof.png')); ?>" /></a>
                        </p>
                    </div>
                    <div class="support ">
                        <div class="col-sm-12 col-xs-12 margin-bottom-xs">
                            <h4 class="text-bold text-dark"><?php echo app('translator')->getFromJson('We are always ready to help you'); ?></h4>
                            <h6 class="text-dark"><?php echo app('translator')->getFromJson('Connect with us through any of the following channels'); ?></h6>
                            <p>
                                <i class="fi flaticon-envelope text-dark"></i>
                                <a href="mailto:sales@faridaflowers.com" class="text-dark">sales@faridaflowers.com</a>
                            </p>
                            <p>
                                <i class="fi flaticon-whatsapp text-dark"></i>
                                <a target="_blank" href="https://wa.me/966554718784" class="text-dark">966554718784</a>
                            </p>
                            <h3 class="text-dark">
                                <a href="https://www.instagram.com/faridaflowers_" target="_blank" class="fi flaticon-instagram"></a>
                                &nbsp;
                                <a href="https://twitter.com/faridaflowers_" target="_blank" class="fi flaticon-twitter"></a>
                                &nbsp;
                                <a href="https://www.snapchat.com/add/faridaflowers_" target="_blank"><img src="<?php echo e(asset('imgs/snapchat.png')); ?>" width="25" style="margin-top: -4px;" /></a>
                                
                            </h3>
                        </div>
                    </div>
                    <div class="quick-access">
                        <div class="col-sm-6 col-xs-12">
                            <h4 class="text-bold text-dark"><?php echo app('translator')->getFromJson('Quick Links'); ?></h4>
                            <?php if(count(\App\Models\Page::where('is_active', 1)->get()) > 0): ?>
                                <?php $__currentLoopData = \App\Models\Page::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="/pages/<?php echo e($page->id); ?>"><h5 class="col-sm-12 col-xs-12 no-padding"><?php echo e($page->theTitle); ?></h5></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="rights col-sm-4 text-primary text-right">
                        <span><?php echo app('translator')->getFromJson('All rights reserved for'); ?> <?php echo app('translator')->getFromJson('Faridah Flowers'); ?> <?php echo e(now()->year); ?> &#169;  | <?php echo app('translator')->getFromJson('Developed By'); ?> :
                        <a href="https://mhd.sa/" target="_blank" style="color: inherit;">مهد</a>
                    </div>
                    <div class="logo col-sm-4 text-center text-dark">
                        <img src="<?php echo e(asset('imgs/logo-icon.png')); ?>" width="60" alt="">
                    </span>
                    </div>
                    
                    <div class="col-sm-4 text-center margin-bottom">
                        <img src="/imgs/paymentpartners1.png" height="35" />
                        <img src="/imgs/VAT.png" height="35" />
                    </div>
                </div>

            </div>
        </div>
    </footer>
    <transition name="v-modal">
        <login v-if="showLogin" action="<?php echo e(route('login')); ?>"></login>
        <register v-if="showRegister" action="<?php echo e(route('register')); ?>"></register>
    </transition>
</div>

<a href="https://api.whatsapp.com/send?phone=966554718784" class="whatsapp-floating-icon fixed-top">
    <span class="fi flaticon-whatsapp text-white m-auto"></span>
</a>


<!-- Scripts -->
<script src="<?php echo e(mix('js/app.js')); ?>"></script>
<?php echo $__env->yieldContent('js'); ?>
<script type="text/javascript"> 
    var wpwlOptions = {
        locale: 'ar'
    }
</script>
</body>
</html>
