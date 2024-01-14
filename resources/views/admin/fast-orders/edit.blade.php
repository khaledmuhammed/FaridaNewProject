@extends('adminlte::page')

@section('content')
    <div class="col-xs-12">
        <div class="box box-default ">
            <div class="box-header with-border">
                <h3 class="box-title"> @lang('Fast Orders') - #{{$fastOrder->id}}</h3>
            </div>
            <div class="box-body">
                {!!Form::model($fastOrder, ['action' => ['Admin\FastOrderController@update', $fastOrder->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        <b>@lang('Name')</b>
                    </div>
                    <div class="col-sm-10">
                        {{$fastOrder->name}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        <b>@lang('Mobile')</b>
                    </div>
                    <div class="col-sm-10">
                        {{$fastOrder->mobile}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        <b>@lang('City')</b>
                    </div>
                    <div class="col-sm-10">
                        {{$fastOrder->city->name_ar}} - {{$fastOrder->city->country->name_ar}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        <b>@lang('District')</b>
                    </div>
                    <div class="col-sm-10">
                        {{$fastOrder->district}}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        <b>@lang('Status')</b>
                    </div>
                    <div class="col-sm-10">
                        <div class="col-sm-4 no-padding">
                            @if (auth()->user()->role_id == 2)
                            {{$fastOrder->status == "completed" ? 'مكتمل' :''}}
                            {{$fastOrder->status == "pended" ? 'في الانتظار' :''}}
                            {{$fastOrder->status == "canceled" ? 'ملغي' :''}}
                            @else 
                            <select class="form-control" name="status">
                                <option {{$fastOrder->status == "completed" ? 'selected' :''}} value="completed">مكتمل</option>
                                <option {{$fastOrder->status == "pended" ? 'selected' :''}} value="pended">في الانتظار</option>
                                <option {{$fastOrder->status == "canceled" ? 'selected' :''}} value="canceled">ملغي</option>
                            </select>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        <b>@lang('Order Details')</b>
                    </div>
                    <div class="col-sm-10">
                        {!!$fastOrder->details!!}
                    </div>
                </div>

                {{-- <div class="form-group ">
                    {!! Form::label('logo', __('Logo URL'), ['class' => 'control-label col-sm-2 ']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('logo', $manufacturer->logo_path, ['class' => 'form-control','required'=>'required']) !!}
                    </div>
                </div> --}}
                @if (auth()->user()->role_id != 2)
                <div class="col-sm-2 col-sm-offset-10 no-padding">
                    <button type="submit" class="btn btn-success btn-block btn-flat">@lang('Update')</button>
                </div>
                @endif
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
