@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Banner</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    {!! Form::open(['action' => 'Admin\BannerController@store','class'=>'form-horizontal','method' => 'POST','enctype'=>'multipart/form-data']) !!}
                    {{csrf_field()}}
                    <div class="form-group {{$errors->first('title') ? 'has-error' :  ''}}">
                        {!! Form::label('title', 'title', ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('title', old('title'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>'title' ]) !!}
                            @if($errors->first('title'))
                                <div class="help-block">{{$errors->first('title')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('size') ? 'has-error' :  ''}}">
                        {!! Form::label('size', 'Size', ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('size',["3"=>3,"6"=>6,"9"=>9,"12"=>12] , old('size'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>'size' ]) !!}
                            @if($errors->first('size'))
                                <div class="help-block">{{$errors->first('size')}}</div>
                            @endif
                        </div>
                    </div>
                    <linked-images></linked-images>

                    <div class="row">
                        <div class="col-sm-2 pull-right">
                            <button type="submit" class="  btn btn-info btn-block btn-flat">Add</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
