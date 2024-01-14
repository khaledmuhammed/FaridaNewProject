<?php

namespace App\Http\Controllers\User;


use App\Models\Coupon;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public static function codeChecker()
    {
        $code = request()->code;
        if (strlen($code) === 0) {
            return response(['errors' => ['code' => ['أدخل رمز الكوبون']]], 422);
        }
        $coupon = Coupon::withCount(['orders' => function ($query) {
            $query->whereHas('orderHistory', function ($k) {
                //TODO: Make sure this condition is right and enough
                $k->where('status_id', '>', Status::$VALIDATING);
            });
        }])->where('code', $code)->first();
        if (!$coupon) {
            return response(['errors' => ['code' => ['رمز الكوبون غير موجود!']]], 422);
        }
        if ($coupon->start_date > now()) {
            return response(['errors' => ['code' => ['سيكون الكوبون فعالاً قريباً']]], 422);
        }
        if ($coupon->end_date < now()) {
            return response(['errors' => ['code' => ['الكوبون لم يعد صالحاً']]], 422);
        }
        if ($coupon->usage_limit !== 0 && $coupon->usage_limit <= $coupon->orders_count) {
            return response(['errors' => ['code' => ['الكوبون لم يعد صالحاً']]], 422);
        }
        

        if ($coupon->type === 'product') {
            //Fetch Cart Items
            $items = collect(request()->cart['items']);

            //get only "Products" from cart items
            $items = $items->map(function ($item) {
                if ($item['type'] === "product") {
                    return collect($item);
                };
            });

            //check if cart items are included in this coupon
            $couponProducts = DB::table('coupon_product')
                                ->where('coupon_id', $coupon->id)
                                ->whereIn('product_id', $items->pluck('id'))
                                ->pluck('product_id');

            if (count($couponProducts) === 0) {
                return response(['errors' => ['code' => ['الكوبون لا يشمل منتجات سلتك!']]], 422);
            }

            //add an additional attribute to coupon before sending it back
            $coupon->products = $couponProducts;
        }

        if ($coupon->couponable_type === 'payment_method') {
            if (request()->payment_method_id != $coupon->paymentMethods->first()->id) {
                return response(['errors' => ['code' => ['الكوبون لا يشمل طريقة الدفع المختارة!']]], 422);
            }
        }


        return response(['coupon' => $coupon]);


    }
}
