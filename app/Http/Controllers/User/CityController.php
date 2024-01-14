<?php

namespace App\Http\Controllers\User;


use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        $city = City::all();
        return $city;

    }

    public function show(City $id)
    {
        return $id;

    }

}
