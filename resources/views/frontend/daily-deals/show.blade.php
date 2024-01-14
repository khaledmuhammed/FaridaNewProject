@extends('frontend.layouts.app')

@section('content')
    <div id="daily-deals">
        <div class="container-fluid">
            <div class="row">
                <v-products class="products" :items="{{$products}}" :auth="@auth true @else false @endauth"></v-products>
            </div>
        </div>
    </div>
@endsection
