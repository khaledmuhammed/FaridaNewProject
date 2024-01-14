@extends('frontend.layouts.app')
@section('content')
    <div id="category" class="container category-page">
        <div class="row">
            {{ Breadcrumbs::render('category', $category) }}
        </div>

        <div class="row">
            @if($category->filters->count())
                <div class="col-sm-3">
                    <v-filter :filters="{{$category->filters}}"></v-filter>
                    <position name="category.under.filter"
                              checkout_route="{{route('checkout')}}" size="12"></position>
                </div>
            @endif
            <div class="@if($category->filters->count()) col-sm-9 @else col-sm-12 @endif no-padding">
                <div class="row">
                    <v-products ref="products" class="products" category_id="{{$category->id}}" :items="{{$products}}"
                               :auth="@auth true @else false @endauth" size="3"></v-products>
                </div>
            </div>
        </div>
    </div>
@endsection
