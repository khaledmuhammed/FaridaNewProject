@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Banners')</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">
                    <a class="btn btn-sm btn-success btn-lg btn-new-element"
                       href="{{action('Admin\BannerController@create')}}">@lang('Add') @lang('Banner')</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Size')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($banners as $banner)
                                <tr>
                                    <td>{{$banner->id}}</td>
                                    <td>{{$banner->title}}</td>
                                    <td>{{$banner->size}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"
                                                onclick="location.href='{{action('Admin\BannerController@edit',$banner->id)}}'">@lang('Edit')</button>
                                        <button class="delete-model btn  btn-danger  btn-xs"
                                                data-obj="{{$banner->id}}">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $banners->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('includes.delete')
@endsection
