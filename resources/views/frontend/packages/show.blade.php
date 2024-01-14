@extends('frontend.layouts.app')
@section('content')
    <div id="category" class="container category-page">
        <div class="row">
            <div class="col-sm-12 no-padding">
                <div class="row">
                    @if (!empty($package))
                    <v-package ref="package" :item="{{$package}}"
                               :auth="@auth true @else false @endauth"></v-package>
                    @else
                    <h3 class="text-center">@lang('Package not available now')</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
