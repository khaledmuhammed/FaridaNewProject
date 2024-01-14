<?php

namespace App\Http\Controllers\User;


use App\Models\CartItem;
use Auth;
use Illuminate\Http\Request;
use Validator;

class CartController extends Controller
{
    public function addItem(Request $request)
    {
        $data = $request->only('product_id');
        Validator::make($data, [
            'product_id' => 'required|integer|exists:products,id',
        ])->validate();

        $item             = new CartItem;
        $item->product_id = $data['product_id'];
        $item->user_id    = Auth::user()->id;
        $item->save();
        return [
            'status' => 1
        ];
    }

    public function getCart()
    {
        return CartItem::where('user_id', Auth::user()->id)->paginate(20);
    }
}
