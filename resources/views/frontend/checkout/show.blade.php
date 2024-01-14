@extends('frontend.layouts.app')
@section('top-content')
@endsection
@section('content')
    <div id="checkout">
        <div class="container">
            <div class="row" v-if="$store.state.cart.items.length">
                <div class="col-sm-4 border-left">
                    @auth
                        <v-address :addresses="{{$addresses}}" route="{{route('addresses.store')}}"
                                    ref="address"></v-address>
                    @else
                        <guest-info ref="guest"></guest-info>
                        
                    @endauth
                    <receiver-info ref="receiver"></receiver-info>
                    
                </div>
                <div class="col-sm-4 ">
                    <shipping ref="shipping" free_shipping_limit="{{$settings['free_shipping_limit']}}"></shipping>
                    <br>
                    <hr class="visible-xs">
                    <br>

                    <payment ref="payment" user_id="{{auth()->id()}}"></payment>
                </div>
                <br class="visible-xs">
                <hr class="visible-xs">
                <br class="visible-xs">
                <div class="col-sm-4 no-padding border-right">
                    <v-summary :addresses="{{$addresses}}" @auth :user="{{auth()->user()}}" @endauth
                                payments_redirect_url="{{route('moyasar.payments_redirect')}}"
                                moyasar_publishable_api_key="{{config('services.moyasar.publishable_api_key')}}"
                                ref="summary"
                                ></v-summary>
                </div>
            </div>
            <div class="row" v-else>
                <div class="col-xs-12">
                    <h3 class="text-center"> @lang('Cart Empty')</h3>
                </div>
            </div>
        </div>
    </div>
@endsection

