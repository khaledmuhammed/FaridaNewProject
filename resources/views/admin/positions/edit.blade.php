@extends('adminlte::page')

@section('content_header')
    <h1>@lang('Edit') {{app()->isLocale('ar') ? $position->name_ar : $position->name}}</h1>
@endsection @section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                {!!Form::model($position, ['action' => ['Admin\PositionController@sort', $position->id], 'method' => 'post','class'=>'form-horizontal'])!!}
                <div class="box-body">
                    <positionables :position="{{$position}}"></positionables>
                </div>
                <div class="box-footer">
                    <div class="col-sm-2 col-sm-offset-10 no-padding">
                        <button type="submit" class="btn btn-info btn-block btn-flat ">@lang('Save')</button>
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('.sort').keyup(function () {
            clearTimeout($.data(this, 'timer'));
            var wait = setTimeout(saveData, 500); // delay after user types
            $(this).data('timer', wait);
        });

        function saveData() {
            // ... ajax ...
            console.log($('.sort'))
        }
    </script>
@endsection

