@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Categories')</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-new-element"
                       href="{{action('Admin\CategoryController@create')}}">@lang('Add') @lang('Category')</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Category Name')</th>
                                <th>@lang('Super Category Name')</th>
                                <th>@lang('Active?')</th>
                                <th>@lang('Featured?')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->id}}</td>
                                    <td>{{$category->theName}}</td>
                                    <td>
                                        @if($category->superCategory)
                                            {{$category->superCategory->theName}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($category->is_active)
                                            <span class="label label-success">@lang('Yes')</span>
                                        @else
                                            <span class="label label-danger">@lang('No')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($category->is_featured)
                                            <span class="label label-success">@lang('Yes')</span>
                                        @else
                                            <span class="label label-danger">@lang('No')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-xs"
                                           href="{{action('Admin\CategoryController@edit',$category->id)}}">@lang('Edit')</a>
                                        <button class="remove-model delete-model btn  btn-danger  btn-xs"
                                                data-path="categories" data-obj="{{$category->id}}"
                                                href="javascript:void(0);">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#memoirs').DataTable()
        });
    </script>
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
