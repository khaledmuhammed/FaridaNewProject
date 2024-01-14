<?php

namespace App\Http\Controllers\User;


use App\Models\Product;

class DailyDealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::whereHas('activeDailyDeal')->with('ratings.user', 'media', 'activeDailyDeal')->get();
        $products = $products->each(function ($item) {
            $item->append('finalPrice', 'rating', 'largeThumbnail', 'dailyDealPrice');
        });
        return view("frontend.daily-deals.show", compact(['products']));
    }

}
