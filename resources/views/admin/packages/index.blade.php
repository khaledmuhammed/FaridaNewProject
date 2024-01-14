@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Packages')</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-new-element"
                       href="{{action('Admin\PackageController@create')}}">@lang('Add') @lang('Package')</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Package Name')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Quantity')</th>
                                {{--<th>@lang('Searched')</th>--}}
                                {{--<th>@lang('Bought')</th>--}}
                                <th>@lang('Available?')</th>
                                <th>@lang('Availability Date')</th>
                                <th>@lang('Controller')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($packages as $package)
                                <tr>
                                    <td>{{$package->id}}</td>
                                    <td>{{$package->name}}</td>
                                    <td>{{$package->price}}</td>
                                    <td>{{$package->quantity}}</td>
                                    {{--<td>{{$package->searched}}</td>--}}
                                    {{--<td>{{$package->bought}}</td>--}}
                                    <td>
                                        @if($package->availability == 1)
                                            <span class="label label-success">@lang('Yes')</span>
                                        @else
                                            <span class="label label-danger">@lang('No')</span>
                                        @endif
                                    </td>
                                    <td>{{$package->availability_date}}</td>
                                    <td nowrap>
                                        {{--                                        <a class="btn btn-success btn-xs" href="{{action('Admin\PackageController@show',$package->id)}}">@lang('Show')</a>--}}
                                        <a class="btn btn-primary btn-xs"
                                           href="{{action('Admin\PackageController@edit',$package->id)}}">@lang('Edit')</a>
                                        <button class="remove-model delete-model btn  btn-danger  btn-xs"
                                                data-path="packages" data-obj="{{$package->id}}"
                                                href="javascript:void(0);">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $packages->links() }}
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
