<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ShippingMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippingMethods = ShippingMethod::paginate(15);
        return view('admin.shipping-methods.index', compact('shippingMethods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        return view('admin.shipping-methods.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name'      => 'required',
            'price'     => 'required|integer',
            'is_active' => 'required|boolean',
        ])->validate();

        $ShippingMethod = new ShippingMethod();
        $ShippingMethod->fill($request->all());
        $ShippingMethod->save();
        $ShippingMethod->cities()->sync($request->city_id);

        return redirect()->action('Admin\ShippingMethodController@index');
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
        $shippingMethod = ShippingMethod::with('cities', 'cashOnDeliveryCities')->find($id);
        $cities         = City::all();
        return view('admin.shipping-methods.edit', compact(['shippingMethod', 'cities']));
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
        Validator::make($request->all(), [
            'name'      => 'required',
            'price'     => 'required|integer',
            'is_active' => 'required|boolean',
        ])->validate();

        $ShippingMethod = ShippingMethod::find($id);
        $ShippingMethod->update($request->all());
        $ShippingMethod->cities()->sync($request->city_id);

        return redirect()->action('Admin\ShippingMethodController@index');
    }

    public function cashOnDelivery(Request $request, $id)
    {
        $ShippingMethod = ShippingMethod::find($id);
        //reset all shipping method cities to be not cash on delivery
        DB::table('city_shipping_method')->where('shipping_method_id', $id)->update(['has_cash_on_delivery' => false]);

        //then set only the selected cities to be cash on delivery cities
        foreach ($request->city_id as $city_id) {
            $ShippingMethod->cities()->updateExistingPivot($city_id, [
                'has_cash_on_delivery' => true,
            ]);
        }
        return redirect()->action('Admin\ShippingMethodController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ShippingMethod = ShippingMethod::find($id);
        $ShippingMethod->delete();
        return response(['url' => 'shipping-methods']);
    }
}
