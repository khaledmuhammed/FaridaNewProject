<?php

namespace App\Http\Controllers\User;


class OrderItemController extends Controller
{
    public function index()
    {
        $order_item = Order_item::all();
        return $order_item;

    }

    public function show(Order_item $id)
    {
        return $id;

    }
}
