<?php

namespace App\Http\Controllers\User;


use App\Models\Option;

class OptionController extends Controller
{
    public function index()
    {
        $option = Option::all();
        return $option;

    }

    public function show(Option $id)
    {
        return $id;

    }
}
