@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="row">
            <div class="col-xs-12">
                <product-details
                        action="{{action('Admin\ProductController@store')}}"
                        :manufacturers="{{$manufacturers}}"
                        :categories="{{$categories}}"
                        :properties="{{$properties }}"
                ></product-details>
            </div>
        </div>
    </div>
@endsection
