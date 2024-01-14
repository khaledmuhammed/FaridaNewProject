@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
    <style>
        .dropzone .dz-preview .dz-image {
            display        : table-cell;
            vertical-align : middle;
        }

        .dropzone .dz-preview .dz-image img {
            display    : block;
            max-width  : 100%;
            max-height : 100%;
        }
    </style>
@endsection

@section('content_header')
    <div class="row">
        <div class="col-xs-5">
            <div class="box box-info ">
                <div class="box-header">
                    <div class="box-title">Product : {{$product->name}}</div>
                </div>
                <div class="box-body">
                    <table id="memoirs" class='table table-bordered table-hover '>
                        <tr>
                            <th>#</th>
                            <td>{{$product->id}}</td>
                        </tr>
                        <tr>
                            <th>Product name</th>
                            <td>{{$product->name}}</td>
                        </tr>
                        <tr>
                            <th>product code</th>
                            <td>{{$product->product_code}}</td>
                        </tr>
                        <tr>
                            <th>Original Price</th>
                            <td>{{$product->original_price}}</td>
                        </tr>
                        <tr>
                            <th>Price After Discount</th>
                            <td>{{$product->price_after_discount}}</td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td>{{$product->quantity}}</td>
                        </tr>
                        <tr>
                            <th>Searched</th>
                            <td>{{$product->searched}}</td>
                        </tr>
                        <tr>
                            <th>Bought</th>
                            <td>{{$product->bought}}</td>
                        </tr>
                        <tr>
                            <th>Availability</th>
                            <td>@if($product->availability == 1)
                                    <span class="label label-success">Yes</span> @else
                                    <span class="label label-danger">No</span> @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Availability Date</th>
                            <td>{{$product->availability_date}}</td>
                        </tr>
                        <tr>
                            <th>Manufacturer Name</th>
                            <td>{{$product->manufacturer->name}}</td>
                        </tr>
                        <tr>
                            <th>Category Name</th>
                            <td>@foreach($product->categories as $category)
                                    <span class="label label-info"> {{$category->name}}</span> @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-7">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <div class="box-title">Attributes</div>
                    <hr> {!! Form::open(['action' => 'Admin\ProductAttributeController@store','class'=>'form-horizontal','method' => 'POST']) !!} {{csrf_field()}}
                    {!!Form::hidden ('product_id', $product->id) !!}
                    <div class="form-group  {{$errors->first('level_id') ? 'has-error' :  ''}}">
                        {!! Form::label('attributeGroup_id', 'Attribute Group', ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('attributeGroup_id',$attributeGroups , null, ['placeholder' => 'إختر','class' => 'form-control col-sm-4']) !!}
                        </div>
                    </div>
                    <div class="form-group  {{$errors->first('attribute_id') ? 'has-error' :  ''}}">
                        {!! Form::label('attribute_id', 'Attribute', ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            <select name="attribute_id" class="form-control" id="subjects">
                            </select>
                            @if($errors->first('attribute_id'))
                                <div class="help-block">{{$errors->first('attribute_id')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group  {{$errors->first('level_id') ? 'has-error' :  ''}}">
                        {!! Form::label('text', 'Text', ['class' => 'control-label col-sm-2 ']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('text', old('text'), ['class' => 'form-control','required'=>'required' , 'placeholder'=>' text' ]) !!} @if($errors->first('text'))
                                <div class="help-block">{{$errors->first('text')}}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-10">
                        <button type="submit" class="btn btn-success btn-new-element pull-right">Add
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="box-body">
                    <table class='table table-bordered table-hover '>
                        @foreach( $productAttributes as $productAttribute )
                            <tr>
                                <th>{{$productAttribute->Attribute->name}}</th>
                                <td>
                                    <div class="form-group"><input type="text" value="{{$productAttribute->text}}"
                                                                   class="att form-control" readonly>
                                        <div class="help-block" style="display:none"></div>
                                    </div>
                                </td>
                                <td>
                                    <button class="edit btn btn-primary btn-xs">@lang('Edit')</button>
                                    <button style="display:none" class="save btn btn-info btn-xs"
                                            data-obj="{{$productAttribute->id}}">save
                                    </button>
                                    <button class="remove-model delete-model btn  btn-danger  btn-xs"
                                            data-path="productAttributes" data-obj="{{$productAttribute->id}}"
                                            href="javascript:void(0);">delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <div class="box-title col-sm-8">
                        {!! Form::open(['action' => 'Admin\MediaController@store',$product->id ,'class'=>'form-horizontal','method' => 'POST','enctype'=>'multipart/form-data']) !!} {{csrf_field()}}
                        {!! Form::hidden ('product_id', $product->id); !!}
                        <div class="col-sm-3">
                            {!! Form::label('path', 'Add Images', ['class' => 'control-label ']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::file('path[]',['class' => 'form-control','required'=>'required','multiple']) !!}
                            @if($errors->first('path'))
                                <div class="help-block">{{$errors->first('path')}}</div>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-info btn-block btn-flat pull-left">Add</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">

                        <div class="col-xs-12">
                            <form action="{{action('Admin\MediaController@store',$product->id)}}"
                                  class="dropzone" id="product-image" method="POST">
                                {!! Form::hidden ('product_id', $product->id); !!}
                            </form>
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
                let tr        = $(this).parents('tr')
                $.ajax({
                    url     : `{{url('/')}}/admin/product/show/destroy/ajax/${object_id}`,
                    type    : 'POST',
                    dataType: "JSON",
                    data    : {
                        "_token": '<?php echo csrf_token() ?>',
                    },
                    success : function (data) {
                        tr.remove()
                    },
                });
            }
        });

    </script>
    <script>
        $('.edit').click(function (e) {
            //Make input editable
            $(this).parents('tr').find('.att').attr('readonly', false)
            $(this).hide()
            $(this).parents('tr').find('.save').show()
        });
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

    <script src="{{asset('js/dropzone.js')}}"></script>

    <script>
        let myAwesomeDropzone         = '';
        Dropzone.options.productImage = { // The camelized version of the ID of the form element
            autoProcessQueue  : true,
            parallelUploads   : 100,
            maxFiles          : 100,
            method            : 'post',
            paramName         : 'path[]',
            acceptedFiles     : 'image/*',
            addRemoveLinks    : true,
            {{--dictRemoveFile: '{{trans('branches.remove')}}',--}}
                    {{--dictDefaultMessage: '{{trans('branches.alreadyJoined')}}',--}}
            dictRemoveFile    : 'حذف',
            dictDefaultMessage: 'أفلت الصور هنا لرفعها',

            success    : function (file, response) {
                file.newName = response.name;
            },
            init       : function () {
                myAwesomeDropzone = this;
                this.on("sending", function (file, xhr, formData) {
                    formData.append("_token", $('input[name="_token"]').val());
                });

                //--------- Get old images-----------///
                function previewThumbailFromUrl(opts) {
                    let mockFile = {
                        name    : opts.fileName,
                        accepted: true,
                        kind    : 'image',
                        url     : opts.url,
                        size    : opts.size
                    };

                    /*   myAwesomeDropzone.emit("addedfile", mockFile);
                     myAwesomeDropzone.files.push(mockFile);
                     myAwesomeDropzone.createThumbnailFromUrl(mockFile, mockFile.url, function () {
                     myAwesomeDropzone.emit("complete", mockFile);
                     });*/


                    myAwesomeDropzone.files.push(mockFile);
                    myAwesomeDropzone.emit('addedfile', mockFile);
                    myAwesomeDropzone.emit("thumbnail", mockFile, mockFile.url);
                    myAwesomeDropzone.emit('complete', mockFile);

                }

                @if($product->media->count() > 0)
                @foreach($product->media as $image)

                previewThumbailFromUrl({
                    selector: 'img',
                    fileName: '{{$image->id}}',
                    url     : '{{$image->tiny_image}}',
                    size    : '{{$image->size}}',
                });

                @endforeach
                @endif

                //--------------------//


            },
            removedfile: function (file) {

                let name = '';
                if (file.newName == undefined) {
                    name = file.name;
                } else {
                    name = file.newName;
                }
                let r = confirm("حذف الصورة ؟");
                if (r) {
                    $.ajax({
                        type    : 'POST',
                        dataType: "JSON",
                        data    : {
                            _token : '<?php echo csrf_token() ?>',
                            _method: 'delete'
                        },
                        url     : '{{action('Admin\MediaController@destroy','')}}/' + name,
                    });
                    let _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(
                        file.previewElement) : void 0;
                }
            }
        };
    </script>
@endsection