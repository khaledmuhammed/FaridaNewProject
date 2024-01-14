<?php

namespace App\Http\Controllers\User;


use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\Product;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use App\Services\Aramex;

class ShippingMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ShippingMethod::where('is_active', true)->get();
    }


    public function getMethodsForAddress(Address $address)
    {
        $city = City::find($address->city_id);
        return $city->shippingMethods()->where('is_active', true)->get();
    }


    public function getMethodsForCity(City $city)
    {
        return $city->shippingMethods()->where('is_active', true)->get();
    }

    public static function getShippingPrice(Request $request)
    {
        if (!$request['city_id'] ) {
            return response(['errors' => 'city_id not found'], 422);
        }

        $city = City::find($request['city_id']);

        $aramex =  new Aramex;
        $rate   = $aramex->calculateRate($city);
        if ($rate->HasErrors == false) {
            $shippingPrice = $rate->TotalAmount->Value;
        } else {
            return response(['errors' => 'calculate error'], 422);
        }

        return response(['shippingPrice' => $shippingPrice]);
    }
}
