<?php

namespace App\Http\Controllers\User;


use App\Models\Address;
use App\Models\City;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return PaymentMethod::where('is_active', true)->get();

    }

    public function getMethodsOfCity(City $city, ShippingMethod $shippingMethod)
    {
        $isCashOnDeliveryEnabled = DB::table('city_shipping_method')->where([['city_id', $city->id],
            ['shipping_method_id', $shippingMethod->id], ['has_cash_on_delivery', true]])->first();
        if (!$isCashOnDeliveryEnabled) {
            return PaymentMethod::where('is_active', true)->whereNotIn('id', [2])->get(); // 2 = cash on delivery
        }
        return PaymentMethod::where('is_active', true)->get();

    }

    public function getMethodsOfAddress(Address $address, ShippingMethod $shippingMethod)
    {
        $city_id                 = $address->city_id;
        $isCashOnDeliveryEnabled = DB::table('city_shipping_method')->where([['city_id', $city_id],
            ['shipping_method_id', $shippingMethod->id], ['has_cash_on_delivery', true]])->first();
        if (!$isCashOnDeliveryEnabled) {
            return PaymentMethod::where('is_active', true)->whereNotIn('id', [2])->get(); // 2 = cash on delivery
        }
        return PaymentMethod::where('is_active', true)->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
