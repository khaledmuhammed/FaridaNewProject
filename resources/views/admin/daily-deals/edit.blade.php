@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Edit') @lang('Daily Deal')</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($dailyDeal, ['action' => ['Admin\DailyDealController@update', $dailyDeal->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('product_id') ? 'has-error' :  ''}}">
                        {!! Form::label('product_id', __('Product Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <product-select name="product_id"
                                            :selected="{{$dailyDeal->product}}"
                                            :multiple="false">

                            </product-select>
                            {{--                            {!! Form::select('product_id',$products , $dailyDeal->product_id, ['placeholder' => 'select','class' => 'form-control']) !!}--}}
                            @if($errors->first('product_id'))
                                <div class="help-block">{{$errors->first('product_id')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('price') ? 'has-error' :  ''}}">
                        {!! Form::label('price', __('Price'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::number('price', $dailyDeal->price, ['class' => 'form-control','required'=>'required' , 'placeholder'=>'price' ]) !!}
                            @if($errors->first('price'))
                                <div class="help-block">{{$errors->first('price')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('quantity') ? 'has-error' :  ''}}">
                        {!! Form::label('quantity', __('Quantity'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::number('quantity', $dailyDeal->quantity, ['class' => 'form-control', 'placeholder'=>'quantity' ]) !!}
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('quantity')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('start_date') ? 'has-error' :  ''}}">
                        {!! Form::label('start_date', __('Start Date'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <datepicker name="start_date"
                                        :format="$root.dateFormatter"
                                        input-class="form-control not-readonly"
                                        :language="lang.{{app()->getLocale()}}"
                                        :value="dateFormatter('{{$dailyDeal->start_date}}')"
                            ></datepicker>
                            @if($errors->first('start_date'))
                                <div class="help-block">{{$errors->first('start_date')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('end_date') ? 'has-error' :  ''}}">
                        {!! Form::label('end_date', __('End Date'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            <datepicker name="end_date"
                                        :format="$root.dateFormatter"
                                        input-class="form-control not-readonly"
                                        :language="lang.{{app()->getLocale()}}"
                                        :value="dateFormatter('{{$dailyDeal->end_date}}')"
                            ></datepicker>
                            @if($errors->first('end_date'))
                                <div class="help-block">{{$errors->first('end_date')}}</div>
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
    </div>
@endsection
