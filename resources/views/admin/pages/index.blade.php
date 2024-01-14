@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Pages')</h1>
@endsection

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    <div class="clearfix"></div>
@endif
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-new-element pull-left"
                       href="{{action('Admin\PageController@create')}}">@lang('Add') @lang('Page')</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td>{{$page->id}}</td>
                                    <td>{{$page->theTitle}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" onclick="location.href='{{action('Admin\PageController@edit',$page->id)}}'">@lang('Edit')</button>
                                        <button class="delete-model btn  btn-danger  btn-xs" data-obj="{{$page->id}}">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('includes.delete')
@endsection
