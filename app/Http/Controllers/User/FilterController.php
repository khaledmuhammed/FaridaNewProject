<?php

namespace App\Http\Controllers\User;


use App\Models\Attribute;
use App\Models\Filter;

class FilterController extends Controller
{
    public function index()
    {
        $filter     = Filter::all();
        $attributes = Attribute::with('productAttributes')->get();
        return $attributes;

    }

    public function show(Filter $id)
    {
        return $id;

    }
}
