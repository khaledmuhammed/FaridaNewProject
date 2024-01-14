@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Positions')</h1>
@endsection @section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('English Name')</th>
                                <th>@lang('Arabic Name')</th>
                                <th>#@lang('NO. positionables')</th>
                                <th>@lang('Controller')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($positions as $position)
                                <tr>
                                    <td>{{$position->id}}</td>
                                    <td>{{$position->name}}</td>
                                    <td>{{$position->name_ar}}</td>
                                    <td>{{$position->banners->count() + $position->featuredProducts->count() }}</td>

                                    <td nowrap="">
                                        <a class="btn btn-primary btn-xs"
                                           href="{{action('Admin\PositionController@edit',$position->id)}}">@lang('Edit')</a>
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
