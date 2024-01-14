<?php

namespace App\Http\Controllers\User;


class RelatedProductsController extends Controller
{
    public function index()
    {

        $related_products = Related_products::all();
        return $related_products;
    }

    public function show(Related_products $id)
    {

        return $id;

    }
}
