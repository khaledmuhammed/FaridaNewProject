@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Edit') @lang('Blocks') {{$block->id}}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($block, ['action' => ['Admin\BlockController@update', $block->id], 'method' => 'put','class'=>'form-horizontal','enctype'=>'multipart/form-data'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('title') ? 'has-error' :  ''}}">
                        {!! Form::label('title', __('Title'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('title', $block->title, ['class' => 'form-control', 'placeholder'=>__('Title') ]) !!}
                            @if($errors->first('title'))
                                <div class="help-block">{{$errors->first('title')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('description') ? 'has-error' :  ''}}">
                        {!! Form::label('description', __('Description'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('description', $block->description, ['class' => 'form-control', 'placeholder'=>__('Description') ]) !!}
                            @if($errors->first('description'))
                                <div class="help-block">{{$errors->first('description')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('title') ? 'has-error' :  ''}}">
                        {!! Form::label('text_button', __('Text button'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('text_button', $block->text_button, ['class' => 'form-control', 'placeholder'=>__('Text button') ]) !!}
                            @if($errors->first('text_button'))
                                <div class="help-block">{{$errors->first('text_button')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('title') ? 'has-error' :  ''}}">
                        {!! Form::label('link_button', __('Link'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('link_button', $block->link_button, ['class' => 'form-control', 'placeholder'=>__('Link') ]) !!}
                            @if($errors->first('link_button'))
                                <div class="help-block">{{$errors->first('link_button')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('image', __('Thumbnail'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            @if ($block->getFirstMedia('image'))
                            <img class="img-viewer" src="{{$block->getFirstMedia('image')->getUrl()}}" width="600" />
                            @endif
                            {!! Form::file('image', ['class' => 'form-control img-updater']) !!}
                            {!! Form::hidden('delete_image', false, ['class' => 'form-control delete_image' ]) !!}
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat ">@lang('Save')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        //remove old image preview
        $('.img-updater').change(function () {
            readURL(this, $(this).closest('.box-body').find('.img-viewer'));
        });

        function readURL(input, el) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(el).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection