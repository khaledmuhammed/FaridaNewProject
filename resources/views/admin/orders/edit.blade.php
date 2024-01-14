@extends('adminlte::page')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title"> @lang('Edit') @lang('Order')</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!!Form::model($order, ['action' => ['Admin\OrderController@update', $order->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('id', __('Order #ID'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('id', $order->id, ['class' => 'form-control' , 'disabled'=>'' ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('created_at', __('Order Time'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('created_at', $order->created_at, ['class' => 'form-control' , 'disabled'=>'' ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('order_status', __('Status'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('order_status', $order->status, ['class' => 'form-control' , 'disabled'=>'' ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('shipping', __('Shipping Method'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('shipping', $order->shipping_type, ['class' => 'form-control' , 'disabled'=>'' ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('payment', __('Payment Method'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('payment', $order->payment_type, ['class' => 'form-control' , 'disabled'=>'' ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('user_name', __('Client Name'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('user_name', $order->user->first_name .' '.$order->user->last_name, ['class' => 'form-control' , 'disabled'=>'' ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('user_mobile', __('Client Mobile'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('user_mobile', $order->user->mobile, ['class' => 'form-control' , 'disabled'=>'' ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('total', __('Total Price'), ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('total', $order->total, ['class' => 'form-control' , 'disabled'=>'' ]) !!}
                        </div>
                    </div>

                    <div class="form-group {{$errors->first('status') ? 'has-error' :  ''}}">
                        {!! Form::label('status', __('Status'), ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            <select name="status" id="status" class="form-control">
                                <option {{ $order->status == 'new' ? 'selected' : '' }} value="new">@lang('new')</option>
                                <option {{ $order->status == 'paid' ? 'selected' : '' }} value="paid">@lang('paid')</option>
                                <option {{ $order->status == 'complete' ? 'selected' : '' }} value="complete">@lang('complete')</option>
                            </select>
                            @if($errors->first('status'))
                                <div class="help-block">{{$errors->first('status')}}</div>
                            @endif
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

@section('js')

@endsection


