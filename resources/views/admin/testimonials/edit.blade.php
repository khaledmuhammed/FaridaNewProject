@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Edit') @lang('Testimonial')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($testimonial, ['action' => ['Admin\TestimonialController@update', $testimonial->id], 'method' => 'put','class'=>'form-horizontal','enctype'=>'multipart/form-data'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('username') ? 'has-error' :  ''}}">
                        {!! Form::label('username', __('Username'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('username', $testimonial->username, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Username') ]) !!} @if($errors->first('username'))
                                <div class="help-block">{{$errors->first('username')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('title') ? 'has-error' :  ''}}">
                        {!! Form::label('title', __('Title'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('title', $testimonial->title, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Title') ]) !!} @if($errors->first('title'))
                                <div class="help-block">{{$errors->first('title')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('comment') ? 'has-error' :  ''}}">
                        {!! Form::label('comment', __('Comment'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('comment', $testimonial->comment, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Comment') ]) !!} @if($errors->first('comment'))
                                <div class="help-block">{{$errors->first('comment')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('featured', __('Featured').__('?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <toggler name="featured" :old="{{$testimonial->featured}}"></toggler>
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('thumbnail') ? 'has-error' :  ''}}">
                        {!! Form::label('thumbnail', __('Thumbnail'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            @if ($testimonial->getFirstMedia('thumbnail'))
                                <img class="img-viewer" src="{{$testimonial->getFirstMedia('thumbnail')->getUrl()}}" width="200" />
                            @endif
                            {!! Form::file('thumbnail', ['class' => 'form-control img-updater','accept'=>'image/*']) !!}
                            @if($errors->first('thumbnail'))
                                <div class="help-block">{{$errors->first('thumbnail')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat pull-left">@lang('Save')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
