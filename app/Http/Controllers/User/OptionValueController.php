<?php

namespace App\Http\Controllers\User;


use App\Models\OptionValue;

class OptionValueController extends Controller
{
    public function index()
    {
        $option_value = Option_value::all();
        return $option_value;

    }

    public function show(Option_value $id)
    {
        return $id;

    }
}
