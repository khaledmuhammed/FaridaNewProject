@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Edit') @lang('Coupon')</h3>
                </div>
                {!!Form::model($coupon, ['action' => ['Admin\CouponController@update', $coupon->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('title') ? 'has-error' :  ''}}">
                        {!! Form::label('title', __('Title'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('title', $coupon->title, ['class' => 'form-control','required'=>'required']) !!}
                            @if($errors->first('title'))
                                <div class="help-block">{{$errors->first('title')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('code') ? 'has-error' :  ''}}">
                        {!! Form::label('code', __('Code'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('code', $coupon->code, ['class' => 'form-control','required'=>'required']) !!}
                            @if($errors->first('code'))
                                <div class="help-block">{{$errors->first('code')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('type') ? 'has-error' :  ''}}">
                        {!! Form::label('type', __('Apply On'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('type', $couponTypes ,$coupon->type, ['class' => 'form-control','required'=>'required'  ,]) !!}
                            @if($errors->first('type'))
                                <div class="help-block">{{$errors->first('type')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('calc') ? 'has-error' :  ''}}">
                        {!! Form::label('calc', __('Calc Method'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('calc', $couponCalc ,$coupon->calc, ['class' => 'form-control','required'=>'required'  ,]) !!}
                            @if($errors->first('calc'))
                                <div class="help-block">{{$errors->first('calc')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('amount') ? 'has-error' :  ''}}">
                        {!! Form::label('amount', __('Amount'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            <div class="input-group">
                                {!! Form::number('amount',$coupon->amount, ['class' => 'form-control flat','required'=>'required','step'=>'0.01']) !!}
                                <span class="input-group-addon flat">@lang('SR')</span>
                            </div>
                            @if($errors->first('amount'))
                                <div class="help-block">{{$errors->first('amount')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('start_date') ? 'has-error' :  ''}}">
                        {!! Form::label('start_date', __('Start Date'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            <datepicker name="start_date"
                                        :format="$root.dateFormatter"
                                        input-class="form-control not-readonly"
                                        :language="lang.{{app()->getLocale()}}"
                                        :value="dateFormatter('{{$coupon->start_date}}')"
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
                                        :value="dateFormatter('{{$coupon->end_date}}')"
                            ></datepicker>
                            @if($errors->first('end_date'))
                                <div class="help-block">{{$errors->first('end_date')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group has-feedback {{$errors->first('minimum') ? 'has-error' :  ''}}">
                        {!! Form::label('minimum', __('Minimum Amount'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            <div class="input-group">
                                {!! Form::number('minimum',$coupon->minimum, ['class' => 'form-control flat','required'=>'required'  ,'step'=>'0.01']) !!}
                                <span class="input-group-addon flat">@lang('SR')</span>
                            </div>
                            <h6 class="help-block">0 = @lang('no minimum amount applied')</h6>
                            @if($errors->first('minimum'))
                                <div class="help-block">{{$errors->first('minimum')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group has-feedback{{$errors->first('usage_limit') ? 'has-error' :  ''}}">
                        {!! Form::label('usage_limit', __('Usage Limit'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            {!! Form::number('usage_limit',$coupon->usage_limit, ['class' => 'form-control','required'=>'required'  ,]) !!}
                            <h6 class="help-block">0 = @lang('unlimited usage')</h6>
                            @if($errors->first('usage_limit'))
                                <div class="help-block">{{$errors->first('usage_limit')}}</div>
                            @endif
                        </div>
                    </div>
                    <couponables
                            :types="{{$couponableTypes}}"
                            old="{{$coupon->couponable_type}}"
                            :old_product="{{$coupon->products}}"
                            :old_category="{{$coupon->categories}}"
                            :old_manufacturer="{{$coupon->manufacturers}}"
                            :old_payment_method="{{$coupon->paymentMethods}}"
                            :categories="{{$categories}}"
                            :manufacturers="{{$manufacturers}}"
                            :payment_methods="{{$paymentMethods}}"
                    ></couponables>
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat">@lang('Save')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
