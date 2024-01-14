@extends('adminlte::page')

@section('css')
{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">--}}
@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Add') @lang('Featured Products')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    {!! Form::open(['action' => 'Admin\FeaturedProductController@store','class'=>'form-horizontal','method' => 'POST']) !!}
                    {{csrf_field()}}
                    <div class="form-group {{$errors->first('title') ? 'has-error' :  ''}}">
                        {!! Form::label('title', __('Title'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('title', old('title'), ['class' => 'form-control','required'=>'required' ]) !!}
                            @if($errors->first('title'))
                                <div class="help-block">{{$errors->first('title')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('title_ar') ? 'has-error' :  ''}}">
                        {!! Form::label('title_ar', __('Arabic Title'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('title_ar', old('title_ar'), ['class' => 'form-control','required'=>'required' ]) !!}
                            @if($errors->first('title_ar'))
                                <div class="help-block">{{$errors->first('title_ar')}}</div>
                            @endif
                        </div>
                    </div>
                    {{--
                    <div class="form-group {{$errors->first('products') ? 'has-error' :  ''}}">
                        {!! Form::label('products', __('Products'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <product-select :multiple="true" name="products"></product-select>
                        </div>
                    </div>
                    --}}

                    <featured-products 
                        :products-error="{{$errors->first('products') ? 'true':'false'}}"
                        :category-error="{{$errors->first('category') ? 'true':'false'}}"
                        :categories="{{$categories}}"
                    ></featured-products>


                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat">@lang('Save')</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Latest compiled and minified JavaScript -->
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>--}}
@endsection
