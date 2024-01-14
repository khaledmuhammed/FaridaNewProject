<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryWithoutMedia;
use App\Models\Coupon;
use App\Models\Manufacturer;
use App\Models\Order;
use App\Models\Product;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::paginate(20);

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $couponTypes = [
            'order'   => __('Per Order'),
            'product' => __('Per Product'),
        ];
        $couponCalc  = [
            'fixed'   => __('fixed'),
            'percent' => __('percent'),
        ];

        $couponableTypes =
            collect([
                ['key' => 'category', 'name' => __('Category')],
                ['key' => 'manufacturer', 'name' => __('Manufacturer')],
                ['key' => 'product', 'name' => __('Product')],
                ['key' => 'payment_method', 'name' => __('Payment Method')],
                ['key' => 'shipping', 'name' => __('The shipping')]
            ]);

        $categories     = CategoryWithoutMedia::all();
        $manufacturers  = Manufacturer::all();
        $paymentMethods = PaymentMethod::all();

        return view('admin.coupons.create', compact(['couponCalc', 'couponTypes', 'couponableTypes', 'categories',
            'manufacturers', 'paymentMethods']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title'       => 'required|string',
            'code'        => 'required|string|min:1|unique:coupons',
            'amount'      => 'required|min:0',
            'type'        => 'required|string',
            'calc'        => 'required|string',
            'minimum'     => 'required|min:0',
            'usage_limit' => 'required|min:0',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
        ])->validate();

        DB::transaction(function () use ($request) {
            $coupon = new Coupon($request->all());
            $coupon->save();

            switch ($request->couponable_type) {
                case 'product':
                    $products = $request->product_id;
                    break;
                case 'category':
                    $products = DB::table('category_product')->select('product_id')->whereIn('category_id', $request->category_id)->distinct()->pluck('product_id');
                    $coupon->categories()->sync($request->category_id);
                    break;
                case 'manufacturer':
                    $products = Product::whereIn('manufacturer_id', $request->manufacturer_id)->pluck('id');
                    $coupon->manufacturers()->sync($request->manufacturer_id);
                    break;
                case 'payment_method':
                    $coupon->paymentMethods()->sync($request->payment_method_id);
                    break;
                case 'shipping':
                    break;
                default:
                    $products = [];
            }

            if ($request->couponable_type != 'payment_method' && $request->couponable_type != 'shipping') {
                $coupon->products()->sync($products);
            }

        });


        return redirect()->action('Admin\CouponController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $couponTypes = [
            'order'   => __('Per Order'),
            'product' => __('Per Product'),
        ];
        $couponCalc  = [
            'fixed'   => __('fixed'),
            'percent' => __('percent'),
        ];

        $couponableTypes =
            collect([
                ['key' => 'category', 'name' => __('Category')],
                ['key' => 'manufacturer', 'name' => __('Manufacturer')],
                ['key' => 'product', 'name' => __('Product')],
                ['key' => 'payment_method', 'name' => __('Payment Method')],
                ['key' => 'shipping', 'name' => __('The shipping')]
            ]);

        $categories     = CategoryWithoutMedia::all();
        $manufacturers  = Manufacturer::all();
        $paymentMethods = PaymentMethod::all();

        $coupon = Coupon::with('categories:id,name', 'manufacturers:id,name', 'products:id,name')->find($id);

        return view('admin.coupons.edit', compact(['couponCalc', 'coupon', 'couponTypes', 'couponableTypes',
            'categories', 'manufacturers', 'paymentMethods']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title'       => 'required|string',
            'code'        => 'required|string|min:1|unique:coupons,code,' . $id,
            'amount'      => 'required|min:0',
            'calc'        => 'required|string',
            'type'        => 'required|string',
            'minimum'     => 'required|min:0',
            'usage_limit' => 'required|min:0',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
        ])->validate();

        DB::transaction(function () use ($request, $id) {
            $coupon = Coupon::find($id);
            $coupon->update($request->all());
            $coupon->save();

            switch ($request->couponable_type) {
                case 'product':
                    $products = $request->product_id;
                    $coupon->manufacturers()->sync([]);
                    $coupon->categories()->sync([]);
                    break;
                case 'category':
                    $products = DB::table('category_product')->select('product_id')->whereIn('category_id', $request->category_id)->distinct()->pluck('product_id');
                    $coupon->categories()->sync($request->category_id);
                    $coupon->manufacturers()->sync([]);
                    break;
                case 'manufacturer':
                    $products = Product::whereIn('manufacturer_id', $request->manufacturer_id)->pluck('id');
                    $coupon->manufacturers()->sync($request->manufacturer_id);
                    $coupon->categories()->sync([]);
                    break;
                case 'payment_method':
                    $coupon->paymentMethods()->sync($request->payment_method_id);
                    break;
                case 'shipping':
                    break;
                default:
                    $products = [];
            }

            if ($request->couponable_type != 'payment_method' && $request->couponable_type != 'shipping') {
                $coupon->products()->sync($products);
            }

        });
        return redirect()->action('Admin\CouponController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $coupon = Coupon::withCount('orders')->find($id);
        if ($coupon->orders_count === 0) {
            $coupon->delete();
            return response(['url' => 'coupons']);
        } else {
            return response(['error' => __('الكوبون مستخدم في :count طلب', ['count' => $coupon->orders_count])]);
        }
    }

    public static function applyCoupon(Order $order)
    {
        $coupon = $order->coupon;

        // in case of coupon apply on shipping
        if($coupon->couponable_type === 'shipping'){
            if($coupon->minimum > ($order->payment_price + $order->items_price) ) return;
            if($coupon->calc === 'fixed'){
                $new_shipping_price = $order->shipping_price - $coupon->amount;
                if($new_shipping_price < 0) $new_shipping_price = 0;
            }else{ /*coupon.calc is in percentage*/
                $new_shipping_price = $order->shipping_price - ($order->shipping_price * $coupon->amount / 100);
            }
            $order->shipping_price = $new_shipping_price;
            $order->total_price = $order->shipping_price + $order->payment_price + $order->items_price;
            $order->save();
            return;
        }

        if ($coupon->type === 'order') {
            if ($coupon->minimum <= $order->total_price) {
                if ($coupon->calc === 'fixed') {
                    $order->discount           = $coupon->amount;
                    $order->vat                = round((($order->items_price - $coupon->amount) / 105) * 5, 2);
                    $order->total_price        = $order->shipping_price + $order->payment_price + $order->items_price - $coupon->amount;
                    $order->save();
                } else {
                    $discount                  = ($order->items_price * $coupon->amount / 100);
                    $order->vat                = round((($order->items_price - $discount) / 105) * 5, 2);
                    $order->discount           = $discount;
                    $order->total_price        = $order->shipping_price + $order->payment_price + $order->items_price - $discount;
                    $order->save();
                }
            }
        } else {
            $orderProducts  = $order->orderItems()->where('orderable_type', Product::class)->get();
            $couponProducts = $coupon->products;
            $discount       = 0;
            foreach ($orderProducts as $product) {
                if ($couponProducts->contains('id', $product->orderable_id) && $coupon->minimum <= $product->count) {
                    if ($coupon->calc === 'percent') {
                        $product->discount = $product->unit_price * $product->count * ($coupon->amount / 100);
                        $product->save();
                    } else {
                        $product->discount = $product->count * $coupon->amount;
                        $product->save();
                    }
                    $discount += $product->discount;
                }
            }
            $vat                       = round((($order->items_price - $discount) / 105) * 5, 2);
            $order->discount           = $discount;
            $order->vat                = $vat;
            $order->total_price        = $order->shipping_price + $order->payment_price + $order->items_price - $discount;
            $order->save();
        }
    }

    // public static function applyCoupon(Order $order)
    // {
    //     $coupon = $order->coupon;
    //     if ($coupon->type === 'order') {
    //         if ($coupon->minimum <= $order->total_price) {
    //             if ($coupon->calc === 'fixed') {
    //                 $order->discount    = $coupon->amount;
    //                 $order->total_price -= $coupon->amount;
    //                 $order->save();
    //             } else {
    //                 $order->discount    = ($order->items_price + $order->vat) * $coupon->amount / 100;
    //                 $order->total_price -= ($order->items_price + $order->vat) * $coupon->amount / 100;
    //                 $order->save();
    //             }
    //         }
    //     } else {
    //         $orderProducts  = $order->orderItems()->where('orderable_type', Product::class)->get();
    //         $couponProducts = $coupon->products;
    //         $discount       = 0;
    //         foreach ($orderProducts as $product) {
    //             if ($couponProducts->contains('id', $product->orderable_id) && $coupon->minimum <= $product->count) {
    //                 if ($coupon->calc === 'percent') {
    //                     $product->discount = $product->unit_price * $product->count * ($coupon->amount / 100);
    //                     $product->save();
    //                 } else {
    //                     $product->discount = $product->count * $coupon->amount;
    //                     $product->save();
    //                 }
    //                 $discount += $product->discount;
    //             }
    //         }
    //         $order->discount    = $discount;
    //         $order->total_price -= $discount;
    //         $order->save();
    //     }
    // }
}
