@extends('adminlte::page')

@section('css')
    <style>
        .img-viewer {
            width   : 200px;
            display : block;
            margin  : 10px auto;
        }
    </style>
@endsection
@section('content')
    <div class="col-xs-12">
        <div class="box box-info ">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('Category Edit')</h3>
            </div>
            {!!Form::model($category, ['action' => ['Admin\CategoryController@update', $category->id], 'method' => 'put','class'=>'form-horizontal','enctype'=>'multipart/form-data'])!!}
            <div class="box-body">
                <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                    {!! Form::label('name', __('Name'), ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('name', $category->name, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Name' )]) !!} @if($errors->first('name'))
                            <div class="help-block">{{$errors->first('name')}}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group {{$errors->first('name_ar') ? 'has-error' :  ''}}">
                    {!! Form::label('name_ar', __('Arabic Name'), ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('name_ar', $category->name_ar, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Arabic Name' )]) !!} @if($errors->first('name_ar'))
                            <div class="help-block">{{$errors->first('name_ar')}}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    {!! Form::label('super_category_id', __('Super Category Name'), ['class' => 'control-label col-sm-2 ']) !!}
                    <div class="col-sm-10">

                        {!! Form::select('super_category_id',$categories,$category->super_category_id , ['placeholder' => 'select','class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-sm-12">
                    <img class="img-viewer" src="{{ $thumbnail }}">
                </div>

                <div class="form-group {{$errors->first('thumbnail') ? 'has-error' :  ''}}">
                    {!! Form::label('thumbnail', __('Thumbnail'), ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        {!! Form::file('thumbnail', ['class' => 'form-control img-updater','accept'=>'image/*']) !!}
                        @if($errors->first('thumbnail'))
                            <div class="help-block">{{$errors->first('thumbnail')}}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    {!! Form::label('is_active', __('Is Active?'), ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        <label class="radio-inline"><input type="radio" name="is_active" value="1"
                                                           required {{$category->is_active == '1'? 'checked' : ''}}>@lang('Yes')
                        </label>
                        &nbsp;
                        <label class="radio-inline"><input type="radio" name="is_active" value="0"
                                                           required {{$category->is_active == '0' ? 'checked' : ''}}>@lang('No')
                        </label>
                    </div>
                </div>
                <div class="form-group ">
                    {!! Form::label('is_featured', __('Is Featured?'), ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        <label class="radio-inline"><input type="radio" name="is_featured" value="1"
                                                           required {{$category->is_featured == '1'? 'checked' : ''}}>@lang('Yes')
                        </label>
                        &nbsp;
                        <label class="radio-inline"><input type="radio" name="is_featured" value="0"
                                                           required {{$category->is_featured == '0' ? 'checked' : ''}}>@lang('No')
                        </label>
                    </div>
                </div>
                <div class="form-group {{$errors->first('filter_id') ? 'has-error' :  ''}}">
                    {!! Form::label('filter_id', __('Filters'), ['class' => 'control-label col-sm-2']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('filter_id[]',$filters , $category->filters, ['placeholder' => __('select'),'class' => 'form-control','multiple']) !!}
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

    </script>@endsection