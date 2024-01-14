@extends('adminlte::page')

@section('content_header')
    <h1>@lang('District Zones')</h1>
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
                       href="{{action('Admin\DistrictZoneController@create')}}">@lang('Add') @lang('Zone')</a>

                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Name')</th>
                                <th>@lang('City')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($districtZones as $districtZone)
                                <tr>
                                    <td>{{$districtZone->id}}</td>
                                    <td>{{$districtZone->name}}</td>
                                    <td>{{$districtZone->city->name_ar}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"
                                                onclick="location.href='{{action('Admin\DistrictZoneController@edit',$districtZone->id)}}'">@lang('Edit')</button>
                                        <button class="delete-model btn btn-danger btn-xs"
                                                data-obj="{{$districtZone->id}}">@lang('Delete')</button>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $districtZones->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('includes.delete')
@endsection
