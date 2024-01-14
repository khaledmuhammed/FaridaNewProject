@extends('adminlte::page')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Add') @lang('Package')</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['action' => 'Admin\PackageController@store','class'=>'form-horizontal','method' => 'POST','enctype'=>'multipart/form-data']) !!}
                {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                        {!! Form::label('name', __('Package Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', old('name'), ['class' => 'form-control','required'=>'required'  ]) !!}
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('name_en') ? 'has-error' :  ''}}">
                        {!! Form::label('name_en', __('Package English Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name_en', old('name_en'), ['class' => 'form-control','required'=>'required'  ]) !!}
                            @if($errors->first('name_en'))
                                <div class="help-block">{{$errors->first('name_en')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('description') ? 'has-error' :  ''}}">
                        {!! Form::label('description', __('Description'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('description', old('description'), ['class' => 'form-control','required'=>'required' , 'placeholder'=> __('Description') ]) !!}
                            @if($errors->first('description'))
                                <div class="help-block">{{$errors->first('description')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('description_en') ? 'has-error' :  ''}}">
                        {!! Form::label('description_en', __('English Description'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('description_en', old('description_en'), ['class' => 'form-control','required'=>'required' , 'placeholder'=> __('English Description') ]) !!}
                            @if($errors->first('description_en'))
                                <div class="help-block">{{$errors->first('description_en')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('product_id') ? 'has-error' :  ''}}">
                        {!! Form::label('product_id', __('Products'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <package-product-select :multiple="true" :calc_total="true">
                            </package-product-select>
                        </div>
                    </div>
                    <div class="form-group ">
                        {!! Form::label('price', __("Products' Total Price"), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10" style="padding-top: 7px;">
                            <span id="total" v-text="totalProductPrice"></span> ريال
                        </div>
                    </div>

                    <div class="form-group {{$errors->first('price') ? 'has-error' :  ''}}">
                        {!! Form::label('price', __("Package Price"), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::number('price', old('price'), ['class' => 'form-control','required'=>'required'  ]) !!}
                            @if($errors->first('price'))
                                <div class="help-block">{{$errors->first('price')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('quantity') ? 'has-error' :  ''}}">

                        {!! Form::label('quantity', __('Quantity'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::number('quantity', old('quantity'), ['class' => 'form-control','required'=>'required'  ]) !!}
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('quantity')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('availability', __('Available?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <toggler name="availability" :old="0"></toggler>
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('availability_date') ? 'has-error' :  ''}}">
                        {!! Form::label('availability_date', __('Availability Date'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <datepicker name="availability_date"
                                        :format="$root.dateFormatter"
                                        input-class="form-control not-readonly"
                                        :language="lang.{{app()->getLocale()}}"
                            ></datepicker>
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('availability_date')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('shipping_free', __('Shipping Free?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <toggler name="shipping_free" :old="0"></toggler>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('payment_free', __('Payment Free?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <toggler name="payment_free" :old="0"></toggler>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('image', __('Thumbnail'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            {!! Form::file('image', ['class' => 'form-control']) !!}
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

