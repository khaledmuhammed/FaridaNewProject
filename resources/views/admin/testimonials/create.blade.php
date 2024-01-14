@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Testimonials')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['action' => 'Admin\TestimonialController@store','class'=>'form-horizontal','method' => 'POST','enctype'=>'multipart/form-data']) !!}
                {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group {{$errors->first('username') ? 'has-error' :  ''}}">
                        {!! Form::label('username', __('Username'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('username', old('username'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Username') ]) !!} @if($errors->first('username'))
                                <div class="help-block">{{$errors->first('username')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('title') ? 'has-error' :  ''}}">
                        {!! Form::label('title', __('Title'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('title', old('title'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Title') ]) !!} @if($errors->first('title'))
                                <div class="help-block">{{$errors->first('title')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('comment') ? 'has-error' :  ''}}">
                        {!! Form::label('comment', __('Comment'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('comment', old('comment'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Comment') ]) !!} @if($errors->first('comment'))
                                <div class="help-block">{{$errors->first('comment')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('featured', __('Featured') . __('?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <toggler name="featured" :old="0"></toggler>
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('thumbnail') ? 'has-error' :  ''}}">
                        {!! Form::label('thumbnail',__('Thumbnail'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::file('thumbnail', ['class' => 'form-control']) !!}
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
