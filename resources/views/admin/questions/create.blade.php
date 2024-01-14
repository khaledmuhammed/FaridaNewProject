@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Add') @lang('Question')</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['action' => 'Admin\QuestionController@store','class'=>'form-horizontal','method' => 'POST']) !!}
                {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group {{$errors->first('product_id') ? 'has-error' :  ''}}">
                        {!! Form::label('product_id', __('') .__('Product'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('product_id',$products , null, ['placeholder' => __('select'),'class' => 'form-control']) !!} @if($errors->first('product_id'))
                                <div class="help-block">{{$errors->first('product_id')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('text') ? 'has-error' :  ''}}">
                        {!! Form::label('text', __('') .__('Question'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('text', old('text'), ['class' => 'form-control','required'=>'required' , ]) !!}
                            @if($errors->first('text'))
                                <div class="help-block">{{$errors->first('text')}}</div>
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
