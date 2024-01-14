<?php

namespace App\Http\Controllers\User;


use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Package;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ShippingMethod;
use App\Models\Status;
use App\Models\User;
use App\Models\Settings;
use App\Models\OrderReceiver;
use App\Models\District;
use App\Notifications\Channels\SmsChannel;
use App\Notifications\MobileConfirm;
use App\Notifications\{OrderNew, OrderNewAdmin};
use App\Rules\Mobile;
use Illuminate\Http\Request;
use Auth;
use Notification;
// use Request;
use Validator;
use Batch;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Log;
use DB;
class OrderController extends Controller
{
    public function show($id, $token = null)
    {
        $order = Order::find($id);
        if (auth()->check() && $order->user_id === auth()->id()
            || session()->get('order_id') === $order->id
            || $order && $token === hash('sha256', $order->id.$order->username)) {
            // if ($order->currentStatus->id == Status::$PAYMENT_FAILED || $order->currentStatus->id == Status::$PENDING) {
            //     $response          = \App\Http\Controllers\User\PaymentController::getCheckoutId($order);
            //     $order->checkoutId = $response['checkoutId'];
            // }
            // Bank Transfer Url
            $token = hash('sha256', $order->id.$order->username);
            $token = substr($token,0,10);
            $url   = route('bankTransfer.show',[$order->id,$token]);
            return view('frontend.orders.show', compact(['order', 'url']));
        }
        abort(419);
    }

