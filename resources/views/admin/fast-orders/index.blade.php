@extends('adminlte::page')
@section('content_header')
    <h1>@lang('Fast Orders')</h1>
@endsection

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    <div class="clearfix"></div>
@endif
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <form method="GET" class="col-sm-12 no-padding">
                        <div slot="inputs">
                            <div class="form-inline">
                                <div class="form-group col-sm-10 col-xs-12 no-padding">
                                    <div class="col-sm-3 col-xs-12 margin-bottom">
                                        <input type="text" name="name_mobile" class="form-control" value="{{session('fastOrders.mobile')}}" placeholder="اسم أو جوال العميل">
                                    </div>
                                    <div class="col-sm-3 col-xs-12 margin-bottom">
                                        <datepicker name="from"
                                            :format="$root.dateFormatter"
                                            input-class="form-control not-readonly"
                                            :language="lang.{{app()->getLocale()}}"
                                            :value="dateFormatter('{{Session::get('fastOrders.from')}}')"
                                            placeholder="من تاريخ"
                                            :clear-button="true"
                                        ></datepicker>
                                    </div>
                                    <div class="col-sm-3 col-xs-12 margin-bottom">
                                        <datepicker name="to"
                                            :format="$root.dateFormatter"
                                            input-class="form-control not-readonly"
                                            :language="lang.{{app()->getLocale()}}"
                                            :value="dateFormatter('{{Session::get('fastOrders.to')}}')"
                                            placeholder="إلى تاريخ"
                                            :clear-button="true"
                                        ></datepicker>
                                    </div>
                                    <div class="col-sm-2 col-xs-12 margin-bottom">
                                        <select class="form-control" name="status">
                                            <option value="all" selected disabled>حالة الطلب</option>
                                            <option value="all">الكل</option>
                                            <option {{session('fastOrders.status') == "completed" ? 'selected' :''}} value="completed">مكتمل</option>
                                            <option {{session('fastOrders.status') == "pended" ? 'selected' :''}} value="pended">في الانتظار</option>
                                            <option {{session('fastOrders.status') == "canceled" ? 'selected' :''}} value="canceled">ملغي</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1 col-xs-12">
                                        <button type="submit" class="btn btn-success">بحث</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                    <div class="table-responsive ">
                        <table class='table table-hover with-imgs'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Mobile')</th>
                                <th>@lang('City')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fastOrders as $fastOrder)
                                <tr>
                                    <td>{{$fastOrder->id}}</td>
                                    <td>{{$fastOrder->name}}</td>
                                    <td>{{$fastOrder->mobile}}</td>
                                    <td>{{$fastOrder->city->name_ar}} - {{$fastOrder->city->country->name_ar}}</td>
                                    <td>{{$fastOrder->created_at->toDateString()}}</td>
                                    <td>
                                        <label class="label 
                                        @if($fastOrder->status == 'completed') label-success @endif
                                        @if($fastOrder->status == 'pended') label-warning @endif
                                        @if($fastOrder->status == 'canceled') label-default @endif
                                        ">
                                            @lang($fastOrder->status)
                                        </label>
                                    </td>
                                    <td>
                                        <a class="btn btn-success btn-xs"
                                           href="{{action('Admin\FastOrderController@edit',$fastOrder->id)}}">@lang('Show')</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $fastOrders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('includes.delete')
@endsection
