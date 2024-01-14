@extends('adminlte::page') @section('content_header')
    <h1>@lang('Order') #{{$order->id}}</h1>
@endsection @section('content')
    <div class="row">
        @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        <div class="clearfix"></div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
        <div class="clearfix"></div>
        @endif
        <div class="col-xs-12">
            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                    <h2 class="page-header">
                        <img src="/imgs/logo.png" height="70" />
                        {{-- <small class="pull-left text-left">
                            <p>INV-store-{{$order->id}}</p>
                        </small> --}}
                    </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col">
                        <h5>بيانات الطلب</h5>
                        <b>رقم الطلب :</b> #{{$order->id}}<br>
                        <b>حالة الطلب :</b> @if ($order->currentStatus) {{$order->currentStatus->name_ar}} @endif<br>
                        <b>تاريخ ووقت الطلب :</b> {{$order->created_at}}<br>
                        <b>طريقة التوصيل :</b> {{$order->shipping_method}}<br>
                        <b>طريقة الدفع :</b> {{$order->paymentMethod->theName}}<br><br>
                        @if ($order->is_gift)
                            <tr>
                                <th><span class="label label-danger">أرجو عدم وضع الفاتورة مع الطلب</span></th>
                                <td></td>
                            </tr>
                            @endif
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col">
                        <h5>بيانات العميل</h5>
                        <b>اسم العميل :</b> {{$order->username}}<br>
                        <b>رقم الجوال :</b> {{$order->mobile}}<br>
                        <b>البريد الإلكتروني :</b> {{$order->email}}
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col">
                        <h5>العنوان</h5>
                        <b>الاسم : </b> {{$order->address_owner}}<br>
                        <b>المدينة :</b> {{$order->city->name_ar}}<br>
                        <b>الحي :</b> {{$order->district->name_ar}}<br>
                       {{-- <b>الشارع :</b> {{$order->street}}<br> --}}
                        <b>العنوان :</b> {{$order->address_details}}<br>
                        <b>تاريخ التوصيل :</b> {{ date('F j, Y', strtotime($order->shipping_date))}}<br>
                        <b>وقت التوصيل :</b> {{ date('g:i a', strtotime($order->shipping_time))}}<br>
                    </div>
                    <!-- /.col -->
                    @if($order->orderReceiver)
                        <div class="col-sm-3 invoice-col">
                            <h5>عنوان مستلم الطلب</h5>
                            <b>الاسم : </b> {{$order->orderReceiver->receiver_name}}<br>
                            <b>رقم الجوال  :</b> {{$order->orderReceiver->receiver_mobile}}<br>
                            <b>المدينة :</b> {{$order->orderReceiver->city->name_ar}}<br>
                            <b>الحي :</b> {{$order->orderReceiver->district->name_ar}}<br>
                           
                        </div>
                    @endif
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row" style="margin: 40px 0 0 0;">
                    <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>@lang('Product Image')</th>
                        <th>@lang('Product Name')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Quantity')</th>
                        <th>@lang('Discount')</th>
                        <th>@lang('Total')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach($order->orderItems as $orderItem)
                            <tr>
                                <td>{{$i}}</td>
                                <td>
                                    @if($orderItem->orderable->getMedia('images')->first())
                                    <img src="{{$orderItem->orderable->getMedia('images')->first()->getUrl()}}" width="100" />
                                    @endif
                                    {{-- Package --}}
                                    @if($orderItem->orderable->getMedia('image')->first())
                                    <img src="{{$orderItem->orderable->getMedia('image')->first()->getUrl()}}" width="100" />
                                    @endif
                                </td>
                                <td>
                                    {{$orderItem->orderable->name}} 
                                    @if($orderItem->property_value)
                                        @if($orderItem->property_value->property->type == 'selection')
                                            <span>[ {{$orderItem->property_value->value}} ]</span>
                                        @else {{-- the property type is color --}}
                                            <span style="width:25px; height:15px; border:1px solid #b9b9b9; vertical-align: middle; display:inline-block; margin:0 10px; background:{{$orderItem->property_value->value}}"></span>
                                        @endif
                                    @endif
                                    <br/> 
                                    @if($orderItem->intoPackageItems)
                                        @foreach ($orderItem->intoPackageItems as $product)
                                            <img src="{{$product['image']}}" width="60" />
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{$orderItem->unit_price}} @lang('SR')</td>
                                <td>{{$orderItem->count}}</td>
                                <td>{{$orderItem->discount}} @lang('SR')</td>
                                <td>{{($orderItem->unit_price * $orderItem->count) - $orderItem->discount}} @lang('SR')
                                
                                    <br/><br/>
                                    @if($orderItem->orderable_type === \App\Models\Package::class)
                                        <button type="button" class="btn" data-toggle="modal" data-target="#packageDetails{{$i}}">
                                            التفاصيل
                                        </button>
                                        <div class="modal fade" id="packageDetails{{$i}}" tabindex="-1" role="dialog" aria-labelledby="packageDetails" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="packageDetails">تفاصيل الباقة</h4>
                                                </div>
                                                <div class="modal-body">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>@lang('Product Image')</th>
                                                            <th>@lang('Product Name')</th>
                                                            <th>@lang('Delivery Day')</th>
                                                            <th>@lang('Delivery Time')</th>
                                                            <th>@lang('Delivery Date')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $j = 0; 
                                                        $orderItem->into_package = json_decode($orderItem->into_package);
                                                        ?>
                                                        @foreach($orderItem->orderable->intoPackages as $product)
                                                            <tr>
                                                                <td>
                                                                    @if($product->getFirstMedia('images'))
                                                                    <a href="/products/{{$product->id}}"><img
                                                                                    src="{{$product->getFirstMedia('images')->getUrl()}}"
                                                                                    width="60px" class="" /></a>
                                                                    @endif
                                                                
                                                                </td>
                                                                <td>
                                                                    <p><a href="/products/{{$product->id}}">{{$product->name}}</a>
                                                                    </p>
                                                                    <p>{{$product->product_code}}</p>
                                                                </td>
                                                                <td>
                                                                    @lang($orderItem->into_package[$j]->delivery_day)
                                                                </td>
                                                                <td>
                                                                    {{date('g:i a', strtotime($orderItem->into_package[$j]->delivery_time))}}
                                                                </td>
                                                                <td>
                                                                    {{ date('F j, Y', strtotime($orderItem->into_package[$j]->delivery_date))}}
                                                                </td>
                                                            </tr>
                                                            <?php $j++; ?>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </td>                                                          
                            </tr>           
                            <?php $i++; ?>
                        @endforeach 
                        </tbody>
                    </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                @if($order->notes)
                <div class="row">                    
                    <div class="col-xs-12">
                        <h5>ملاحظات مع الطلب:</h5>
                        <p>{{$order->notes}}</p>
                        <hr>
                    </div>
                </div>
                @endif
                <div class="row">                    
                    <div class="col-xs-6">
                        <h4>الإجمالي</h4>
                        <div class="table-responsive">
                            <table class="table">
                            <tbody><tr>
                                <th style="width:50%">مجموع المنتجات :</th>
                                <td>{{$order->items_price}} @lang('SR')</td>
                            </tr>
                            <!-- <tr>
                                <th>ضريبة القيمة المضافة :</th>
                                <td>{{$order->vat}} @lang('SR')</td>
                            </tr> -->
                            <tr>
                                <th>التوصيل :</th>
                                <td>{{$order->shipping_price}} @lang('SR')</td>
                            </tr>
                            @if($order->payment_price > 0)
                                <tr>
                                    <th>رسوم الدفع عند الاستلام :</th>
                                    <td>{{$order->payment_price}} @lang('SR')</td>
                                </tr>
                            @endif
                            @if(!empty($order->coupon))
                            <tr>
                                <th>الخصم <small>( كوبون الخصم : {{$order->coupon_code}} )</small></th>
                                <td>{{$order->discount}} ريال</td>
                            </tr>
                            @endif
                            <tr>
                                <th>الإجمالي :</th>
                                <td><b>{{$order->total_price}} @lang('SR')</b></td>
                            </tr>
                            </tbody></table>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        @if ($order->bankTransfer)
                        <h4>بيانات الحوالة البنكية</h4>
                        <div class="table-responsive">
                            <table class='table table-hover'>
                                <tr>
                                    <th>@lang('Account Owner')</th>
                                    <td>{{$order->bankTransfer->account_owner}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Account Number')</th>
                                    <td>{{$order->bankTransfer->account_number}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Bank Name')</th>
                                    <td>{{$order->bankTransfer->bank_name}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Amount Transferred')</th>
                                    <td>{{$order->bankTransfer->amount}} @lang('SR')</td>
                                </tr>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <td>{{$order->bankTransfer->date}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Notes')</th>
                                    <td>{{$order->bankTransfer->notes}}</td>
                                </tr>
                            </table>
                        </div>
                        @endif
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-xs-12">
                    <!-- <a target="_blank" class="btn btn-default"><i class="fa fa-print"></i> طباعة</a> -->
                    <!-- <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                        <i class="fa fa-download"></i> Generate PDF
                    </button> -->
                    </div>
                </div>

                {{-- Order histories --}}
                <div class="row no-print">
                    <hr>
                    <div class="col-xs-12 table-responsive">
                        <h4>@lang('Order Histories')</h4>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                            <th>@lang('Order Status')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Notes')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderHistory as $history)
                                <tr>
                                    <td>{{$history->status->name_ar}} <br/></td>
                                    <td>{{$history->created_at}} </td>
                                    <td>{{$history->notes}}</td>
                                </tr>           
                            @endforeach 
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12">
                        <h4>@lang('Add Order History')</h4>
                        {!! Form::open(['action' => 'Admin\OrderController@addOrderHistory','class'=>'form-horizontal','method' => 'POST']) !!}
                        <div class="form-group {{$errors->first('status_id') ? 'has-error' :  ''}}">
                            {!! Form::label('status_id', __('Order Status'), ['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::select('status_id', $statuses, null, ['class' => 'form-control','required'=>'required' , 'placeholder'=>__('Select') ]) !!}
                                @if($errors->first('status_id'))
                                    <div class="help-block">{{$errors->first('status_id')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{$errors->first('notes') ? 'has-error' :  ''}}">
                            {!! Form::label('notes', __('Notes'), ['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('notes', '', ['class' => 'form-control', 'placeholder'=>__('Notes') ]) !!}
                                @if($errors->first('notes'))
                                    <div class="help-block">{{$errors->first('notes')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-2 col-sm-offset-10 no-padding">
                            <button type="submit" class="btn btn-info btn-block btn-flat">@lang('Add')</button>
                        </div>
                        {!! Form::hidden('order_id', $order->id, ['class' => 'form-control delete_image' ]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- this row will not appear when printing -->
                {{-- <div class="row no-print">
                    <div class="col-xs-12">
                    <h3>معلومات أرامكس</h3>
                    @if ($order->aramexID)
                    <p>رقم الشحنة: {{$order->aramexID}}</p>
                    <a target="_blank" class="btn btn-default" href="{{route('admin.order.aramexLabel', $order->aramexID)}}"><i class="fa fa-print"></i> بوليصة الشحن</a>
                    <a target="_blank" class="btn btn-default" href="{{route('admin.order.aramexTrackShipment', [$order->aramexID, $order->id])}}"><i class="glyphicon glyphicon-road"></i> تتبع الشحنة</a>
                    @else
                    <p>لا يوجد</p>
                    <a target="_blank" class="btn btn-default" href="{{route('admin.sendToAramex', [$order->aramexID, $order->id])}}"><i class="glyphicon glyphicon-send"></i> إرسال إلى أرامكس</a>
                    @endif
                    </div>
                </div> --}}
            </section>
        </div>
    </div>
@endsection
