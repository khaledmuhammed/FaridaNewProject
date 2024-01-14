@extends('frontend.layouts.app')
@section('content')
    <h1 class="text-center text-primary">{{$page->theTitle}}</h1>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-xs-12">
            {!! $page->theContent !!}
        </div>
    </div>
@endsection
