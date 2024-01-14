<!DOCTYPE html>
<?php setlocale(LC_ALL, 'ar_AE.utf8');?>

<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="login-status" content="{{ Auth::check() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <meta name="theme-color" content="#9a0120">
    <link rel="icon" sizes="192x192" href="{{asset('imgs/logo-icon.png')}}">
    @if(app()->getLocale() == 'en')
    <link href="{{ mix('css/ltr-style.css') }}" rel="stylesheet">
    @endif

    @if(request()->is('checkout'))

    <link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.12.0/moyasar.css">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=fetch"></script>

    @endif

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
        <sidebar ref="sidebar" :categories="{{$superCategories}}"></sidebar>
    </div>
    <transition name="slide-fade">
        <sticky-bar v-if="displayBar" :super-categories="{{$superCategories}}"></sticky-bar>
    </transition>
    <div class="c-navbar">
        <div class="container bar">
            <div class="visible-xs">
                <div class="hamburger" @click="$refs.sidebar.showSideMenu = true">&#9776;</div>
            </div>

            <div class="flex ">
                <div class="logo col-sm-4 text-center">
                    <a href="/"><img src="{{asset('imgs/logo.png')}}" alt=""></a>
                </div>
                <div class="search-component col-sm-4">
                    <search route="{{route('product',"")}}"></search>
                </div>
                <div class="links col-sm-3 col-sm-offset-1">
                    <div class="col-xs-3 col-xs-3 lang"><a href="{{route('lang')}}">@lang('عربي')</a></div>
                    <div class="col-sm-3 col-xs-3">
                        <ul class="nav">
                            <li class=" dropdown">
                                <span class="dropdown-toggle" data-toggle="dropdown" role="button"
                                      aria-haspopup="true" aria-expanded="false">
                                    <h4 class="no-margin fi flaticon-user"></h4>
                                </span>@auth
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('profile') }}">
                                                @lang('My Account')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                @lang('Logout')
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                @else
                                    <ul class="dropdown-menu">
                                        <li @click="showLogin = true">
                                            <a>@lang('Login')</a>
                                        </li>
                                        <li @click="showRegister = true">
                                            <a>@lang('Register')</a>
                                        </li>
                                    </ul>
                                @endauth
                            </li>
                        </ul>
                    </div>
                    {{-- <div class="col-xs-3 col-xs-3">
                        <a target="_blank" href="https://wa.me/966558992470"
                           class="no-margin h4 fi flaticon-whatsapp"></a>
                    </div> --}}
                    <div class="col-sm-3 col-xs-3">
                        <div class="wishlist">
                            <a href="@auth /latest-wishlist @endauth">
                            <h4 class="no-margin fi flaticon-heart"
                                @auth

                                @if(\App\Models\WishlistItem::where('user_id',Auth::id())->count() > 0)
                                :class="{filled:true}"
                                    @endif
                                    @endauth
                            ></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-3">
                        <div id="cart">
                            <cart ref="cart"></cart>
                        </div>
                        <div class="cart" @@show="$refs.cart.show()" v-tippy='{html: "#cart",
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
                        {{-- @if(\App\Models\DailyDeal::currntDeals()->first() )
                            <a href="{{route('daily-deals')}}" class="daily-deal" id="daily-deal-countdown">
                                <div class="col-xs-3">
                                    <h1 class="no-margin glyphicon glyphicon-gift"></h1>
                                </div>
                                <div class="col-xs-9">

                                    <h4 class="no-margin">صفقة اليوم</h4>
                                    <h4 class="text-red no-margin">
                                        <countdown
                                                value="{{\App\Models\DailyDeal::currntDeals()->first()->end_date}}"></countdown>
                                    </h4>
                                </div>
                            </a>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="categories-bar">
        <div class="container">
        <ul class="nav navbar-nav hidden-xs">
            <li>
                <a href="/">@lang('Home')</a>
            </li>
            @foreach($superCategories as $superCategory)
                <li class="dropdown">
                    <a href="{{route('category',$superCategory->id)}}">{{$superCategory->theName}}</a>
                    @if(count($superCategory->categories) > 0 )
                    <ul class="dropdown-content">
                        @foreach($superCategory->categoriesActive as $category)
                            <li><a href="{{route('category',$category->id)}}">{{$category->theName}}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
            @endforeach
            <li>
                <a href="/packages">الإشتراكات</a>
            </li>
        </ul>
        </div>
    </div>
    <div class="container-fluid">
        @yield('content')
    </div>
    <footer>
        {{-- <div class="container">
            <div class="mail-list">
                <div class="col-sm-5 col-sm-offset-1">
                    <h4 class="text-bold text-white">احصل على آخر أخبارنا وعروضنا</h4>
                </div>
                <div class="col-sm-6">
                    <form action="{{route('subscribe')}}" class="form-horizontal" method="POST">
                        {{csrf_field()}}
                        <div class="col-xs-8">
                            <div class="form-group">
                                <input type="email" class="form-control no-border" required
                                       placeholder="ادخل بريدك الالكتروني">
                            </div>
                        </div>
                        <div class=" col-xs-3 col-sm-2">
                            <input type="submit" value="إضافة" class="btn btn-primary">
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div> --}}
        <div class="container-fluid">
            {{-- <div class="row">
                <div class="container">
                    <div class="col-sm-4 col-xs-12 margin-bottom-xs support-details no-padding">
                        <div class="radius-icon col-sm-3 col-xs-3">
                            <i class="fi flaticon-whatsapp text-dark"></i>
                        </div>
                        <div class="support-data col-sm-9 col-xs-9 no-padding">
                            <p>@lang('WhatsApp')</p>
                            <a target="_blank" href="https://wa.me/966507309456" class="text-dark">+966507309456</a>
                        </div>
                    </div>                    
                    <div class="col-sm-4 col-xs-12 margin-bottom-xs support-details no-padding">
                        <div class="radius-icon col-sm-3 col-xs-3">
                            <i class="glyphicon glyphicon-road text-dark"></i>
                        </div>
                        <div class="support-data col-sm-9 col-xs-9 no-padding">
                            <p>توصيل سريع</p>
                            <a href="mailto:contact@soca.sa" class="text-dark">داخل الرياض 1-3 أيام - خارج الرياض ٧ أيام</a>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12 margin-bottom-xs support-details no-padding">
                        <div class="radius-icon col-sm-3 col-xs-3">
                            <i class="glyphicon glyphicon-credit-card text-dark"></i>
                        </div>
                        <div class="support-data col-sm-9 col-xs-10 no-padding">
                            <p>دفع آمن</p>
                            <p>دفع عند الاستلام أو تحويل بنكي أو بطاقة مدى</p>
                        </div>
                    </div>                    
                </div>
            </div> --}}
            <div class="row">
                <div class="about flex">
                    <div class="brief text-dark">
                        {{-- <img src="{{asset('imgs/logo.png')}}" alt=""> --}}
                        <h4>ورود فريدة</h4>
                        <p class="text-justify">
                            <p>الورود هي مساحيق تجميلية على وجه الكرة الأرضية ، ومن هذا المنطلق أسسنا متجرنا بإعتبارنا نضيف لمسات تجميلية على أرضنا ومشاعرنا ،نسعى لإثراء الجمال بكافة أشكاله وصنع إبتسامة على الشفاة وإنشراح في الروح .</p>
                            <p>هذا شغفنا وأنتم جماله ..</p>
                        </p>
                        <p class="text-center">
                            <a href="#" target="_blank"><img src="{{asset('imgs/maroof.png')}}" /></a>
                        </p>
                    </div>
                    <div class="support ">
                        <div class="col-sm-12 col-xs-12 margin-bottom-xs">
                            <h4 class="text-bold text-dark">@lang('We are always ready to help you')</h4>
                            <h6 class="text-dark">@lang('Connect with us through any of the following channels')</h6>
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
                                <a href="https://www.snapchat.com/add/faridaflowers_" target="_blank"><img src="{{asset('imgs/snapchat.png')}}" width="25" style="margin-top: -4px;" /></a>
                                {{-- &nbsp;
                                |
                                &nbsp;
                                <a href="{{route('lang')}}"><i class="glyphicon glyphicon-globe"></i> @lang('عربي')</a> --}}
                            </h3>
                        </div>
                    </div>
                    <div class="quick-access">
                        <div class="col-sm-6 col-xs-12">
                            <h4 class="text-bold text-dark">@lang('Quick Links')</h4>
                            @if (count(\App\Models\Page::where('is_active', 1)->get()) > 0)
                                @foreach (\App\Models\Page::all() as $page)
                                <a href="/pages/{{$page->id}}"><h5 class="col-sm-12 col-xs-12 no-padding">{{$page->theTitle}}</h5></a>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="rights col-sm-4 text-primary text-right">
                        <span>@lang('All rights reserved for') @lang('Faridah Flowers') {{now()->year}} &#169;  | @lang('Developed By') :
                        <a href="https://mhd.sa/" target="_blank" style="color: inherit;">مهد</a>
                    </div>
                    <div class="logo col-sm-4 text-center text-dark">
                        <img src="{{asset('imgs/logo-icon.png')}}" width="60" alt="">
                    </span>
                    </div>
                    {{-- <div class="links col-sm-4 text-center">
                        <a target="_blank" href="https://wa.me/9665xxxxxxxxx"><p class="whatsapp-icon h3"><span
                                        class="fi flaticon-whatsapp text-dark"></span></p>
                            <p class="whatsapp-mobile text-dark">
                                <span>خدمة العملاء | واتساب</span>
                                <br>+9665xxxxxxxxx
                            </p>
                        </a>

                    </div> --}}
                    <div class="col-sm-4 text-center margin-bottom">
                        <img src="/imgs/paymentpartners1.png" height="35" />
                        <img src="/imgs/VAT.png" height="35" />
                    </div>
                </div>

            </div>
        </div>
    </footer>
    <transition name="v-modal">
        <login v-if="showLogin" action="{{ route('login') }}"></login>
        <register v-if="showRegister" action="{{ route('register') }}"></register>
    </transition>
</div>

<a href="https://api.whatsapp.com/send?phone=966554718784" class="whatsapp-floating-icon fixed-top">
    <span class="fi flaticon-whatsapp text-white m-auto"></span>
</a>


<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('js')
<script type="text/javascript"> 
    var wpwlOptions = {
        locale: 'ar'
    }
</script>
</body>
</html>
