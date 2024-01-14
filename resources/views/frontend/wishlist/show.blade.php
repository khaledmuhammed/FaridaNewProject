@extends('frontend.layouts.app')

@section('content')
    <div id="daily-deals">
        <h3 class="text-center text-primary">
            @lang('Wish List')
        </h3>
        <div class="container-fluid">
            <div class="row">
            <v-products ref="products" class="products" category_id="null" :items="{{$products}}"
                               :auth="@auth true @else false @endauth" size="3"></v-products>
            </div>
        </div>
    </div>
@endsection
