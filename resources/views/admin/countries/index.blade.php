@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Countries')</h1>
@endsection @section('content')
@if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    <div class="clearfix"></div>
@endif
@if (Session::has('errors'))
    <div class="alert alert-danger">
        {{ Session::get('errors') }}
    </div>
    <div class="clearfix"></div>
@endif
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">
                    <a class="btn btn-sm btn-success btn-lg btn-new-element"
                       href="{{action('Admin\CountryController@create')}}">@lang('Add') @lang('Country')</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Country Name')</th>
                                <th>@lang('Arabic Name')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($countries as $country)
                                <tr>
                                    <td>{{$country->id}}</td>
                                    <td>{{$country->name}}</td>
                                    <td>{{$country->name_ar}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"
                                                onclick="location.href='{{action('Admin\CountryController@edit',$country->id)}}'">@lang('Edit')</button>
                                        <button class="delete-model btn  btn-danger  btn-xs"
                                                data-obj="{{$country->id}}">@lang('Delete')</button>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $countries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('includes.delete')
@endsection
