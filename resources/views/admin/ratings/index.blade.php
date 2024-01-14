@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Ratings')</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>@lang('Product Name')</th>
                                <th>@lang('Rating')</th>
                                <th>@lang('Comment')</th>
                                <th>@lang('Client Name')</th>
                                <th>@lang('Approved?')</th>
                                <th>@lang('Controller')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ratings as $rating)
                                <tr>
                                    <td>{{$rating->Product->name}}</td>
                                    <td>{{$rating->rating}}</td>
                                    <td>{{$rating->comment}}</td>
                                    <td>{{$rating->User->first_name}}</td>
                                    <td> @if($rating->approved == 1)
                                            <span class="label label-success">@lang('Yes')</span> @else
                                            <span class="label label-danger">@lang('No')</span> @endif
                                    </td>
                                    <td nowrap>
                                        <a class="btn btn-primary btn-xs"
                                           href="{{action('Admin\RatingController@edit',$rating->id)}}">@lang('Edit')</a>
                                        <button class="remove-model delete-model btn  btn-danger  btn-xs"
                                                data-path="ratings" data-obj="{{$rating->id}}"
                                                href="javascript:void(0);">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $ratings->links() }}
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
