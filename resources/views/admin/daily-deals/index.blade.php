@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Daily Deal')</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-new-element"
                       href="{{action('Admin\DailyDealController@create')}}">@lang('Add') @lang('Daily Deal')</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Product Name')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Quantity')</th>
                                <th>@lang('Start Date')</th>
                                <th>@lang('End Date')</th>
                                <th>@lang('Controller')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dailyDeals as $dailyDeal)
                                <tr>
                                    <td>{{$dailyDeal->id}}</td>
                                    <td>{{$dailyDeal->Product->name}}</td>
                                    <td>{{$dailyDeal->price}}</td>
                                    <td>{{$dailyDeal->quantity}}</td>
                                    <td>{{$dailyDeal->start_date}}</td>
                                    <td>{{$dailyDeal->end_date}}</td>
                                    <td nowrap>
                                        <a class="btn btn-primary btn-xs"
                                           href="{{action('Admin\DailyDealController@edit',$dailyDeal->id)}}">@lang('Edit')</a>
                                        <button class="remove-model delete-model btn  btn-danger  btn-xs"
                                                data-path="dailyDeals" data-obj="{{$dailyDeal->id}}"
                                                href="javascript:void(0);">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $dailyDeals->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>//delete a model object
        //delete a model object
        //-- data-path : model route
        //-- data-obj : object id
        $('.delete-model').click(function (e) {
            e.preventDefault();

            let r = confirm("@lang("Do you want to delete it ?")");
            if (r == true) {

                let object_id = $(this).data('obj');
                let path      = $(this).data('path');

                $.ajax({
                    url     : `{{url('/')}}/admin/${path}/${object_id}`,
                    type    : 'POST',
                    dataType: "JSON",
                    data    : {
                        "_method": 'DELETE',
                        "_token" : '<?php echo csrf_token() ?>',
                    },
                    success : function (data) {
                        if (data.url !== 'undefined') {
                            window.location.replace(`{{url('/')}}/admin/${data.url}`);
                        } else {
                            window.location.replace(`{{url('/')}}/admin/${path}`);
                        }
                    },
                });
            }
        });
    </script>
@endsection
