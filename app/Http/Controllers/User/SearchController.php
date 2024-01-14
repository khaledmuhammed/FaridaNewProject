<?php

namespace App\Http\Controllers\User;


use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Return a Json of a products
     */
    public function autocomplete(Request $request)
    {
        $product = Product::with('ratings', 'media', 'activeDailyDeal')
        ->where("name", "like", '%' . $request->input("query") . '%')
        ->orWhere("name_en", "like", '%' . $request->input("query") . '%')
        ->take(5)->get();
        $product = $product->each(function ($item) {
            $item->append('finalPrice', 'rating');
        });
        return $product->toJson();
    }
}
