<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{DistrictZone, City};
use Illuminate\Http\Request;
use Validator;

class DistrictZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districtZones = DistrictZone::with('city')->paginate(25);
        return view('admin.district-zones.index', [
            'districtZones' => $districtZones,
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
        return view('admin.district-zones.create', [
            'cities' => $cities,
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
            'name'    => 'required',
            'city_id' => 'required|exists:cities,id',
        ])->validate();

        $districtZone = new DistrictZone();
        $districtZone->fill($request->all());
        $districtZone->save();

        session()->flash('success', 'تمت إضافة المنطقة بنجاح');
        return redirect()->action('Admin\DistrictZoneController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DistrictZone  $districtZone
     * @return \Illuminate\Http\Response
     */
    public function show(DistrictZone $districtZone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DistrictZone  $districtZone
     * @return \Illuminate\Http\Response
     */
    public function edit(DistrictZone $districtZone)
    {
        $cities = City::pluck('name_ar', 'id');
        return view('admin.district-zones.edit', [
            'cities'   => $cities,
            'districtZone'   => $districtZone,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DistrictZone  $districtZone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DistrictZone $districtZone)
    {
        Validator::make($request->all(), [
            'name'    => 'required',
            'city_id' => 'required|exists:cities,id',
        ])->validate();

        $districtZone->update($request->all());

        session()->flash('success', 'تمت تعديل المنطقة بنجاح');
        return redirect()->action('Admin\DistrictZoneController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DistrictZone  $districtZone
     * @return \Illuminate\Http\Response
     */
    public function destroy(DistrictZone $districtZone)
    {
        //
    }
}
