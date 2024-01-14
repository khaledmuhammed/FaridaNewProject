@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Bank Transfer Orders')</h1>
@endsection

@section('content')
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
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">
                <!--<a class="btn btn-success btn-new-element" href="{{action('Admin\OrderController@create')}}">Add Order</a>-->
                </div>
                <div class="box-body">
                    @if(count($orders))
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Client Name')</th>
                                <th>@lang('Mobile')</th>
                                <th>@lang('Items Count')</th>
                                <th>@lang('Transfer Info')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->username}}</td>
                                    <td>{{$order->mobile}}</td>
                                    <td>{{$order->orderItems->count()}}</td>
                                    <td>
                                        @if ($order->bankTransfer)
                                        <p>{{$order->bankTransfer->account_owner}}</p>
                                        <p>{{$order->bankTransfer->account_number}}</p>
                                        <p>{{$order->bankTransfer->bank_name}}</p>
                                        <p>{{$order->bankTransfer->amount}} ريال</p>
                                        <p>{{$order->bankTransfer->date}}</p>
                                        <p>{{$order->bankTransfer->notes}}</p>
                                        @else
                                        لم يتم التحويل <br />
                                        <a href="{{$order->bankTransferUrl}}" target="_blank">رابط تأكيد الإيداع</a>
                                        @endif
                                    </td>
                                    <td>{{$order->created_at}}</td>
                                    <td>
                                        <button class="btn btn-success btn-xs"
                                                onclick="location.href='{{action('Admin\OrderController@show',$order->id)}}'">@lang('Show')</button>
                                        <a class="btn btn-primary btn-xs"
                                           href="{{route('admin.changeToPreparing',$order->id)}}"><i class="fa fa-fw fa-check"></i></a>
                                        <a class="btn btn-danger btn-xs"
                                           href="{{route('admin.changeToCanceled',$order->id)}}"><i class="fa fa-fw fa-remove"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center">لا توجد طلبات</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
