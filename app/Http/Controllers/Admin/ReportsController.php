<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Coupon, Status};

class ReportsController extends Controller
{
    public function couponsIndex() 
    {
        $coupons = Coupon::withCount('orders')->paginate(20);

        return view('admin.reports.coupons.index', compact('coupons'));
    }

    public function couponsShow($id) 
    {
        $coupon = Coupon::with(['orders' => function ($query) {
            $query->whereHas('orderHistory', function ($k) {
                $k->where('status_id', '>', Status::$VALIDATING);
            });
        }])->find($id);

        $products = Coupon::selectRaw("
                            products.name as product_name,
                            COUNT(products.name) as usage_count,
                            SUM(orderables.unit_price - orderables.discount) as total
                            ")
                            ->join('orders', 'coupons.id', '=', 'orders.coupon_id')
                            ->join('orderables', 'orders.id', '=', 'orderables.order_id')
                            ->join('products', 'orderables.orderable_id', '=', 'products.id')
                            ->join('order_histories', function ($join) {
                                $join->on('orders.id', '=', 'order_histories.order_id')
                                ->where('order_histories.status_id', '>', Status::$VALIDATING);
                            })
                            ->where('coupons.id', $coupon->id)
                            ->groupBy('products.name')
                            ->get();

        return view('admin.reports.coupons.show', compact('coupon','products'));
    }
}
