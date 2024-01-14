@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Add') @lang('User')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['action' => 'Admin\UserController@store','class'=>'form-horizontal','method' => 'POST']) !!} {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group {{$errors->first('first_name') ? 'has-error' :  ''}}">
                        {!! Form::label('first_name', __('First Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('first_name', old('first_name'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('First Name') ]) !!} @if($errors->first('first_name'))
                                <div class="help-block">{{$errors->first('first_name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('last_name') ? 'has-error' :  ''}}">
                        {!! Form::label('last_name', __('Last Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('last_name', old('last_name'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Last Name') ]) !!} @if($errors->first('last_name'))
                                <div class="help-block">{{$errors->first('last_name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('email') ? 'has-error' :  ''}}">
                        {!! Form::label('email', __('Email'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::email('email', old('email'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Email') ]) !!}
                            @if($errors->first('email'))
                                <div class="help-block">{{$errors->first('email')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('mobile') ? 'has-error' :  ''}}">
                        {!! Form::label('mobile', __('Mobile'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('mobile', old('mobile'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Mobile') ]) !!}
                            @if($errors->first('mobile'))
                                <div class="help-block">{{$errors->first('mobile')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('gender', __('Gender'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::radio('gender', 'M' , false , ['required'=>'required' ]) !!}
                            @lang('Male') {!! Form::radio('gender', 'F' , false , ['required'=>'required' ]) !!} @lang('Female')
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('city_id') ? 'has-error' :  ''}}">
                        {!! Form::label('city_id', __('City'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('city_id', $cities, null,['class' => 'form-control','required'=>'required','placeholder'=>__('Select')]) !!}
                            @if($errors->first('city_id'))
                                <div class="help-block">{{$errors->first('city_id')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('role_id') ? 'has-error' :  ''}}">
                        {!! Form::label('role_id', __('The Role'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('role_id', $roles, null,['class' => 'form-control','required'=>'required','placeholder'=>__('The Role')]) !!}
                            @if($errors->first('role_id'))
                                <div class="help-block">{{$errors->first('role_id')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('password') ? 'has-error' :  ''}}">
                        {!! Form::label('password', __('Password'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::password('password', ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Password') ]) !!} 
                            @if($errors->first('password'))
                                <div class="help-block">{{$errors->first('password')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('confirm_password') ? 'has-error' :  ''}}">
                        {!! Form::label('confirm_password', __('Confirm Password'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::password('password_confirmation', ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Confirm Password') ]) !!} 
                            @if($errors->first('confirm_password'))
                                <div class="help-block">{{$errors->first('confirm_password')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_list', __('Mail List'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::checkbox('mail_list','yes',['class' => 'form-control',]) !!} @lang('Subscription')
                        </div>
                    </div>
                    <div class="col-sm-10">
                    </div>
                    <div class="col-sm-2 ">
                        <button type="submit" class="btn btn-success btn-block btn-flat pull-left">@lang('Save')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
