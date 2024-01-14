@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Edit') @lang('Shipping Method')</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($shippingMethod, ['action' => ['Admin\ShippingMethodController@update', $shippingMethod->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                        {!! Form::label('name', __('Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', $shippingMethod->name, ['class' => 'form-control','required'=>'required' , 'placeholder'=>'role name' ]) !!}
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('name_ar') ? 'has-error' :  ''}}">
                        {!! Form::label('name_ar', __('Arabic Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name_ar', $shippingMethod->name_ar, ['class' => 'form-control','required'=>'required' , 'placeholder'=> __('Arabic Name') ]) !!}
                            @if($errors->first('name_ar'))
                                <div class="help-block">{{$errors->first('name_ar')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('price') ? 'has-error' :  ''}}">
                        {!! Form::label('price', __('Cost'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">

                            {!! Form::text('price', $shippingMethod->price, ['class' => 'form-control','required'=>'required' , 'placeholder'=>'price' ,]) !!}
                            @if($errors->first('price'))
                                <div class="help-block">{{$errors->first('price')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_active', __('Active?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <toggler name="is_active" :old="{{$shippingMethod->is_active}}"></toggler>

                        </div>
                    </div>
                    <div class="form-group {{$errors->first('city_id') ? 'has-error' :  ''}}">
                        {!! Form::label('city_id', __('Cities'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">

                            <city-select
                                    :cities="{{$cities}}"
                                    :old="{{$shippingMethod->cities}}"
                            ></city-select>
                            <div class="help-block">{{$errors->first('city_id')}}</div>
                        </div>
                    </div>

                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat">@lang('Save')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Cash On Delivery Enabled Cities')</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($shippingMethod, ['action' => ['Admin\ShippingMethodController@cashOnDelivery', $shippingMethod->id], 'method' => 'POST','class'=>'form-horizontal'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('city_id') ? 'has-error' :  ''}}">
                        {!! Form::label('city_id', __('Cities'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">

                            <city-select
                                    :cities="{{$shippingMethod->cities}}"
                                    :old="{{$shippingMethod->cashOnDeliveryCities}}"
                            ></city-select>
                            <div class="help-block">{{$errors->first('city_id')}}</div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat">@lang('Update')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
