<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class GoogleMerchantController extends Controller
{
    public function feed()
    {
        return response()->view('admin.google-merchant-feed',[
            'products' => Product::where('availability' , true)->get()
        ])->header('Content-Type', 'application/xml');
    }
}
