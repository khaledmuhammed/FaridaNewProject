<?php

namespace App\Http\Controllers\User;

use App\Models\{FastOrder, Product, Package, User};
use App\Notifications\{FastOrderNewAdmin};
use Illuminate\Http\Request;
use Validator;

class FastOrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $products = Product::where('availability',1)->where('quantity', '>', 0)->get();

        $packages = Package::with('intoPackages')->where('availability', 1)->get();

        if (count($packages) > 0) {
            $packages->each(function ($item, $key) {
                $item->append('maxQuantity');
                $item->products->each(function ($product, $key) {
                    $product->append('finalPrice', 'rating', 'largeThumbnail', 'dailyDealPrice','maxQuantity');
                });
            });
        }

        return view('frontend.fast-orders.show', compact('products', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name'     => 'required|string',
            'mobile'   => 'required|string',
            'city_id'  => 'required|exists:cities,id',
            'district' => 'required|string',
            'details'  => 'required',
        ])->validate();

        $request['status'] = 'pended';

        $fastOrder = new FastOrder();
        $fastOrder->fill($request->all());
        $fastOrder->save();

        // Send order to admin
        try {
            User::find(1)->notify(new FastOrderNewAdmin($fastOrder));
        } catch (\Exception $e) {

        }

        return response()->json(['status' => 'success']);
    }
}
