@extends('adminlte::page')


@section('content')
    <div class="col-xs-12">
        <div class="box box-info ">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('Edit Option')</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            @include('admin.product-options.form')
        </div>
    </div>
@endsection
