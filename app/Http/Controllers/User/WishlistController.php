<?php

namespace App\Http\Controllers\User;


use App\Models\WishlistItem;
use Auth;

class WishlistController extends Controller
{
    /**
     * @param $product_id
     * @return array
     * @throws \Exception
     */
    public function toggleItemStatus($product_id)
    {
        if ($product_id) {

            $item = WishlistItem::where(['user_id' => auth()->id(), 'product_id' => $product_id])->first();
            if ($item) {
                $item->delete();
                return ['status' => 0];
            } else {
                WishlistItem::create(['user_id' => auth()->id(), 'product_id' => $product_id]);
                return ['status' => 1];
            }
        }
        abort(404);
    }

    public function getWishlist()
    {
        return WishlistItem::where('user_id', Auth::user()->id)->pluck('product_id');
    }

    public function latestWishlist()
    {
        $items = WishlistItem::with('product.activeDailyDeal')->where('user_id', Auth::user()->id)->get();
        $products = collect([]);
        foreach ($items as $item) {
            $products->push($item->product);
        }
        $products = $products->each(function ($item) {
            $item->append('finalPrice', 'rating', 'largeThumbnail', 'dailyDealPrice','maxQuantity');
        });
        return view('frontend.wishlist.show')->with('products',$products);
    }


}
