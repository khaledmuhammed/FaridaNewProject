@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Cities')</h1>
@endsection @section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">

                    <a class="btn btn-sm btn-success btn-lg btn-new-element"
                       href="{{action('Admin\CityController@create')}}">@lang('Add') @lang('City')</a>

                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('City Arabic Name')</th>
                                <th>@lang('City Name')</th>
                                <th>@lang('Country Name')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cities as $city)
                                <tr>
                                    <td>{{$city->id}}</td>
                                    <td>{{$city->name_ar}}</td>
                                    <td>{{$city->name}}</td>
                                    <td>{{$city->country->name_ar}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"
                                                onclick="location.href='{{action('Admin\CityController@edit',$city->id)}}'">@lang('Edit')</button>
                                        <button class="delete-model btn  btn-danger  btn-xs"
                                                data-obj="{{$city->id}}">@lang('Delete')</button>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $cities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('includes.delete')
@endsection
