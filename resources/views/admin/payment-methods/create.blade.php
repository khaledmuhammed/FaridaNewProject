@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Add') @lang('Payment Method')</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['action' => 'Admin\PaymentMethodController@store','class'=>'form-horizontal','method' => 'POST']) !!} {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                        {!! Form::label('name', __('Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', old('name'), ['class' => 'form-control','required'=>'required']) !!}
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('price') ? 'has-error' :  ''}}">
                        {!! Form::label('price', __('Cost'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::number('price', old('price',0), ['class' => 'form-control','required'=>'required']) !!}
                            @if($errors->first('price'))
                                <div class="help-block">{{$errors->first('price')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_active', __('Active?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <div class="form-control-static">
                                <toggler name="is_active" :old="0"></toggler>
                            </div>
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
