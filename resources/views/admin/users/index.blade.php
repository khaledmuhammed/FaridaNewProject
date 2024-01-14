@extends('adminlte::page')

@section('content_header')

    <h1>@lang('Users')</h1>
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
                       href="{{action('Admin\UserController@create')}}">@lang('Add') @lang('User')</a>
                    <a class="btn btn-sm btn-default btn-lg btn-new-element pull-left"
                        href="{{route('admin.users.export')}}">تصدير العملاء</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Mobile')</th>
                                <th>@lang('Gender')</th>
                                <th>@lang('City')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->mobile}}</td>
                                    <td>@if($user->gender == "M") @lang('Male') @else @lang('Female') @endif</td>
                                    <td>{{$user->city->name_ar}}</td>
                                    <td nowrap>
                                        <a class="btn btn-success btn-xs"
                                           href="{{action('Admin\UserController@edit',$user->id)}}">@lang('Edit')</a>
                                        <button class="delete-model btn  btn-danger  btn-xs"
                                                data-obj="{{$user->id}}">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('includes.delete')
@endsection
