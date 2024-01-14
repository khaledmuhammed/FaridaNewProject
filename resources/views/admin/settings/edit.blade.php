@extends('adminlte::page')

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    <div class="clearfix"></div>
@endif
<div class="row">
    <div class="col-xs-12 col-sm-8">
        <div class="box box-default ">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('General Settings')</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!!Form::model($settings, ['action' => ['Admin\SettingsController@update'], 'method' => 'put','class'=>'form-horizontal'])!!}
            <div class="box-body">
                <h5># التوصيل المجاني</h5>
                {{-- <div class="form-group {{$errors->first('free_shipping_text') ? 'has-error' :  ''}}">
                    {!! Form::label('free_shipping_text', 'عبارة الشحن المجاني', ['class' => 'control-label col-sm-3']) !!}
                    <div class="col-sm-9">
                        {!! Form::text('free_shipping_text', !empty($settings['free_shipping_text']) ? $settings['free_shipping_text'] : '', ['class' => 'form-control' ]) !!}
                        @if($errors->first('free_shipping_text'))
                        <div class="help-block">{{$errors->first('free_shipping_text')}}</div>
                        @endif
                    </div>
                </div> --}}
                <div class="form-group {{$errors->first('free_shipping_limit') ? 'has-error' :  ''}}">
                    {!! Form::label('free_shipping_text', 'قيمة التوصيل المجاني', ['class' => 'control-label col-sm-3']) !!}
                    <div class="col-sm-9">
                        {!! Form::number('free_shipping_limit', !empty($settings['free_shipping_limit']) ? $settings['free_shipping_limit'] : '', ['class' => 'form-control' ]) !!}
                        @if($errors->first('free_shipping_limit'))
                        <div class="help-block">{{$errors->first('free_shipping_limit')}}</div>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="col-sm-2 col-sm-offset-10">
                    <button type="submit" class="btn btn-success btn-block btn-flat">@lang('Save')</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
