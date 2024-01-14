@extends('frontend.layouts.app')

@section('content')
    <div id="user-profile">
        <div class="row bg-gray-light">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <user-orders route="{{route('latest-orders',Auth::id())}}" order_route="{{route('order','')}}"></user-orders>
                    </div>
                    <div class="col-sm-4">
                        <div class="col-sm-12 no-padding">
                            <user-info :user="{{$user}}" route="{{route('users.update',$user)}}"></user-info>
                        </div>
                        <div class="col-sm-12 no-padding">
                            <user-addresses :addresses="{{$addresses}}" route="{{route('addresses.store')}}"></user-addresses>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
