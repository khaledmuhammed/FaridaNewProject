@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="small-box bg-yellow-gradient">
                <div class="inner">
                    <h3 class="kpi-value">{{ $users }}</h3>

                    <h4>{{__('Users')}}</h4>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-people-outline"></i>
                </div>
                <a href="{{route('admin.users.index')}}" class="small-box-footer" target="_blank">المزيد
                    <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="small-box bg-green-gradient">
                <div class="inner">
                    <h3 class="kpi-value">{{ $orders }}</h3>

                    <h4>{{__('Orders')}}</h4>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{route('admin.orders.index')}}" class="small-box-footer" target="_blank">المزيد
                    <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="small-box bg-blue-gradient">
                <div class="inner">
                    <h3 class="kpi-value">{{ $todayOrders }}</h3>

                    <h4>{{__('today orders')}}</h4>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{route('admin.orders.index')}}" class="small-box-footer" target="_blank">المزيد
                    <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="small-box bg-purple-gradient">
                <div class="inner">
                    <h3 class="kpi-value">{{ $products }}</h3>

                    <h4>{{__('products')}}</h4>
                </div>
                <div class="icon">
                    <i class="fa fa-fw fa-cubes "></i>
                </div>
                <a href="{{route('admin.products.index')}}" class="small-box-footer" target="_blank">المزيد
                    <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <div class="box-title">
                        <b>
                            <a href="{{route('admin.orders.index')}}">{{__('Orders')}}</a>
                        </b>
                    </div>
                    <button type="button" class="btn btn-box-tool pull-{{__('direction_end')}}"
                            data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Client Name')</th>
                                <th>@lang('Items Count')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Payment Method')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lastOrders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->username}}</td>
                                    <td>{{$order->order_items_count}}</td>
                                    <td>{{title_case(__($order->orderHistory->last()['status']['name']))}}</td>
                                    <td>{{$order->paymentMethod->theName}}</td>
                                    <td>
                                        <button class="btn btn-success btn-xs"
                                                onclick="location.href='{{action('Admin\OrderController@show',$order->id)}}'">@lang('Show')</button>
                                        {{-- <a class="btn btn-primary btn-xs"
                                           href="{{action('Admin\OrderController@edit',$order->id)}}">@lang('Edit')</a> --}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

