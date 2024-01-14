@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Testimonials')</h1>
@endsection @section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-bpoint">
                    <a class="btn btn-sm btn-success btn-lg btn-new-element"
                       href="{{action('Admin\TestimonialController@create')}}">@lang('Add') @lang('Testimonial')</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th width="150">@lang('Username')</th>
                                <th width="250">@lang('Title')</th>
                                <th>@lang('Comment')</th>
                                <th width="70">@lang('Featured')@lang('?')</th>
                                <th width="100">@lang('Controller')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($testimonials as $testimonial)
                                <tr>
                                    <td>{{$testimonial->id}}</td>
                                    <td>{{$testimonial->username}}</td>
                                    <td>{{$testimonial->title}}</td>
                                    <td>{{$testimonial->comment}}</td>
                                    <td>
                                        @if($testimonial->featured == 1)
                                            <span class="label label-success">@lang('Yes')</span>
                                        @else
                                            <span class="label label-danger">@lang('No')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"
                                                onclick="location.href='{{action('Admin\TestimonialController@edit',$testimonial->id)}}'">@lang('Edit')</button>
                                        <button class="delete-model btn  btn-danger  btn-xs"
                                                data-obj="{{$testimonial->id}}">@lang('Delete')</button>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $testimonials->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('includes.delete')
@endsection
