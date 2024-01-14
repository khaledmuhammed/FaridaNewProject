@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Filter Options')</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-new-element"
                       href="{{action('Admin\FilterOptionController@create')}}">@lang('Add') @lang('Filter Option')</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('English Name')</th>
                                <th>@lang('Arabic Name')</th>
                                <th>@lang('Filter Name')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($filterOptions as $filterOption)
                                <tr>
                                    <td>{{$filterOption->id}}</td>
                                    <td>{{$filterOption->name}}</td>
                                    <td>{{$filterOption->name_ar}}</td>
                                    <td>{{$filterOption->filter->name}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-xs"
                                           href="{{action('Admin\FilterOptionController@edit',$filterOption->id)}}">@lang('Edit')</a>
                                        <button class="remove-model delete-model btn  btn-danger  btn-xs"
                                                data-path="filter-options" data-obj="{{$filterOption->id}}"
                                                href="javascript:void(0);">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $filterOptions->links() }}
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
