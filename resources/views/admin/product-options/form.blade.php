@if (isset($option))
    {!!Form::model($option, ['action' => ['Admin\ProductOptionController@update', $product->id,$option->id], 'method' => 'put','class'=>'form-horizontal'])!!}
@else
    {!! Form::open(['action' => ['Admin\ProductOptionController@store',$product->id],'class'=>'form-horizontal','method' => 'POST']) !!}
@endif
{{csrf_field()}}
<div class="box-body">
    <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
        {!! Form::label('name', __('Option Name'), ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::text('name', old('name'), ['class' => 'form-control','required'=>'required' ,  ]) !!}
            @if($errors->first('name'))
                <div class="help-block">{{$errors->first('name')}}</div>
            @endif
        </div>
    </div>
    {{-- <div class="form-group {{$errors->first('type') ? 'has-error' :  ''}}">
        {!! Form::label('type', __('Option Type'), ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!!  Form::select('type',\App\Models\OptionType::all()->pluck('name_ar','name') , null, ['class' => 'form-control']) !!}
            @if($errors->first('type'))
                <div class="help-block">{{$errors->first('type')}}</div>
            @endif

        </div>
    </div> --}}
    <div class="form-group {{$errors->first('product_code') ? 'has-error' :  ''}}">
        {!! Form::label('product_code', __('Option Code') . __(' (optional)'), ['class' => 'control-label col-sm-2 ']) !!}
        <div class="col-sm-10">
            {!! Form::text('product_code', old('product_code'), ['class' => 'form-control', ]) !!}
            @if($errors->first('name'))
                <div class="help-block">{{$errors->first('product_code')}}</div>
            @endif
        </div>
    </div>
    <div class="form-group {{$errors->first('original_price') ? 'has-error' :  ''}}">
        {!! Form::label('original_price', __('Original Price'), ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::number('original_price', old('original_price'), ['class' => 'form-control', 'required'=>'required' ]) !!}
            @if($errors->first('original_price'))
                <div class="help-block">{{$errors->first('original_price')}}</div>
            @endif
        </div>
    </div>
    <div class="form-group {{$errors->first('price_after_discount') ? 'has-error' :  ''}}">
        {!! Form::label('price_after_discount', __('Price After Discount') . __(' (optional)'), ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::number('price_after_discount', old('price_after_discount'), ['class' => 'form-control' ,  ]) !!}
            @if($errors->first('price_after_discount'))
                <div class="help-block">{{$errors->first('price_after_discount')}}</div>
            @endif
        </div>
    </div>
    <div class="form-group {{$errors->first('quantity') ? 'has-error' :  ''}}">
        {!! Form::label('quantity', __('Quantity'), ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::number('quantity', old('quantity'), ['class' => 'form-control','required'=>'required' ,  ]) !!}
            @if($errors->first('name'))
                <div class="help-block">{{$errors->first('quantity')}}</div>
            @endif
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('availability', __('Available?'), ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::radio('availability', '1' , true  , ['required'=>'required', (!empty($option) && $option->availability == 1 ? 'checked' : '' ) ]) !!}
            @lang('Yes')
            {!! Form::radio('availability', '0' , false , ['required'=>'required', (!empty($option) && $option->availability == 0 ? 'checked' : '' ) ]) !!}
            @lang('No')
        </div>
    </div>
    <div class="form-group {{$errors->first('availability_date') ? 'has-error' :  ''}}">
        {!! Form::label('availability_date', __('Availability Date'), ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::date('availability_date', old('availability_date'), ['class' => 'form-control','required'=>'required' ,  ]) !!}
            @if($errors->first('name'))
                <div class="help-block">{{$errors->first('availability_date')}}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-2 col-sm-offset-10 no-padding">
        <button type="submit" class="btn btn-info btn-block btn-flat">
            {{isset($option)?__('Update'):__('Add')}}
        </button>
    </div>
</div>
{!! Form::close() !!}
