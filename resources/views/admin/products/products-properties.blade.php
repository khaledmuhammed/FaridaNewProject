@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Products Properties')</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <products-properties
                properties = '@json($properties)'
            ></products-properties>
        </div>
    </div>
</div>
@endsection
