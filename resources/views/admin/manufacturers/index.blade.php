@extends('adminlte::page')
@section('css')
    <style>
        .with-imgs td {
            vertical-align : middle !important;
        }

        .logo {
            height : 50px;
        }
    </style>
@endsection
@section('content_header')
    <h1>@lang('Manufacturers')</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-new-element"
                       href="{{action('Admin\ManufacturerController@create')}}">@lang('Add') @lang('Manufacturer')</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive ">
                        <table class='table table-hover with-imgs'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Logo')</th>
                                <th>@lang('Manufacturer Name')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($manufacturers as $manufacturer)
                                <tr>
                                    <td>{{$manufacturer->id}}</td>
                                    <td>
                                        @if ($manufacturer->getFirstMedia('logo'))
                                        <img class="img-viewer" src="{{$manufacturer->getFirstMedia('logo')->getUrl()}}" height="50" />
                                        @endif
                                    </td>
                                    <td>{{$manufacturer->name}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-xs"
                                           href="{{action('Admin\ManufacturerController@edit',$manufacturer->id)}}">@lang('Edit')</a>
                                        <button class="delete-model btn  btn-danger  btn-xs"
                                                data-obj="{{$manufacturer->id}}">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $manufacturers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('includes.delete')
@endsection
