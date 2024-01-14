@extends('adminlte::page')

@section('content')
    <div class="col-xs-12">
        <div class="box box-info ">
            <div class="box-header with-border">
                <h3 class="box-title"> @lang('Edit') @lang('Manufacturer')</h3>
            </div>
            <div class="box-body">
                {!!Form::model($manufacturer, ['action' => ['Admin\ManufacturerController@update', $manufacturer->id], 'method' => 'put','class'=>'form-horizontal', 'enctype'=>'multipart/form-data'])!!}
                <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                    {!! Form::label('name', __('Manufacturer Name'), ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('name', $manufacturer->name, ['class' => 'form-control','required'=>'required']) !!}
                        @if($errors->first('name'))
                            <div class="help-block">{{$errors->first('name')}}</div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('logo', __('Logo'), ['class' => 'control-label col-sm-2 ']) !!}
                    <div class="col-sm-10">
                        @if ($manufacturer->getFirstMedia('logo'))
                        <img class="img-viewer" src="{{$manufacturer->getFirstMedia('logo')->getUrl()}}" width="200" />
                        @endif
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
@endsection
