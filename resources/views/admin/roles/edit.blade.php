@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Edit') @lang('Role')</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($role, ['action' => ['Admin\RoleController@update', $role->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                        {!! Form::label('name', __('Role Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', $role->name, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Role Name') ]) !!}
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('name_ar') ? 'has-error' :  ''}}">
                        {!! Form::label('name_ar', __('Role Name (ar)'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name_ar', $role->name_ar, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Role Name') ]) !!}
                            @if($errors->first('name_ar'))
                                <div class="help-block">{{$errors->first('name_ar')}}</div>
                            @endif
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
