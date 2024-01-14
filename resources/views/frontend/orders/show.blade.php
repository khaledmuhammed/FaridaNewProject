@extends('frontend.layouts.app')
@section('content')
    <div class="container margin-top xs-no-padding">
        @if (Session::has('success'))
            <sweet-modal icon="success" ref="modal" id="completeOrder">
                <h3>{{ Session::get('success') }}</h3>
                <br><br>
                <p class="col-sm-6 col-sm-offset-3">
                    <button @click="$refs.modal.close()" class="btn btn-primary btn-block">
                        @lang('Show Order')
                    </button>
                </p>
            </sweet-modal>
        @endif
        @if (Session::has('error'))
            <sweet-modal icon="error" ref="modal" id="completeOrder">
                <h3>{{ Session::get('error') }}</h3>
            </sweet-modal>
        @endif
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-xs-12 xs-no-padding">
                <div class="box xs-no-padding">
                    <div class="box-header col-xs-12 xs-no-padding">
                        <div class="col-sm-8 col-xs-7">
                            <h4 class="float-right">#{{$order->id}}</h4>
                            <span class="label
                            @if(in_array($order->currentStatus->id, [App\Models\Status::$PAYMENT_FAILED, App\Models\Status::$CANCELED, App\Models\Status::$IGNORED]))
                                    label-danger
                            @else
                                    label-primary 
                            @endif
                                    float-right margin-top margin-right">{{$order->currentStatus->name_ar}}</span>
                        </div>
                        @if ($order->paymentMethod->id == 3)
                        <div class="col-sm-2"><a href="{{$url}}" target="_blanck" class="btn btn-primary">@lang('Bank Transfer Form')</a></div>
                        @endif
                        {{-- <div class="col-sm-2 col-xs-5">
                            <a href="/order/{{$order->id}}/print" target="_blanck" class="btn btn-primary btn-block">
                                @lang('Show Invoice')
                            </a>
                        </div> --}}
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <hr>
                    </div>
                    <div class="box-content col-xs-12 xs-no-padding">
                        <div class="col-sm-6">
                            <h4 class="text-primary">@lang('Order Details')</h4>
                            <table>
                                <tr>
                                    <td width="100"><b>@lang('Order Status')</b></td>
                                    <td>
                                        {{-- @if ($order->currentStatus->id == App\Models\Status::$PAYMENT_FAILED || $order->currentStatus->id == App\Models\Status::$PENDING)
                                        {{$order->currentStatus->name_ar}}<br/>
                                        <button class="btn btn-primary btn-xs" id="paymentBtn" data-toggle="modal" data-target="#paymentModal">@lang('Repayment with credit card')</button>
                                        <!-- paymentModal -->
                                        <div id="paymentModal" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">@lang('Payment with credit card')</h4>
                                                </div>
                                                <div class="modal-body row">
                                                    <h4 class="text-center">@lang('Total') : {{$order->total}} @lang('SAR')</h4>
                                                    <p class="col-sm-12 col-xs-12">
                                                        <form action="{{url('/payment/show')}}" class="paymentWidgets" data-brands="VISA MASTER MADA">

                                                        </form>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Close')</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else --}}
                                        {{$order->currentStatus->name_ar}}
                                        {{-- @endif --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100"><b>@lang('Order Date')</b></td>
                                    <td>{{$order->formatted_created_at}}</td>
                                </tr>
                                <tr>
                                    <td width="100"><b>@lang('Shipping Method')</b></td>
                                    <td>{{$order->shipping_method}}</td>
                                </tr>
                                <tr>
                                    <td width="100"><b>@lang('Payment Method')</b></td>
                                    <td>{{$order->paymentMethod->theName}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="text-primary">@lang('Address')</h4>
                            <table>
                                <tr>
                                    <td width="100"><b>@lang('Name')</b></td>
                                    <td>{{$order->address_owner}}</td>
                                </tr>
                                <tr>
                                    <td width="100"><b>@lang('City')</b></td>
                                    <td>{{$order->city->name_ar}}</td>
                                </tr>
                                <tr>
                                    <td width="100"><b>@lang('Address')</b></td>
                                    <td>{{$order->district->name_ar}} ، {{$order->address_details}}</td>
                                </tr>
                                <tr>
                                    <td width="100"><b>@lang('Mobile')</b></td>
                                    <td>{{$order->mobile}}</td>
                                </tr>
                                <tr>
                                    <td width="100"><b>تاريخ التوصيل</b></td>
                                    <td>{{ date('F j, Y', strtotime($order->shipping_date))}}</td>
                                </tr>
                                <tr>
                                    <td width="100"><b>وقت التوصيل</b></td>
                                    <td>{{ date('g:i a', strtotime($order->shipping_time))}}</td>
                                </tr>
                            </table>
                        </div>
                        @if($order->orderReceiver)
                        <div class="col-sm-6">
                            <h4 class="text-primary">عنوان مستلم الطلب</h4>
                            <table>
                                <tr>
                                    <td width="100"><b>@lang('Name')</b></td>
                                    <td>{{$order->orderReceiver->receiver_name}}</td>
                                </tr>
                                <tr>
                                    <td width="100"><b>@lang('City')</b></td>
                                    <td>{{$order->orderReceiver->city->name_ar}}</td>
                                </tr>
                                <tr>
                                    <td width="100"><b>@lang('Address')</b></td>
                                    <td>{{$order->orderReceiver->district->name_ar}}</td>
                                </tr>
                                <tr>
                                    <td width="100"><b>@lang('Mobile')</b></td>
                                    <td>{{$order->orderReceiver->receiver_mobile}}</td>
                                </tr>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="box margin-top xs-no-padding">
                    <div class="box-header">
                        <div class="col-sm-12"><h4 class="text-primary">@lang('Items')</h4></div>
                    </div>
                    <div class="box-content">
                        <div class="col-sm-12">
                            <table class="table table-products">
                                <tr class="active">
                                    <th width="400">@lang('Item')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Discount')</th>
                                    <th>@lang('Total')</th>
                                </tr>
                                @foreach ($order->orderItems as $item)
                                    @if($item->orderable_type === \App\Models\Product::class)
                                        <tr class="visiable-lg visiable-md visiable-sm hidden-xs">
                                            <td>
                                                <div class="col-sm-4">
                                                    @if($item->orderable->getFirstMedia('images'))<a
                                                            href="/products/{{$item->orderable->slug}}"><img
                                                                src="{{$item->orderable->getFirstMedia('images')->getUrl()}}"
                                                                width="100%" class="" /></a>@endif
                                                </div>
                                                <div class="col-sm-8 text-dark">
                                                    <p>
                                                        <a href="/products/{{$item->orderable->slug}}">{{$item->orderable->name}}</a>
                                                        @if($item->property_value)
                                                            @if($item->property_value->property->type == 'selection')
                                                                <span>[ {{$item->property_value->value}} ]</span>
                                                            @else {{-- the property type is color --}}
                                                                <span style="width:25px; height:15px; border:1px solid #b9b9b9; vertical-align: middle; display:inline-block; margin:0 10px; background:{{$item->property_value->value}}"></span>
                                                            @endif
                                                        @endif
                                                    </p>
                                                    {{-- <small>{{$item->product_option['name']}}</small> --}}
                                                </div>
                                            </td>
                                            <td>{{$item->unit_price}} @lang('SAR')</td>
                                            <td>{{$item->count}}</td>
                                            <td>{{$item->discount}} @lang('SAR') </td>
                                            <td>{{($item->unit_price * $item->count) - $item->discount }} @lang('SAR')</td>
                                        </tr>
                                        <tr class="visiable-xs hidden-lg hidden-md hidden-sm">
                                            <td colspan="5">
                                                <div class="col-xs-4 xs-no-padding">
                                                    @if($item->orderable->getFirstMedia('images'))<a
                                                            href="/products/{{$item->orderable->slug}}"><img
                                                                src="{{$item->orderable->getFirstMedia('images')->getUrl()}}"
                                                                width="100%" class="" /></a>@endif
                                                </div>
                                                <div class="col-xs-8 text-dark">
                                                    <p>
                                                        <a href="/products/{{$item->orderable->slug}}">{{$item->orderable->name}}</a>
                                                    </p>
                                                    <p>@lang('Price'): {{$item->unit_price}} @lang('SAR')</p>
                                                    <p>@lang('Quantity'): {{$item->count}}</p>
                                                    @if($item->discount > 0)
                                                    <p>@lang('Discount'): {{$item->discount}} @lang('SAR')</p>
                                                    @endif
                                                    <p>@lang('Total'): {{($item->unit_price * $item->count) - $item->discount }} @lang('SAR')</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @elseif($item->orderable_type === \App\Models\Package::class)
                                        <tr class="visiable-lg visiable-md visiable-sm hidden-xs">
                                            <td>
                                                <div class="col-sm-4">
                                                    @if($item->orderable->thumbnail)
                                                    <a href="/package/{{$item->orderable->id}}">
                                                        <img src="{{$item->orderable->thumbnail}}" width="100" class="" />
                                                    </a>
                                                    @endif
                                                </div>
                                                <div class="col-sm-8 text-dark">
                                                    <p>
                                                        <a href="/package/{{$item->orderable->id}}">{{$item->orderable->name}}</a>
                                                    </p>
                                                    @if($item->intoPackageItems)
                                                        @foreach ($item->intoPackageItems as $product)
                                                            <img src="{{$product['image']}}" width="60" />
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{$item->unit_price}} @lang('SAR')</td>
                                            <td>{{$item->count}}</td>
                                            <td>{{$item->discount}} @lang('SAR') </td>
                                            <td>{{($item->unit_price * $item->count) - $item->discount }} @lang('SAR')</td>
                                        </tr>
                                        <tr class="visiable-xs hidden-lg hidden-md hidden-sm">
                                            <td colspan="5">
                                                <div class="col-xs-4 xs-no-padding">
                                                    @if($item->orderable->thumbnail)
                                                    <a href="/package/{{$item->orderable->id}}">
                                                        <img src="{{$item->orderable->thumbnail}}" width="100%" class="" />
                                                    </a>
                                                    @endif
                                                </div>
                                                <div class="col-xs-8 text-dark">
                                                    <p>
                                                        <a href="/package/{{$item->orderable->id}}">{{$item->orderable->name}}</a>
                                                    </p>
                                                    @if($item->intoPackageItems)
                                                        @foreach ($item->intoPackageItems as $product)
                                                            <img src="{{$product['image']}}" width="60" />
                                                        @endforeach
                                                    @endif
                                                    <p>@lang('Price'): {{$item->unit_price}} @lang('SAR')</p>
                                                    <p>@lang('Quantity'): {{$item->count}}</p>
                                                    @if($item->discount > 0)
                                                    <p>@lang('Discount'): {{$item->discount}} @lang('SAR')</p>
                                                    @endif
                                                    <p>@lang('Total'): {{($item->unit_price * $item->count) - $item->discount }} @lang('SAR')</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr class="active">
                                    <th colspan="4">@lang('Total Items')</th>
                                    <td>{{$order->items_price}} @lang('SAR')</td>
                                </tr>
                                <!-- <tr class="active">
                                    <th colspan="4">ضريبة القيمة المضافة</th>
                                    <td>{{$order->vat}} ريال</td>
                                </tr> -->
                                <tr class="active">
                                    <th colspan="4">@lang('Shipping Fee')</th>
                                    <td>{{$order->shipping_price}} @lang('SAR')</td>
                                </tr>
                                @if($order->payment_price > 0)
                                    <tr class="active">
                                        <th colspan="4">@lang('Cash On Delivery Fee')</th>
                                        <td>{{$order->payment_price}} @lang('SAR')</td>
                                    </tr>
                                @endif
                                @if(!empty($order->coupon))
                                    <tr class="active">
                                        <th colspan="4">@lang('Discount') <small>( @lang('Discount Code') : {{$order->coupon_code}} )</small></th>
                                        <td>{{$order->discount}} @lang('SAR')</td>
                                    </tr>
                                @endif
                                <tr class="active">
                                    <th colspan="4" class="background-primary text-white">@lang('Final Total')</th>
                                    <td class="background-primary text-white"><b>{{$order->total_price}} @lang('SAR')</b></td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
                @if ($order->bankTransfer)
                <div class="box margin-top">
                    <div class="box-header">
                        <div class="col-sm-12"><h4>@lang('Bank Transfer Data')</h4></div>
                    </div>
                    <div class="box-content">
                        <div class="col-sm-12">
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
                                        <td>{{$order->bankTransfer->amount}} ريال</td>
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
                        </div>
                    </div>
                </div>
                @else 
                @if ($order->paymentMethod->id == 3)
                <div class="box margin-top">
                    <div class="box-header">
                        <div class="col-sm-12"><h4>حساباتنا البنكية</h4></div>
                    </div>
                    <div class="box-content">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <p>مصرف الإنماء :</p>
                                <p>68201698498000</p>
                                <p>الآيبان : (مصرف الإنماء)</p>
                                <p>SA2405000068201698498000</p>
                                <p>مصرف الراجحي :</p>
                                <p>454000010006086033087</p>
                                <p>الآيبان : (مصرف الراجحي)</p>
                                <p>SA5880000454608016033087</p>
                                <p>(مؤسسة ورود فريدة للتجارة)</p>
                                <br/>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection