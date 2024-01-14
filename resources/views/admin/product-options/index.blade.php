@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Product')</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-new-element"
                       href="{{action('Admin\ProductController@create')}}">@lang('Add') @lang('Product')</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Product Name')</th>
                                <th>@lang('product Code')</th>
                                <th>@lang('Original Price')</th>
                                <th>@lang('Price After Discount')</th>
                                <th>@lang('Quantity')</th>
                                <th>@lang('Searched')</th>
                                <th>@lang('Bought')</th>
                                {{--<th>Availability</th>--}}
                                {{--<th>Availability Date</th>--}}
                                <th>@lang('Manufacturer Name')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->product_code}}</td>
                                    <td>{{$product->original_price}}</td>
                                    <td>{{$product->price_after_discount}}</td>
                                    <td>{{$product->quantity}}</td>
                                    <td>{{$product->searched}}</td>
                                    <td>{{$product->bought}}</td>
                                    {{--
                                                                        <td>
                                                                        @if($product->availability == 1)
                                                                        <span class="label label-success">Yes</span>
                                                                        @else
                                                                        <span class="label label-danger">No</span>
                                                                        @endif
                                                                        </td>
                                                                        <td>{{$product->availability_date}}</td>
                                    --}}
                                    <td>{{$product->manufacturer->name}}</td>
                                    <td>
                                        <a class="btn btn-success btn-xs"
                                           href="{{action('Admin\ProductController@show',$product->id)}}">@lang('Show')</a>
                                        <a class="btn btn-primary btn-xs"
                                           href="{{action('Admin\ProductController@edit',$product->id)}}">@lang('Edit')</a>
                                        <button class="remove-model delete-model btn  btn-danger  btn-xs"
                                                data-path="products" data-obj="{{$product->id}}"
                                                href="javascript:void(0);">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $products->links() }}
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
