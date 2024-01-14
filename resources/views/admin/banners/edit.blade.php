@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Edit') @lang('Banner')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($banner, ['action' => ['Admin\BannerController@update', $banner->id], 'method' => 'put','class'=>'form-horizontal','enctype'=>'multipart/form-data'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('title') ? 'has-error' :  ''}}">
                        {!! Form::label('title', __('Title'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('title', $banner->title, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Title') ]) !!}
                            @if($errors->first('title'))
                                <div class="help-block">{{$errors->first('title')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('size') ? 'has-error' :  ''}}">
                        {!! Form::label('size', __('Size'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('size',["3"=>3,"6"=>6,"9"=>9,"12"=>12] , $banner->size, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Size') ]) !!}
                            @if($errors->first('size'))
                                <div class="help-block">{{$errors->first('size')}}</div>
                            @endif
                        </div>
                    </div>
                    <linked-images></linked-images>

                </div>
                <div class="box-footer">
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat ">@lang('Save')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Edit') @lang('Banner Images')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <linked-images-edit :images="{{$banner->getMedia('banners') }}"></linked-images-edit>
                </div>
            </div>
        </div>
    </div>
@endsection
