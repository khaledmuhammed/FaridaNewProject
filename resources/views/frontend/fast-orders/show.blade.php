@extends('frontend.layouts.app')
@section('content')
    <h1 class="text-center text-primary">طلبات الواتساب السريعة</h1>
    <div class="row">
        <fast-orders :products="{{$products}}" :packages="{{$packages}}"></fast-orders>
    </div>
@endsection
