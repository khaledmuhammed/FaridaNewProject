@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Add') @lang('Email')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['action' => 'Admin\MailListController@store','class'=>'form-horizontal','method' => 'POST']) !!} {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group {{$errors->first('email') ? 'has-error' :  ''}}">
                        {!! Form::label('email', __('Email'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::email('email', old('email'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Email') ]) !!} @if($errors->first('email'))
                                <div class="help-block">{{$errors->first('email')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat pull-left">@lang('Save')</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
