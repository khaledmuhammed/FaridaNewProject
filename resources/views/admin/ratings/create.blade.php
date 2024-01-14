@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Add')</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['action' => 'Admin\RatingController@store','class'=>'form-horizontal','method' => 'POST']) !!} {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                        {!! Form::label('comment', 'comment', ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('comment', old('name'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>'role name' ]) !!}
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('guard_name') ? 'has-error' :  ''}}">
                        {!! Form::label('product_id', 'product_id', ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">

                            {!! Form::text('product_id', old('guard_name'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>'guard role name' ,]) !!}
                            @if($errors->first('guard_name'))
                                <div class="help-block">{{$errors->first('guard_name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('guard_name') ? 'has-error' :  ''}}">
                        {!! Form::label('approved', 'approved', ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">

                            {!! Form::text('approved', old('guard_name'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>'guard role name' ,]) !!}
                            @if($errors->first('guard_name'))
                                <div class="help-block">{{$errors->first('guard_name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('guard_name') ? 'has-error' :  ''}}">
                        {!! Form::label('rating', 'rating', ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">

                            {!! Form::text('rating', old('guard_name'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>'guard role name' ,]) !!}
                            @if($errors->first('guard_name'))
                                <div class="help-block">{{$errors->first('guard_name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10">
                        <button type="submit" class="btn btn-info btn-block btn-flat">@lang('Add')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
