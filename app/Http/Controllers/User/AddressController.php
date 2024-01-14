<?php

namespace App\Http\Controllers\User;


use App\Models\Address;
use Illuminate\Http\Request;
use Validator;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::with('city','district')->where('user_id', auth()->id())->get();
        return response($addresses);
    }

    public function show(Address $id)
    {
        return $id;
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
            'district_id'   => 'required|integer',
        ])->validate();

        $address = Address::find($id);
        $address->update($request->all());

        $addresses = $address->user->addresses()->with('city.country')->latest()->get();

        return $addresses;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'city_id'    => 'required|exists:cities,id',
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'district_id'   => 'required|integer',
        ])->validate();

        $address = new Address();
        $address->fill($request->all());
        $address->user_id = auth()->id();
        $address->save();

        if ($request->ajax()) {
            return $address;
        }

        return redirect()->action('Admin\AddressController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $address = Address::find($id);
        $address->delete();
        return back();

    }
}

