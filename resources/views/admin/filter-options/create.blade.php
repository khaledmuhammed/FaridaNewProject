@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Add') @lang('Filter Option')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['action' => 'Admin\FilterOptionController@store','class'=>'form-horizontal','method' => 'POST']) !!}
                {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                        {!! Form::label('name', __('English Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', old('name'), ['class' => 'form-control','required'=>'required']) !!}
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('name_ar') ? 'has-error' :  ''}}">
                        {!! Form::label('name_ar', __('Arabic Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name_ar', old('name_ar'), ['class' => 'form-control','required'=>'required']) !!}
                            @if($errors->first('name_ar'))
                                <div class="help-block">{{$errors->first('name_ar')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('filter_id') ? 'has-error' :  ''}}">
                        {!! Form::label('filter_id', __('Filter Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('filter_id',$filters , null, ['placeholder' => __('select'),'class' => 'form-control']) !!}
                            @if($errors->first('filter_id'))
                                <div class="help-block">{{$errors->first('filter_id')}}</div>
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
