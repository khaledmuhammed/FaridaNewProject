@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Reports') @lang('Coupons')</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Code')</th>
                                <th>@lang('Usage Limit')</th>
                                <th>@lang('Controller')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($coupons as $coupon)
                                <tr>
                                    <td>{{$coupon->id}}</td>
                                    <td>{{$coupon->code}}</td>
                                    <td>{{$coupon->orders_count}}</td>
                                    <td nowrap>
                                        <a class="btn btn-primary btn-xs"
                                           href="{{action('Admin\ReportsController@couponsShow',$coupon->id)}}">@lang('Show')</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $coupons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        //delete a model object
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
                        if (data.error) {
                            alert(data.error)
                        } else {

                            if (data.url !== 'undefined') {
                                window.location.replace(`{{url('/')}}/admin/${data.url}`);
                            } else {
                                window.location.replace(`{{url('/')}}/admin/${path}`);
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
