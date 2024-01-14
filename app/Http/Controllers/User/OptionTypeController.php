<?php

namespace App\Http\Controllers\User;


class OptionTypeController extends Controller
{
    public function index()
    {
        $option_type = Option_type::all();
        return $option_type;

    }

    public function show(Option_type $id)
    {
        return $id;

    }
}
