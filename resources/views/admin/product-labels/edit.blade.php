@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-name">@lang('Edit') @lang('Product Label')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    {!!Form::model($productLabel, ['action' => ['Admin\ProductLabelController@update', $productLabel->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                    <div class="form-group {{$errors->first('name') ? 'has-error' :  ''}}">
                        {!! Form::label('name', __('Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', $productLabel->name, ['class' => 'form-control','required'=>'required' , 'placeholder'=>'name' ]) !!} @if($errors->first('name'))
                                <div class="help-block">{{$errors->first('name')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('name_ar') ? 'has-error' :  ''}}">
                        {!! Form::label('name_ar', __('Arabic Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name_ar', $productLabel->name_ar, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Arabic Name') ]) !!} @if($errors->first('name_ar'))
                                <div class="help-block">{{$errors->first('name_ar')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->first('color') ? 'has-error' :  ''}}">
                        {!! Form::label('color', __('Color'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            <color-picker ref="colors" old="{{$productLabel->color}}"></color-picker>
                            @if($errors->first('color'))
                                <div class="help-block">{{$errors->first('color')}}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat">@lang('Save')</button>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    import ColorPicker from "../../../assets/js/components/admin/ColorPicker";

    export default {
        components: {ColorPicker}
    }
</script>