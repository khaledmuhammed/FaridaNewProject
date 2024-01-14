<?php

namespace App\Http\Controllers\User;

use App\Models\{Package, Category, Product};

class PackageController extends Controller
{
    public function getPackages($id)
    {
        $package = Package::with('intoPackages:id,name,original_price,price_after_discount,product_code')->find($id);

        $package->append('maxQuantity');
        $package = collect($package)->except(['quantity', 'searched', 'bought',
            'availability', 'availability_date', 'created_at', 'updated_at', 'deleted_at']);

        return $package;
    }

    public function index()
    {
        $packages = Package::with('products')->where('availability', 1)->get();

        if (count($packages) > 0) {
            $packages->each(function ($item, $key) {
                $item->append('maxQuantity');
                $item->products->each(function ($product, $key) {
                    $product->append('finalPrice', 'rating', 'largeThumbnail', 'dailyDealPrice','maxQuantity');
                });
            });
        }

        return view('frontend.packages.index', compact(['packages']));
    }

    public function show($id)
    {
        $package = Package::with('intoPackages')->find($id);

        if (!$package || $package->availability == 0) {
            return view('frontend.packages.index');
        }
        
        $package->append('maxQuantity');
        
        return view('frontend.packages.show', compact(['package']));
    }
}
