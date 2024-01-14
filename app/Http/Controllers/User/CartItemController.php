<?php

namespace App\Http\Controllers\User;


use App\Models\CartItem;

class CartItemController extends Controller
{
    public function index()
    {

        $cartItems = CartItem::all();
        return $cartItems;
    }

    public function show(CartItem $cartItem)
    {

        return $cartItem;

    }
}
