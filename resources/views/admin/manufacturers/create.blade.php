@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Add')  @lang('Manufacturer')</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['action' => 'Admin\ManufacturerController@store','class'=>'form-horizontal','method' => 'POST', 'enctype'=>'multipart/form-data']) !!}
                {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                        {!! Form::label('name', __('Manufacturer Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', old('name'), ['class' => 'form-control','required'=>'required']) !!}
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('logo', __('Logo'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            {!! Form::file('logo', ['class' => 'form-control img-updater']) !!}
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat">@lang('Save')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
