@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Featured Products')</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">
                    <a class="btn btn-success btn-new-element"
                       href="{{action('Admin\FeaturedProductController@create')}}">@lang('Add') @lang('Featured Products')</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Title')</th>
                                <th>النوع ( منتجات / قسم )</th>
                                <th>عدد المنتجات / اسم القسم</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($featuredProducts as $featuredProduct)
                                <tr>
                                    <td>{{$featuredProduct->id}}</td>
                                    <td>{{$featuredProduct->theTitle}}</td>
                                    @if($featuredProduct->category)
                                    <td>قسم</td>
                                    <td>{{$featuredProduct->category->name_ar}}</td>
                                    @else
                                    <td>منتجات</td>
                                    <td>{{$featuredProduct->products->count()}}</td>
                                    @endif
                                    <td>
                                        <button class="btn btn-primary btn-xs"
                                                onclick="location.href='{{action('Admin\FeaturedProductController@edit',$featuredProduct->id)}}'">@lang('Edit')</button>
                                        <button class="delete-model btn btn-danger btn-xs" data-path="featured-products"
                                                data-obj="{{$featuredProduct->id}}">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $featuredProducts->links() }}
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
