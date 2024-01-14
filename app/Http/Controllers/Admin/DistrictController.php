<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{District, DistrictZone};
use Illuminate\Http\Request;
use App\Models\City;
use Validator;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = District::with('city')->paginate(25);
        return view('admin.districts.index', [
            'districts' => $districts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::pluck('name_ar', 'id');
        $districtZones = DistrictZone::pluck('name', 'id');
        return view('admin.districts.create', [
            'cities' => $cities,
            'districtZones' => $districtZones,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name'       => 'required',
            'name_ar'    => 'required',
            'city_id' => 'required|exists:cities,id',
        ])->validate();

        $district = new District();
        $district->fill($request->all());
        $district->save();

        session()->flash('success', 'تمت إضافة الحي بنجاح');
        return redirect()->action('Admin\DistrictController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        // $city      = City::find($id);
        $cities = City::pluck('name_ar', 'id');
        $districtZones = DistrictZone::pluck('name', 'id');
        return view('admin.districts.edit', [
            'district' => $district,
            'cities'   => $cities,
            'districtZones'   => $districtZones,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $district)
    {
        Validator::make($request->all(), [
            'name'       => 'required',
            'name_ar'    => 'required',
            'city_id' => 'required|exists:cities,id',
        ])->validate();

        $district->update($request->all());

        session()->flash('success', 'تم تعديل الحي بنجاح');
        return redirect()->action('Admin\DistrictController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        //
    }
}
