@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Addresses')</h1>
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Name')</th>
                                <th>@lang('City')</th>
                                <th>@lang('Details')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($addresses as $address)
                                <tr>
                                    <td>{{$address->id}}</td>
                                    <td>
                                        <a href="{{route('admin.users.edit',$address->user_id)}}">{{$address->name}}</a>
                                    </td>
                                    <td>{{$address->city->name}}</td>
                                    <td>{{$address->details}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"
                                                onclick="location.href='{{action('Admin\AddressController@edit',$address->id)}}'">@lang('Edit')</button>
                                        <button class="delete-model btn  btn-danger  btn-xs"
                                                data-obj="{{$address->id}}">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $addresses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('includes.delete')
@endsection
