@extends('frontend.layouts.pdf')
@section('content')
    <div id="checkout">
        <div class="container">
            <div class="row ">
                <div class="bill ">
                    <div class="printable">
                        <div class="bill-header">
                            <div class="arabic">
                                <p>متجر ورود فريدة</p>
                                <p>الرياض - المملكة العربية السعودية</p>
                                <p>هاتف: 96650000000+</p>
                                <p>الرقم الضريبي: 00000000000</p>
                                <p>السجل التجاري: 00000000</p>
                                <p>info@awan.com</p>
                                <p>www.awan.com</p>
                            </div>
                            <div class="">
                                <img src="{{asset('imgs/logo.png')}}" alt="" class="bill-logo">
                            </div>
                            <div class="english">
                                <p>Awan</p>
                                <p>Riyadh, Saudi Arabia</p>
                                <p>Tel :+966500000000</p>
                                <p>VAT Number: 0000000000</p>
                                <p>CR: 0000000000000</p>
                                <p>info@awan.com</p>
                                <p>www.awan.com</p>
                            </div>
                        </div>
                        <div class="bill-title">
                            فاتورة مبيعات SALES INVOICE
                        </div>
                        <div class="bill-details">
                            <p>
                                <span>رقم الطلب : </span>
                                <span>#{{$order->id}}</span>
                            </p>
                            <p>
                                <span> العميل :</span>
                                <span>{{$order->username}}</span>
                            </p>
                            <p>
                                <span>الجوال : </span>
                                <span>{{$order->mobile}}</span>
                            </p>
                            <p>
                                <span>التاريخ : </span>
                                <span>{{$order->created_at->toDateString()}}</span>
                            </p>
                        </div>
                        <div class="table-responsive">
                            <div class="table">
                                <div class="table-header">
                                    <div class="table-title" style="width: 50px;">
                                        No<br>الرقم
                                    </div>
                                    <div class="table-title product-name" style="width: 150px;">
                                        الصنف | Code
                                    </div>
                                    <div class="table-title product-name">
                                        الوصف | Description
                                    </div>
                                    <div class="table-title" style="width: 50px;">
                                        Qty<br>الكمية
                                    </div>
                                    <div class="table-title" style="width: 100px;">
                                            السعر | Price
                                        </div>
                                    <div class="table-title" style="width: 80px;">
                                        Discount<br>الخصم
                                    </div>
                                    {{-- <div class="table-title" style="width: 50px;">
                                        VAT<br>ضريبة
                                    </div> --}}
                                    <div class="table-title" style="width: 100px;">
                                        القيمة | Value
                                    </div>
                                </div>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach($order->orderItems as $item)
                                    @if($item->orderable_type === \App\Models\Product::class)
                                        <div class="table-row">
                                            <div class="table-cell">
                                                {{$counter++}}
                                            </div>
                                            <div class="table-cell">
                                                {{$item->orderable->product_code}}
                                            </div>
                                            {{--
                                                                                    <div class="table-cell">
                                                                                        --}}
                                            {{--<img src="{{$item->orderable->thumbnail}}" alt="">--}}{{--

                                                                                        <img class="product-image"
                                                                                             src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTmu1UdlrQnwWXfTXHwN4ZP8h-9nOiWBJ70TvaMBti5uGeBpva7"
                                                                                             alt="">
                                                                                    </div>
                                            --}}
                                            <div class="table-cell">
                                                {{$item->orderable->name}}
                                                @if($item->property_value)
                                                    @if($item->property_value->property->type == 'selection')
                                                        <span>[ {{$item->property_value->value}} ]</span>
                                                    @else {{-- the property type is color --}}
                                                        <span style="width:25px; height:15px; border:1px solid #b9b9b9; vertical-align: middle; display:inline-block; margin:0 10px; background:{{$item->property_value->value}}"></span>
                                                    @endif
                                                @endif
                                            </div>

                                            <div class="table-cell text-center">
                                                {{$item->count}}
                                            </div>
                                            <div class="table-cell text-center">
                                                    {{$item->unit_price}}
                                                </div>
                                            <div class="table-cell text-center">
                                                {{$item->discount}}
                                            </div>
                                            {{-- <div class="table-cell text-center">
                                                {{$item->vat}}
                                            </div> --}}
                                            <div class="table-cell text-center">
                                                {{($item->unit_price * $item->count) - $item->discount}}
                                            </div>

                                        </div>
                                    @else
                                        @foreach($item->orderable->intoPackages as $product)

                                            <div class="table-row">
                                                <div class="table-cell">
                                                    {{$counter++}}
                                                </div>
                                                <div class="table-cell">
                                                    {{$product->product_code}}
                                                </div>
                                                {{--
                                                <div class="table-cell">
                                                --}}
                                                {{--<img src="{{$product->thumbnail}}" alt="">--}}
                                                {{--
                                                <img class="product-image"
                                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTmu1UdlrQnwWXfTXHwN4ZP8h-9nOiWBJ70TvaMBti5uGeBpva7"
                                                alt="">
                                                </div>
                                                --}}
                                                <div class="table-cell">
                                                    {{$product->name}}
                                                </div>

                                                <div class="table-cell text-center">
                                                    {{$item->count}}
                                                </div>
                                                <div class="table-cell text-center">
                                                    5
                                                </div>
                                                <div class="table-cell text-center">
                                                    {{$loop->first ? $item->unit_price : 0}}
                                                </div>

                                                <div class="table-cell text-center">
                                                    {{$loop->first ? $item->unit_price * $item->count : 0}}
                                                </div>

                                            </div>

                                        @endforeach
                                    @endif
                                @endforeach
                                <div class="table-row">
                                    <div class="table-cell"><br></div>
                                    <div class="table-cell"></div>
                                    <div class="table-cell"></div>
                                    <div class="table-cell"></div>
                                    <div class="table-cell"></div>
                                    <div class="table-cell"></div>
                                    {{-- <div class="table-cell"></div> --}}
                                    <div class="table-cell"></div>
                                </div>
                            </div>
                            <div class="grid-container">
                                <div class="item1">
                                    <strong> طريقة الدفع | Payment Method</strong>
                                    {{$order->paymentMethod->theName}}
                                </div>
                                <div class="item2">
                                    <strong> طريقة التوصيل | Shipping Method</strong>
                                    {{$order->shippingMethod->theName}}

                                </div>
                                <div class="item3">
                                    <strong>العنوان | Address </strong>
                                    {{$order->city->name}} - {{$order->address_details}}

                                </div>
                                <div class="item4 text-left">
                                    المجموع | Total
                                    <br>
                                    التوصيل | Shipping
                                    <br>
                                    رسوم الدفع | Payment Fees
                                    <br>
                                    {{-- الضريبة | Vat
                                    <br> --}}
                                    الخصم | Discount
                                    <strong>
                                        إجمالي الفاتورة | Invoice Total
                                    </strong>
                                </div>
                                <div class="item5">
                                    {{$order->items_price}}
                                    <br>
                                    {{$order->shipping_price}}
                                    <br>
                                    {{$order->payment_price}}
                                    <br>
                                    {{-- {{$order->vat}}
                                    <br> --}}
                                    {{$order->discount }}
                                    <br>
                                    <strong>
                                        {{$order->total_price }} ر.س.
                                    </strong>

                                </div>
                            </div>

                            {{--<div class="table">
                                <div class="table-row">
                                    <div class="table-cell" style="width: 25%;">
                                    </div>
                                    <div class="table-cell" style="width: 25%;">

                                    </div>

                                    <div class="table-cell" style="width: 100px;">
                                    </div>

                                </div>
                                <div class="table-row" style="width: 50%;">
                                    <div class="table-cell">
                                    </div>

                                </div>

                            </div>--}}

                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection


