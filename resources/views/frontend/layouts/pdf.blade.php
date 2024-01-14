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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="theme-color" content="#3f1329">
    <link rel="icon" sizes="192x192" href="{{asset('imgs/theme-logo.png')}}">

    <!-- style e-payment form -->
    <style>
        wpwl-group{
            direction:ltr;
        }
        
        .wpwl-control-cardNumber{
            direction:ltr !important;
            text-align:right;
        }
    </style>
</head>
<body>
<div id="app">
    <div class="container">
        @yield('content')
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
<script type="text/javascript"> 
    var wpwlOptions = {
        locale: 'ar'
    }
</script>
</body>
</html>
