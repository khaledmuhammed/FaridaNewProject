@extends('frontend.layouts.app')
@section('content')
    <div id="category" class="container category-page">
        <h3 class="text-center text-primary">
        @lang('Packages')
        </h3>
        <div class="row">
            <div class="col-sm-12 no-padding">
                <div class="row">
                    <v-packages ref="packages" :items="{{$packages}}"
                               :auth="@auth true @else false @endauth" size="3"></v-packages>
                </div>
            </div>
        </div>
    </div>
@endsection
