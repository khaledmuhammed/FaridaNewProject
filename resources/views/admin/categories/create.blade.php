@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Add') @lang('Category')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['action' => 'Admin\CategoryController@store','class'=>'form-horizontal','method' => 'POST','enctype'=>'multipart/form-data']) !!}
                {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                        {!! Form::label('name', __('Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', old('name'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Name' )]) !!}
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('name_ar') ? 'has-error' :  ''}}">
                        {!! Form::label('name_ar', __('Arabic Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name_ar', old('name_ar'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Arabic Name' )]) !!}
                            @if($errors->first('name_ar'))
                                <div class="help-block">{{$errors->first('name_ar')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group ">
                        {!! Form::label('super_category_id', __('Super Category Name'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('super_category_id',$categories , null, ['placeholder' => __('select'),'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_active', __('Is Active?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::radio('is_active', '1' , false  , ['required'=>'required' ]) !!}
                            @lang('Yes')
                            {!! Form::radio('is_active', '0' , true  , ['required'=>'required' ]) !!}
                            @lang('No')
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_featured', __('Is Featured?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::radio('is_featured', '1' , false  , ['required'=>'required' ]) !!}
                            @lang('Yes')
                            {!! Form::radio('is_featured', '0' , true  , ['required'=>'required' ]) !!}
                            @lang('No')
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
                        <button type="submit" class="btn btn-info btn-block btn-flat">@lang('Add')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
