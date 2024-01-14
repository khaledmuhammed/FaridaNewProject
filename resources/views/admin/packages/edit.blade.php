@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"> @lang('Edit') @lang('Package')</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($package, ['action' => ['Admin\PackageController@update', $package->id], 'method' => 'put','class'=>'form-horizontal','enctype'=>'multipart/form-data'])!!}
                <div class="box-body">
                    <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                        {!! Form::label('name', __('Package Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', $package->name, ['class' => 'form-control','required'=>'required' , 'placeholder'=> __('Package Name') ]) !!}
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('name_en') ? 'has-error' :  ''}}">
                        {!! Form::label('name_en', __('Package English Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name_en', $package->name_en, ['class' => 'form-control','required'=>'required' , 'placeholder'=> __('Package English Name') ]) !!}
                            @if($errors->first('name_en'))
                                <div class="help-block">{{$errors->first('name_en')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('description') ? 'has-error' :  ''}}">
                        {!! Form::label('description', __('Description'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('description', $package->description, ['class' => 'form-control','required'=>'required' , 'placeholder'=> __('Description') ]) !!}
                            @if($errors->first('description'))
                                <div class="help-block">{{$errors->first('description')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('description_en') ? 'has-error' :  ''}}">
                        {!! Form::label('description_en', __('English Description'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('description_en', $package->description_en, ['class' => 'form-control','required'=>'required' , 'placeholder'=> __('English Description') ]) !!}
                            @if($errors->first('description_en'))
                                <div class="help-block">{{$errors->first('description_en')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('product_id') ? 'has-error' :  ''}}">
                        {!! Form::label('product_id', __('Products'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <package-product-select :multiple="true"
                                            :selected="{{$selectedProducts}}"
                                            :calc_total="true">
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
                            {!! Form::text('price', $package->price, ['class' => 'form-control','required'=>'required' , 'placeholder'=>'price' ]) !!}
                            @if($errors->first('price'))
                                <div class="help-block">{{$errors->first('price')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('quantity') ? 'has-error' :  ''}}">

                        {!! Form::label('quantity', __('Quantity'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::number('quantity', $package->quantity, ['class' => 'form-control','required'=>'required' , 'placeholder'=>'quantity' ]) !!}
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('quantity')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('availability', __('Available?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <toggler name="availability" :old="{{$package->availability}}"></toggler>
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('availability_date') ? 'has-error' :  ''}}">

                        {!! Form::label('availability_date', __('Availability Date'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <datepicker name="availability_date"
                                        :format="$root.dateFormatter"
                                        input-class="form-control not-readonly"
                                        :language="lang.{{app()->getLocale()}}"
                                        :value="dateFormatter('{{$package->availability_date}}')"
                            ></datepicker>
                            @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('availability_date')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('shipping_free', __('Shipping Free?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <toggler name="shipping_free" :old="{{$package->shipping_free}}"></toggler>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('payment_free', __('Payment Free?'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <toggler name="payment_free" :old="{{$package->payment_free}}"></toggler>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('image', __('Thumbnail'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            @if ($package->getFirstMedia('image'))
                            <img class="img-viewer" src="{{$package->getFirstMedia('image')->getUrl()}}" width="300" />
                            @endif
                            {!! Form::file('image', ['class' => 'form-control img-updater']) !!}
                            {!! Form::hidden('delete_image', false, ['class' => 'form-control delete_image' ]) !!}
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
@section('js')
    <script>
        //remove old image preview
        $('.img-updater').change(function () {
            readURL(this, $(this).closest('.box-body').find('.img-viewer'));
        });

        function readURL(input, el) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(el).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection