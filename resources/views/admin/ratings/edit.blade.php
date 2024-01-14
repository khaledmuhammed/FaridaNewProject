@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Edit') @lang('Rating')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($rating, ['action' => ['Admin\RatingController@update', $rating->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('product_id') ? 'has-error' :  ''}}">
                        {!! Form::label('product_id', __('Product Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('product_id',$products , $rating->product_id, ['placeholder' => 'select','class' => 'form-control']) !!} @if($errors->first('product_id'))
                                <div class="help-block">{{$errors->first('product_id')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('rating') ? 'has-error' :  ''}}">
                        {!! Form::label('rating', __('Rating'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('rating', $rating->rating, ['class' => 'form-control','required'=>'required'  ]) !!}
                            @if($errors->first('rating'))
                                <div class="help-block">{{$errors->first('rating')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('comment') ? 'has-error' :  ''}}">
                        {!! Form::label('comment', __('Comment'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('comment', $rating->comment, ['class' => 'form-control','required'=>'required'  ,]) !!}
                            @if($errors->first('comment'))
                                <div class="help-block">{{$errors->first('comment')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('user_id') ? 'has-error' :  ''}}">
                        {!! Form::label('user_id', __('Client Name'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('user_id', $rating->user->firstName, ['class' => 'form-control','required'=>'required'  ,]) !!}
                            @if($errors->first('user_id'))
                                <div class="help-block">{{$errors->first('user_id')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group ">
                        {!! Form::label('approved', __('Approved?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::radio('approved', '1' , $rating->availability  , ['required'=>'required' ]) !!}
                            @lang('Yes') {!! Form::radio('approved', '0', $rating->availability , ['required'=>'required' ]) !!}
                            @lang('No')
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat">@lang('Save')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
