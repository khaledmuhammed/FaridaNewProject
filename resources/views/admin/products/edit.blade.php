@extends('adminlte::page')
@section('css')
    <style>
        .box-header.with-submit .box-title {
            line-height : 1.8;
        }

        .multiselect__tags {
            border-radius : 0 !important;
            border        : 1px solid #d2d6de !important;
            min-height    : 39px !important;
        }

        .dropzone .dz-preview .dz-image {
            vertical-align : middle;
            width          : 100px !important;
            height         : 100px !important;
            margin-bottom  : 10px;
        }

        .dropzone .dz-preview .dz-image img {
            display    : block;
            max-width  : 100%;
            max-height : 100%;
        }

        table .form-group {
            margin-bottom : 0;
        }

        td, th {
            vertical-align : middle !important;
        }

        .vue-js-switch {
            margin-top    : 5px;
            margin-bottom : 5px;
        }
    </style>
@endsection
@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        <div class="clearfix"></div>
    @endif
    {{--KPIs 12/*--}}
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-search"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عمليات البحث</span>
                    <span class="info-box-number">{{$product->searched}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-line-chart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عمليات الشراء</span>
                    <span class="info-box-number">{{$product->bought}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue">
                    <i class="fa fa-server"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">الكمية</span>
                    <span class="info-box-number">{{$product->quantity}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue">
                    <i class="fa fa-server"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">بانتظار التوفر</span>
                    <span class="info-box-number">{{$product->whenAvailableUsers->count()}} عضو</span>
                    @if ($product->whenAvailableUsers->count() > 0 && $product->quantity > 0)
                    <span class="info-box-number">
                        <a class="btn btn-default btn-xs" href="{{route('admin.product.whenAvailable', $product->id)}}">إبلاغ عن التوفّر</a>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{--Products Details 12--}}
    <div class="row">
        <product-details
                v-cloak
                action="{{action('Admin\ProductController@update', $product->id)}}"
                :manufacturers="{{$manufacturers}}"
                :labels="{{$labels}}"
                :categories="{{$categories}}"
                :initial_product="{{$product}}"
                :filters="{{$filters}}"
                :properties="{{$properties }}"
        ></product-details>
    </div>

    
    {{--Products Description 12--}}
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-info collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('Product Description')</h3>
                    <div class="box-tools ">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                                class="fa fa-plus"></i></button>
                    </div>
                </div>
                {!!Form::open(['action' => ['Admin\ProductController@updateProductDescription', $product->id], 'method' => 'put','class'=>'form-horizontal'])!!}
                    <div class="box-body">
                        <textarea id="summernote-description" name="description">{{$product->description}}</textarea>
                    </div>
                    <div class="box-footer text-left ">
                        <button type="submit" class="btn btn-success pull-left">@lang('Save')</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
        {{-- <product-description
                v-cloak
                action="{{action('Admin\ProductController@updateProductDescription', $product->id)}}"
                :initial_product="{{$product}}"
        ></product-description> --}}
    </div>
        
    <div class="row">
        {{--Products images 12--}}
        <div class="col-sm-6">
            <div class="box box-info collapsed-box">
                <div class="box-header with-border">
                    <div class="box-title">
                        {{__('Product Images')}}
                    </div>
                    <button type="button" :class="`btn btn-box-tool pull-${$t('direction_end')}`"
                            data-widget="collapse">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <v-media
                                    id="product-images"
                                    url='{{action('Admin\ProductController@addMediaFile',[$product->id])}}'
                                    remove-url='{{action('Admin\MediaController@destroy','')}}'
                                    csrf-token='{{csrf_token()}}'
                                    :images="{{ $product->getMedia('images')->toJson() }}"
                                    param-name='file'
                            ></v-media>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        @foreach($product->getMedia('videos') as $media)
                            <div class="col-sm-4 col-md-3">
                                <div class="thumbnail">
                                    <img src="{{$media->getUrl('thumb')}}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{--Related Products 6--}}
        <related-products v-cloak
                          :product="{{$product}}"
                          :selected="{{$product->relatedProducts}}">
        </related-products>
    </div>

    <div class="row">
        {{--Product's Filter 6--}}
        <product-filter
                v-cloak
                action="{{action('Admin\ProductController@updateProductFilters', $product->id)}}"
                :initial_product="{{$product}}"
                :filters="{{$filters}}">
        </product-filter>

        {{--Products Attributes 6--}}
        <product-attributes
                v-cloak
                action="{{action('Admin\ProductAttributeController@store')}}"
                :initial_product="{{$product}}"
                :attribute_groups="{{$attributeGroups}}"
                :initial_product_attributes="{{$product->productAttributes}}"
                :initial_grouped_attributes="{{$productAttributes}}"
        ></product-attributes>
    </div>
@endsection
@section('js')
    <!--
to get attributes for each attributeGroup
-->
    <script type="text/javascript">
        $(document).ready(function () {
            $('select[name="attributeGroup_id"]').on('change', function () {
                var attributeGroupID = $(this).val();
                if (attributeGroupID) {
                    $.ajax({
                        url     : "{{url('/')}}/admin/product/show/myform/ajax/" + attributeGroupID,
                        type    : "GET",
                        dataType: "json",
                        success : function (data) {
                            $('#subjects').empty();
                            $.each(data, function (key, value) {
                                $('#subjects').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#subjects').empty();
                }
            });
        });

    </script>
    <script>

        $('.save').click(function (e) {
            let object_id = $(this).data('obj');
            let text      = $(this).parents('tr').find('.att').val();
            let el        = $(this);
            $.ajax({
                url     : `{{url('/')}}/admin/product/show/updateAttr/ajax/${object_id}`,
                type    : 'POST',
                dataType: "JSON",
                data    : {
                    "_token": '<?php echo csrf_token() ?>',
                    "text"  : text,
                },
                success : function (data) {
                    el.parents('tr').find('.att').attr('readonly', true)
                    el.hide()
                    el.parents('tr').find('.edit').show()
                },
                error   : function (XMLHttpRequest, textStatus, errorThrown) {
                    el.parents('tr').find('.form-group').addClass('has-error')
                    el.parents('tr').find('.help-block').text(JSON.parse(XMLHttpRequest.responseText).text)
                    el.parents('tr').find('.help-block').show()
                }

            });
        });
    </script>
    <!-- include summernote css/js-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/lang/summernote-ar-AR.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#summernote-description').summernote({
            height: 150,      // set editor height
            minHeight: null,  // set minimum height of editor
            maxHeight: null,  // set maximum height of editor
            lang: 'ar-AR'     // default: 'en-US'
        });
    });
    </script>
@endsection
