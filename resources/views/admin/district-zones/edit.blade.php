@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Edit') @lang('Zone')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($districtZone, ['action' => ['Admin\DistrictZoneController@update', $districtZone->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                        {!! Form::label('name', __('Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', $districtZone->name, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Name') ]) !!} @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('shipping_price') ? 'has-error' :  ''}}">
                        {!! Form::label('shipping_price', __('Shipping Price'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('shipping_price', $districtZone->shipping_price, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Shipping Price') ]) !!} @if($errors->first('shipping_price'))
                                <div class="help-block">{{$errors->first('shipping_price')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('city_id') ? 'has-error' :  ''}}">
                        {!! Form::label('city_id', __('City'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('city_id', $cities, $districtZone->city_id,['class' => 'form-control','required'=>'required' , 'placeholder'=>__('City') ]) !!} @if($errors->first('city_id'))
                                <div class="help-block">{{$errors->first('city_id')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat pull-left">@lang('Save')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
