@extends('adminlte::page')

@section('content')
    
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('The Coupon') ({{$coupon->code}})</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="small-box bg-yellow-gradient">
                                <div class="inner">
                                    <h3 class="kpi-value">{{ $coupon->orders->count() }}</h3>

                                    <h4>{{__('Order')}}</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="small-box bg-green-gradient">
                                <div class="inner">
                                    <h3 class="kpi-value">{{ $coupon->orders->sum('total_price') }}</h3>

                                    <h4>{{__('SR')}}</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <tr>
                            <th>المنتج</th> 
                            <th>العدد</th>
                            <th>الإجمالي</th>
                        </tr>
                        @foreach($products as $product)
                        <tr>
                            <td>{{$product->product_name}}</td>
                            <td>{{$product->usage_count}}</td>
                            <td>{{$product->total}} @lang('SR')</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
