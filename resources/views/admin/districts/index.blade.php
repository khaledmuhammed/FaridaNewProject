@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Districts')</h1>
@endsection @section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        <div class="clearfix"></div>
    @endif
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">

                    <a class="btn btn-sm btn-success btn-lg btn-new-element"
                       href="{{action('Admin\DistrictController@create')}}">@lang('Add') @lang('District')</a>

                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Arabic Name')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('City')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($districts as $district)
                                <tr>
                                    <td>{{$district->id}}</td>
                                    <td>{{$district->name_ar}}</td>
                                    <td>{{$district->name}}</td>
                                    <td>{{$district->city->name_ar}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"
                                                onclick="location.href='{{action('Admin\DistrictController@edit',$district->id)}}'">@lang('Edit')</button>
                                        <button class="delete-model btn  btn-danger  btn-xs"
                                                data-obj="{{$district->id}}">@lang('Delete')</button>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $districts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('includes.delete')
@endsection
