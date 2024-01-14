<?php

namespace App\Http\Controllers\User;


use App\Models\{Product, ProductOption};
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Auth;

class ProductController extends Controller
{
    public function show($product_id)
    {
        $product = Product::with('ratings.user',
            'options',
            'media',
            'activeDailyDeal',
            'manufacturer',
            'labels',
            'propertyValues.property',
            'packages.intoPackages.media')->find($product_id);
        $product->append('finalPrice', 'rating', 'largeThumbnail','maxQuantity', 'dailyDealPrice');
        $packages = $product->packages->each(function ($item){
            $item->append('maxQuantity');
        });
        $relatedProducts = $product->relatedProducts()->with('media', 'activeDailyDeal', 'labels')->get();
        $relatedProducts = $relatedProducts->each(function ($item) {
            $item->append('finalPrice', 'rating', 'largeThumbnail', 'dailyDealPrice');
        });
        if (auth()->check()) {
            $item = WishlistItem::where(['user_id' => auth()->id(), 'product_id' => $product_id])->first();
            if ($item) {
                $product->isWishlisted = true;
            }
        }
        return view("frontend.products.show", compact(['product', 'relatedProducts','packages']));
    }

    //Returns all products by their IDs
    //without some of their attributes
    //
    public function products(Request $request)
    {
        $products = Product::with('manufacturer', 'ratings', 'media', 'activeDailyDeal', 'propertyValues.property')->whereIn('id', $request->id)->get();

        $products = $products->each(function ($item) {
            $item->append('finalPrice', 'rating','maxQuantity');
        });

        $products = $products->map(function ($product) use($request) {
            if ($request->option_id) {
                $product->option = ProductOption::find($request->option_id)->first();
            }
            return collect($product->toArray())
                ->except(['quantity', 'original_price', 'price_after_discount', 'searched',
                    'bought', 'availability', 'availability_date', 'manufacturer_id', 'rating'])
                ->all();
        });


        return $products;
    }

    public function whenAvailable($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->whenAvailableUsers()->syncWithoutDetaching(Auth::id());
        }

        return response(['status' => 'added']);
    }

}
