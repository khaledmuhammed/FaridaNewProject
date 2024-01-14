@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Mail List')</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">
                    <a class="btn btn-sm btn-success btn-lg btn-new-element"
                       href="{{action('Admin\MailListController@create')}}">@lang('Add') @lang('Email')</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Controllers')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($emails as $email)
                                <tr>
                                    <td>{{$email->id}}</td>
                                    <td>{{$email->email}}</td>
                                    <td nowrap>
                                        <button class="delete-model btn  btn-danger  btn-xs"
                                                data-obj="{{$email->id}}">@lang('Delete')</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $emails->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('includes.delete')
@endsection
