@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Add')  @lang('Page')</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['action' => 'Admin\PageController@store','class'=>'form-horizontal','method' => 'POST', 'enctype'=>'multipart/form-data']) !!}
                {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group {{$errors->first('title') ? 'has-error' :  ''}}">
                        {!! Form::label('title', __('Title'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('title', old('title'), ['class' => 'form-control','required'=>'required']) !!}
                            @if($errors->first('title'))
                                <div class="help-block">{{$errors->first('title')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('title_ar') ? 'has-error' :  ''}}">
                        {!! Form::label('title_ar', __('Arabic Title'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('title_ar', old('title_ar'), ['class' => 'form-control','required'=>'required']) !!}
                            @if($errors->first('title_ar'))
                                <div class="help-block">{{$errors->first('title_ar')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('content', __('Content Page'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <textarea id="content" name="content"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('content_ar', __('Arabic Content Page'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <textarea id="content_ar" name="content_ar"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_active', __('Is Show?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <toggler name="is_active" :old="0"></toggler>
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-success btn-block btn-flat">@lang('Save')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('js')
<!-- include summernote css/js-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/lang/summernote-ar-AR.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#content').summernote({
          height: 150,      // set editor height
          minHeight: null,  // set minimum height of editor
          maxHeight: null,  // set maximum height of editor
          lang: 'ar-AR'     // default: 'en-US'
    });
    $('#content_ar').summernote({
          height: 150,      // set editor height
          minHeight: null,  // set minimum height of editor
          maxHeight: null,  // set maximum height of editor
          lang: 'ar-AR'     // default: 'en-US'
    });
});
</script>
@endsection