@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Edit') @lang('Address')</h3>
                </div>
                {!!Form::model($address, ['action' => ['Admin\AddressController@update', $address->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('first_name') ? 'has-error' :  ''}}">
                        {!! Form::label('first_name', __('First Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('first_name', $address->first_name,['class' => 'form-control','required'=>'required' , 'placeholder'=>__('First Name') ]) !!}
                            @if($errors->first('first_name'))
                                <div class="help-block">{{$errors->first('first_name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('last_name') ? 'has-error' :  ''}}">
                        {!! Form::label('last_name', __('Last Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('last_name', $address->last_name,['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Last Name') ]) !!}
                            @if($errors->first('last_name'))
                                <div class="help-block">{{$errors->first('last_name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('city_id') ? 'has-error' :  ''}}">
                        {!! Form::label('city_id', __('City'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('city_id', $cities, $address->city_id,['class' => 'form-control','required'=>'required' , 'placeholder'=>__('City') ]) !!}
                            @if($errors->first('city_id'))
                                <div class="help-block">{{$errors->first('city_id')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('details') ? 'has-error' :  ''}}">
                        {!! Form::label('details', __('Details'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('details', $address->details, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Details') ]) !!}
                            @if($errors->first('details'))
                                <div class="help-block">{{$errors->first('details')}}</div>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="form-group {{$errors->first('district') ? 'has-error' :  ''}}">
                        {!! Form::label('district', __('District'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('district', $address->district,['class' => 'form-control','required'=>'required' , 'placeholder'=>__('District') ]) !!}
                            @if($errors->first('district'))
                                <div class="help-block">{{$errors->first('district')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('street') ? 'has-error' :  ''}}">
                        {!! Form::label('street', __('Street'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('street', $address->street,['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Street') ]) !!}
                            @if($errors->first('street'))
                                <div class="help-block">{{$errors->first('street')}}</div>
                            @endif
                        </div>
                    </div> --}}

                    <div class="col-sm-2 col-sm-offset-10 no-padding ">
                        <button type="submit" class="btn btn-info btn-block btn-flat pull-left">@lang('Save')</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