    public function checkout()
    {
        $addresses = auth()->check() ? request()->user()->addresses->load('city','district') : collect([]);
        $title     = "إتمام عملية الشراء";

        return view('frontend.checkout.show', compact(['addresses', 'title']));
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateOrder()
    {
        Validator::make(request()->all(), [
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'payment_method_id'  => 'required|exists:payment_methods,id',
            'coupon.id'          => 'sometimes|exists:coupons,id',
        ])->validate();

        if (auth()->check()) {
            Validator::make(request()->all(), [
                'address_id' => 'required|exists:addresses,id',
            ])->validate();

        } else {
            Validator::make(request()->all(), [
                'guest_info.username'               => 'required|string',
                'guest_info.email'                  => 'nullable|email',
                'guest_info.mobile'                 => ['required', new Mobile],
                'guest_info.address_owner'          => 'required|string',
                // 'guest_info.address_details'     => 'string',
                'guest_info.city_id'                => 'required|exists:cities,id',
            ])->validate();
        }
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function confirmMobile()
    {
        $this->validateOrder();
        $mobile = null;
        $code   = rand(1000, 9999);
        if (auth()->check()) {
            $mobile = auth()->user()->mobile;
        } else {
            $mobile = request()->guest_info['mobile'];
        }

        session()->put('ver_code', $code);

        Notification::route(SmsChannel::class, $mobile)->notify(new MobileConfirm($code, $mobile));

        return response([]);
    }

    /**
     * @return Order
     * @throws \Illuminate\Validation\ValidationException
     */
    public function buy()
    {
        $country_id = 1; // 1 = Saudi Arabia
        if(!empty(request()->address_id)) {
            $address = Address::with('city')->find(request()->address_id);
            $country_id = $address->city->country_id;
        } else if (!empty(request()->guest_info['country_id'])) {
            $country_id = request()->guest_info['country_id'];
        }

        // Validator::make(request()->all(), [
        //     'ver_code' => 'required|in:' . session()->get('ver_code'),
        // ])->validate();
        

        $this->validateOrder();


        $shipping = ShippingMethod::find(request()->shipping_method_id);
        $payment  = PaymentMethod::find(request()->payment_method_id);

        $orderItems = collect([]);
        $itemsPrice = 0;
        $packagesQuantities = [];
        $productsQuantities = [];
        $productsQuantities_perPropertyValue = [];
        $shipping_free = false;
        $payment_free = false;
        $not_sold_alone = true;

        foreach (request()->cart['items'] as $item) {
            if ($item['type'] === 'product') {
                $product        = Product::with('propertyValues')->find($item['id']);
                // logger()->info('order.product', [$product]);
                $option         = null;
                if($item['property_value_id']){
                    $quantity =  $product->propertyValues->first( function($i) use($item){ return $i->id == $item['property_value_id']; })->pivot->stock;
                }else{
                    $quantity       = $product->quantity;
                    if (!empty($item['option_id'])) {
                        $option   = ProductOption::find($item['option_id']);
                        $quantity = $option->quantity;
                    }
                }

                if ($quantity < $item['quantity']) {
                    return response(['errors' => ['quantityError' => 'الكمية المطلوبة في ('.$product->name. ($option ? ' - '.$option->name : '') .') أكثر من المتوفرة!']], 422);
                }
                $orderItem                 = new OrderItem();
                $orderItem->count          = $item['quantity'];
                $orderItem->orderable_id   = $item['id'];
                $orderItem->unit_price     = $option ? $option->original_price : $product->final_price;
                $orderItem->orderable_type = Product::class;
                $orderItem->property_value_id = $item['property_value_id'];
                
                $itemsPrice += $orderItem->unit_price * $orderItem->count;
                $orderItems->push($orderItem);

                if ($option) {
                    array_push($optionsQuantities, ['id' => $option->id, 'quantity' => ($option->quantity - $item['quantity'])]);
                } else {
                    array_push($productsQuantities, ['id' => $product->id, 'quantity' => ($product->quantity - $item['quantity'])]);
                }
                //update property value stock
                if($item['property_value_id']){
                    DB::table('product_property')->where('product_id',$product->id)->where('property_value_id', $item['property_value_id'])->update(['stock' => ($quantity - $item['quantity'])]);
                }

                // Check if shipping is free
                // if ($product->shipping_free == 1 && $country_id == 1) {
                //     $shipping_free = true;
                // }

                // Check if the cart has products can sold alone
                if ($product->not_sold_alone == 0) {
                    $not_sold_alone = false;
                }
            } else {
                $package                   = Package::find($item['id']);
                if ($package->quantity < $item['quantity']) {
                    return response(['errors' => ['quantityError' => 'الكمية المطلوبة في ('.$package->name.') أكثر من المتوفرة!']], 422);
                }
                $orderItem                 = new OrderItem();
                $orderItem->count          = $item['quantity'];
                $orderItem->orderable_id   = $item['id'];
                $orderItem->unit_price     = $package->price;
                $orderItem->orderable_type = Package::class;
                // save products into package
                $intoPackage = collect([]);
                $delivery_date = Carbon::parse('next ' . $item['delivery_day']);
                $index = 0;
                foreach ($package->intoPackages as $product) {
                    if($index == 0){
                        $intoPackage->push([
                            "product_id"    => $product->id,
                            "quantity"      => $product->into_package_quantity,
                            "delivery_day"  => $item['delivery_day'],
                            "delivery_time" => $item['delivery_time'],
                            "delivery_date" => $delivery_date->toDateString(),
                        ]);
                        $index++;
                    }else{
                        $intoPackage->push([
                            "product_id"    => $product->id,
                            "quantity"      => $product->into_package_quantity,
                            "delivery_day"  => $item['delivery_day'],
                            "delivery_time" => $item['delivery_time'],
                            "delivery_date" => $delivery_date->addDays(7)->toDateString(),
                        ]);
                    }
                }
                $orderItem->into_package = $intoPackage;

                $itemsPrice += $orderItem->unit_price * $orderItem->count;
                $orderItems->push($orderItem);
                array_push($packagesQuantities, ['id' => $package->id, 'quantity' => ($package->quantity - $item['quantity'])]);

                // Check if shipping is free
                if ($package->shipping_free == 1) {
                    $shipping_free = true;
                }

                $not_sold_alone = false;
            }
        }

        if ($not_sold_alone) {
            return response(['errors' => ['quantityError' => 'لا يمكن شراء هذا المنتج لوحده ، يرجى اختيار منتج آخر معه']], 422);
        }

        $settings = Settings::pluck('value', 'name');

        // set shipping price
        if ($itemsPrice >= $settings['free_shipping_limit'] && $country_id == 1) {
            $shipping_price = 0.00;
        } else {
            // $shipping_price = request()->cart['prices']['shipping'];
            if ($shipping->id == 2) { // shipping 2 = Delivery in riyadh
                if(!empty(request()->receiver_info['receiver_name']) 
                && !empty(request()->receiver_info['receiver_mobile']) 
                && !empty(request()->receiver_info['receiver_city_id']))
                { // receiver
                    $shipping_price = District::find(request()->receiver_info['receiver_district_id'])->districtZoneShippingPrice;
                } else {
                    if (auth()->check()) { // user
                        $shipping_price = District::find($address->district_id)->districtZoneShippingPrice;
                    } else { // visitor
                        $shipping_price = District::find(request()->guest_info['district_id'])->districtZoneShippingPrice;                    
                    }
                }
            } else {
                $shipping_price = $shipping->price;
            }
        }
        
        if ($shipping_free) {
            $shipping_price = 0.00;
        }

        // set payment fee price
        // if ($payment_free) {
        //     $payment_price = 0.00;
        // } else {
            $payment_price = $payment->price;
        // }


        $order                     = new Order();
        $order->shipping_method    = $shipping->name;
        $order->shipping_method_id = $shipping->id;
        $order->shipping_price     = $shipping_price;
        $order->payment_price      = $payment_price;
        $order->items_price        = round($itemsPrice, 2); // With VAT
        $order->vat                = round(($itemsPrice / 105) * 5, 2);
        $order->total_price        = $shipping_price + $payment_price + $itemsPrice; // with VAT
        $order->payment_method_id  = $payment->id;
        $order->is_gift  = request()->is_gift;
        $order->notes  = request()->notes;
        
        $shippingDate              = strtotime(request()->shippingDate);
        $shippingTime              = strtotime(request()->shippingTime);
        $order->shipping_date       = date('Y-m-d', $shippingDate);
        $order->shipping_time       = date('H:i:s', $shippingTime);

        $order->last_status_id     = Status::$PENDING;

        // Address             
        if (auth()->check()) {
            $order->user_id         = request()->user()->id;
            $order->username        = request()->user()->name;
            $order->email           = request()->user()->email;
            $order->mobile          = request()->user()->mobile;
            $order->city_id         = $address->city_id;
            $order->address_id      = $address->id;
            $order->address_owner   = $address->name;
            $order->district_id     = $address->district_id;
            $order->address_details = $address->details;

        } else {

            $order->username        = request()->guest_info['username'];
            $order->address_owner   = request()->guest_info['address_owner'];
            $order->address_details = request()->guest_info['address_details'];
            $order->email           = request()->guest_info['email'];
            $order->mobile          = request()->guest_info['mobile'];
            $order->city_id         = request()->guest_info['city_id'];
            $order->district_id     = request()->guest_info['district_id'];
           
        }
        $order->save();
        $order->orderItems()->saveMany($orderItems);
        if(!empty(request()->receiver_info['receiver_name']) 
        && !empty(request()->receiver_info['receiver_mobile']) 
        && !empty(request()->receiver_info['receiver_city_id']))
        {
            $order_receiver = new OrderReceiver();
            $order_receiver->receiver_name    = request()->receiver_info['receiver_name'];
            $order_receiver->receiver_mobile  = request()->receiver_info['receiver_mobile'];
            $order_receiver->city_id          = request()->receiver_info['receiver_city_id'];
            $order_receiver->district_id      = request()->receiver_info['receiver_district_id'];
            $order->orderReceiver()->save($order_receiver);
        }
        

        // update quantities
        if (count($productsQuantities) > 0) {
            Batch::update('products', $productsQuantities, 'id');
        }

        if (count($packagesQuantities) > 0) {
            Batch::update('packages', $packagesQuantities, 'id');
        }

        if (request()->has('coupon.id')) {
            $coupon             = Coupon::find(request()->coupon['id']);
            $order->coupon_code = $coupon->code;
            $order->coupon_id   = $coupon->id;
            $order->save();
            \App\Http\Controllers\Admin\CouponController::applyCoupon($order);
        }


        session()->put('order_id', $order->id);
        try{ # igonre any notification exceptions
            if ($order->payment_method_id == 1) { //pay online
                // Add status pending
                \App\Http\Controllers\User\OrderHistoryController::addOrderHistory('', $order->id, Status::$PENDING);

                return response()->json(['order' => $order]);

                // $products_title = null;

                // foreach ($order->orderItems as $key => $item) {
                //     if ($key == 0) {
                //         $products_title = $item->orderable->name;
                //     } else {
                //         $products_title .= " || " . $item->orderable->name;
                //     }
                // }

                // $paytabs = collect([
                //     "secret_key"            => config('services.payments.paytabs.secret_key'),
                //     "merchant_id"           => config('services.payments.paytabs.merchant_id'),
                //     "url_redirect"          => route('paytabs.status'),
                //     "order_id"              => $order->id,
                //     "amount"                => $order->total_price,
                //     "title"                 => $order->username,
                //     "product_names"         => $products_title,
                //     "customer_phone_number" => $order->mobile,
                //     "customer_email_address"=> $order->email,
                //     "billing_full_address"  => $order->address_details,
                //     "billing_city"          => $order->city->name,
                //     "billing_state"         => $order->city->name,
                // ]);

                // // Add status pending
                // \App\Http\Controllers\User\OrderHistoryController::addOrderHistory('', $order->id, Status::$PENDING);

                // return $paytabs;
            }

            if ($order->payment_method_id == 2) {
                // Add status preparing
                \App\Http\Controllers\User\OrderHistoryController::addOrderHistory('', $order->id, Status::$PREPARING);
            }

            if ($order->payment_method_id == 3) {
                // Add status validating
                \App\Http\Controllers\User\OrderHistoryController::addOrderHistory('', $order->id, Status::$VALIDATING);
            }

            if ($order->payment_method_id == 4) { // Apple PAy
                // Add status pending
                \App\Http\Controllers\User\OrderHistoryController::addOrderHistory('', $order->id, Status::$PENDING);

                return response()->json(['order' => $order]);
            }

            // Send order to customer
            try {
                $order->notify(new OrderNew($order));
            } catch (\Exception $e) {

            }

            // Send order to admin
            try {
                User::find(1)->notify(new OrderNewAdmin($order));
            } catch (\Exception $e) {

            }

        
        }catch (\Exception $e){} # igonre any notification exceptions
        
        session()->flash('success', 'تمت عملية الشراء بنجاح');
        return $order;
    }

    public function latestOrders()
    {
        if (Auth::check()) {
            $user   = Auth::user();
            $orders = $user->orders()->latest()->take(4)->get();
            return $orders;
        } else {
            abort(402);
        }
    }

    public function showBill($id)
    { 
        $order = Order::with('address', 'city', 'shippingMethod', 'paymentMethod', 'orderItems.orderable.intoPackages')->find($id);

        return view('frontend.orders.success', compact(['order']));
    }

    public function pdfDownload($id)
    {
        $order = Order::with('address', 'city', 'shippingMethod', 'paymentMethod', 'orderItems.orderable.intoPackages')->find($id);

        // Send data to the view using loadView function of PDF facade
        $pdf = PDF::loadView('frontend.orders.pdf', compact('order'));

        // Finally, you can download the file using download function
        return $pdf->download('order-'.$order->id.'.pdf');
    }

    public function paytabsStatus()
    {
        logger()->info('paytabsStatusRequest', [\request()->all()]);

        if (request()->has('order_id')) {
            $order_id         = explode("-", request()->order_id)[0];
            $order            = Order::find($order_id);

            $transactionId = request()->get('transaction_id');

            //Validate payment Status from Paytabs.com
            $fields = [
                'merchant_email' => config('services.payments.paytabs.merchant_email'),
                'secret_key'     => config('services.payments.paytabs.secret_key'),
                'transaction_id' => $transactionId
            ];
            logger()->info('fields', [$fields]);

            $url = config('services.payments.paytabs.verify_payment');
            $res = collect(json_decode($this->runPost($url, $fields)));
            logger()->info('status', [$res]);

            $payment          = new Payment();
            $payment->details = $res;
            $payment->user_id = auth()->id();
            $payment->order_id = $order->id;
            $payment->save();

            if ($res->get('response_code') == '100') {
                // Add status preparing
                \App\Http\Controllers\User\OrderHistoryController::addOrderHistory('',$order->id,Status::$PREPARING);
                
                // send notification to user
                try {
                    $order->notify(new OrderNew($order));
                } catch (\Exception $e) {

                }

                try {
                    User::find(1)->notify(new OrderNewAdmin($order));
                } catch (\Exception $e) {
        
                }

                session()->flash('success', 'تمت عملية الشراء بنجاح');
                return redirect()->to('/orders/'.$order->id);
            } else {
                // Add status payment failed
                \App\Http\Controllers\User\OrderHistoryController::addOrderHistory('',$order->id,Status::$PAYMENT_FAILED);
                
                // send notification to user
                try {
                    $order->notify(new OrderNew($order));
                } catch (\Exception $e) {

                }

                try {
                    User::find(1)->notify(new OrderNewAdmin($order));
                } catch (\Exception $e) {
        
                }
                
                session()->flash('error', 'خطأ في عملية الدفع، الرجاء التأكد من المعلومات أو المحاولة في وقت لاحق');
                return redirect()->to('/orders/'.$order->id);
            }
        }
        return null;
    }

    function runPost($url, $fields)
    {
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        $ip = $_SERVER['REMOTE_ADDR'];

        $ipaddress = array(
            "REMOTE_ADDR"          => $ip,
            "HTTP_X_FORWARDED_FOR" => $ip
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ipaddress);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 1);

        $result = curl_exec($ch);
//        print_r($result);
        curl_close($ch);

        return $result;
    }
}
