@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Add') @lang('Product Option')</h3>
                </div><!-- /.box-header -->
                @include('admin.product-options.form')
            </div>
        </div>
    </div>
@endsection
