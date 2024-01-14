<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use Illuminate\Http\Request;
use Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::with('city')->paginate(15);
        return view('admin.addresses.index', [
            'addresses' => $addresses,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $address = Address::find($id);
        $cities  = City::pluck('name', 'id');
        return view('admin.addresses.edit', [
            'cities'  => $cities,
            'address' => $address,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'city_id'    => 'required|exists:cities,id',
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'details'    => 'required|string',
        ])->validate();

        $address = Address::find($id);
        $address->update($request->all());

        return redirect()->action('Admin\AddressController@index');
    }

}
