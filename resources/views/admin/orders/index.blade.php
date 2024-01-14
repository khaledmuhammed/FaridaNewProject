@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Orders')</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <script>
                function show(){
                    $('.todayOrders').css('display' , 'block');
                }
            </script>
            <button class="btn btn-block btn-success" onclick="show()" style="max-width: 200px; margin-bottom:10px">طلبات التوصيل اليوم</button>
            <div class="box todayOrders display-none" style="display: none;">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Client Name')</th>
                                <th>@lang('Mobile')</th>
                                <th>@lang('Items Count')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                @if($order->last_status_id == 3 && $order->shipping_date ==  Carbon\Carbon::now()->format('Y-m-d'))
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->username}}</td>
                                    <td>{{$order->mobile}}</td>
                                    <td>{{$order->orderItems->count()}}</td>
                                    <td>{{title_case(__($order->currentStatus['name']))}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>
                                        <button class="btn btn-success btn-xs" onclick="location.href='{{action('Admin\OrderController@show',$order->id)}}'">@lang('Show')</button>
                                        {{-- <a class="btn btn-primary btn-xs" href="{{action('Admin\OrderController@edit',$order->id)}}">@lang('Edit')</a> --}}
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
             </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">
                    <div class="row">
                        <form action="{{action('Admin\OrderController@index')}}" method="GET" class="form-inline">
                            <div class="col-sm-8">
                                <div class="pull-right">
                                    <input type="text" name="name" value="{{Session::get('filter.name')}}" placeholder="اسم أو جوال العميل أو رقم الطلب" class="form-control" size="25">
                                </div>
                                <div class="pull-right">
                                <datepicker name="from"
                                        :format="$root.dateFormatter"
                                        input-class="form-control not-readonly"
                                        :language="lang.{{app()->getLocale()}}"
                                        :value="dateFormatter('{{Session::get('filter.from')}}')"
                                        placeholder="من تاريخ"
                                        :clear-button="true"
                                    ></datepicker>
                                </div>
                                <div class="pull-right">
                                <datepicker name="to"
                                        :format="$root.dateFormatter"
                                        input-class="form-control not-readonly"
                                        :language="lang.{{app()->getLocale()}}"
                                        :value="dateFormatter('{{Session::get('filter.to')}}')"
                                        placeholder="إلى تاريخ"
                                        :clear-button="true"
                                    ></datepicker>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button value="submit" type="submit" class="btn btn-block btn-success">بحث</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Client Name')</th>
                                <th>@lang('Mobile')</th>
                                <th>@lang('Items Count')</th>
                                <th>@lang('Status')</th>
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
                                    <td>{{title_case(__($order->currentStatus['name']))}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>
                                        <button class="btn btn-success btn-xs" onclick="location.href='{{action('Admin\OrderController@show',$order->id)}}'">@lang('Show')</button>
                                        {{-- <a class="btn btn-primary btn-xs" href="{{action('Admin\OrderController@edit',$order->id)}}">@lang('Edit')</a> --}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $orders->appends(['name' => Session::get('filter.name'),'from' => Session::get('filter.from'),'to' => Session::get('filter.to')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
