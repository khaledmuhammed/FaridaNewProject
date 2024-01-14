<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::paginate(15);
        return view('admin.countries.index', [
            'countries' => $countries,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.countries.create');
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
            'name'    => 'required|string',
            'name_ar' => 'required|string',
        ])->validate();

        $country = new Country();
        $country->fill($request->all());
        $country->save();

        session()->flash('success', 'تمت إضافة الدولة بنجاح');
        return redirect()->action('Admin\CountryController@index');

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
        $country = Country::find($id);
        return view('admin.countries.edit', [
            'country' => $country,
        ]);
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
            'name'    => 'required|string',
            'name_ar' => 'required|string',
        ])->validate();

        $country = Country::find($id);
        $country->update($request->all());

        session()->flash('success', 'تمت تعديل بيانات الدولة بنجاح');
        return redirect()->action('Admin\CountryController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::find($id);
        $country->delete();
        return back();
    }

    public function countriesWithCities()
    {
        // + with districts
        $countries = Country::whereHas('cities')->with('cities.districts.districtZone')->get();
        return response()->json([
            'countries' => $countries,
            // 'city_id' => $city_id,
            // 'country_id' => $country_id,
        ]);
    }
}
