@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Edit') @lang('User')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($user, ['action' => ['Admin\UserController@update', $user->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('first_name') ? 'has-error' :  ''}}">
                        {!! Form::label('first_name', __('First Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('first_name', $user->first_name, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('first name') ]) !!}
                            @if($errors->first('first_name'))
                                <div class="help-block">{{$errors->first('first_name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('last_name') ? 'has-error' :  ''}}">
                        {!! Form::label('last_name', __('Last Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('last_name', $user->last_name, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('last name') ]) !!}
                            @if($errors->first('last_name'))
                                <div class="help-block">{{$errors->first('last_name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('email') ? 'has-error' :  ''}}">
                        {!! Form::label('email', __('Email'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::email('email',$user->email, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('email') ]) !!}
                            @if($errors->first('email'))
                                <div class="help-block">{{$errors->first('email')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('mobile') ? 'has-error' :  ''}}">
                        {!! Form::label('mobile', __('Mobile'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('mobile', $user->mobile, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('mobile') ]) !!}

                            @if($errors->first('mobile'))
                                <div class="help-block">{{$errors->first('mobile')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('gender', __('Gender'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::radio('gender', 'M', $user->gender == 'M' , ['required'=>'required' ]) !!} @lang('Male')
                            {!! Form::radio('gender', 'F' , $user->gender == 'F'  , ['required'=>'required' ]) !!} @lang('Female')
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('city_id') ? 'has-error' :  ''}}">
                        {!! Form::label('city_id', __('City'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('city_id', $cities, $user->city_id,['class' => 'form-control','required'=>'required']) !!}
                            @if($errors->first('city_id'))
                                <div class="help-block">{{$errors->first('city_id')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('role_id') ? 'has-error' :  ''}}">
                        {!! Form::label('role_id', __('The Role'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('role_id', $roles, $user->role_id,['class' => 'form-control','required'=>'required']) !!}
                            @if($errors->first('role_id'))
                                <div class="help-block">{{$errors->first('role_id')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('password') ? 'has-error' :  ''}}">
                        {!! Form::label('password', __('Password'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::password('password', ['class' => 'form-control' , 'placeholder'=>__('Password') ]) !!} 
                            @if($errors->first('password'))
                                <div class="help-block">{{$errors->first('password')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('confirm_password') ? 'has-error' :  ''}}">
                        {!! Form::label('confirm_password', __('Confirm Password'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::password('password_confirmation', ['class' => 'form-control' , 'placeholder'=>__('Confirm Password') ]) !!} 
                            @if($errors->first('confirm_password'))
                                <div class="help-block">{{$errors->first('confirm_password')}}</div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-sm-2 col-sm-offset-10 no-padding ">
                        <button type="submit" class="btn btn-info btn-block btn-flat pull-left">@lang('Save')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
