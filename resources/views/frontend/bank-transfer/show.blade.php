@extends('frontend.layouts.app')
@section('content')
    <h1 class="text-center text-primary">@lang('Bank Transfer Form')</h1>
    <div class="row">
        @if ($msg)
            <div class="text-center">
                {!! $msg !!}
            </div>
        @else
            @if ($order)
                @if ($order->bankTransfer)
                <div class="text-center">
                    @lang('The bank transfer form has been submitted previously').
                </div>
                @else
                <bank-transfer order_id="{{$order->id}}"></bank-transfer>
                @endif
            @else
            <div class="text-center">
                @lang('Sorry! The order does not exist').
            </div>
            @endif
        @endif
    </div>
@endsection
