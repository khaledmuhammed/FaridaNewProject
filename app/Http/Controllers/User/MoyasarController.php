<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Payment, Status, User, Order};
use GuzzleHttp\Client;
use App\Http\Controllers\User\OrderHistoryController;
use App\Notifications\{OrderNew, OrderNewAdmin};
use Validator;

class MoyasarController extends Controller
{
    public function payments_redirect(Request $request)
    {
        logger()->info('payments_redirect', [$request->all()]);
        $payment = Payment::where('payment_id', $request->id)->first();

        if (!empty($payment)) {
            $order_id = $payment->order_id;
        } else {
            $order_id = session()->get('order_id');
        }

        Payment::create([
            'order_id' => $order_id,
            'user_id' => auth()->check() ? auth()->user()->id : null,
            'payment_id' => $request->id,
            'details' => json_encode($request->all())
        ]);

        $order = Order::find($order_id);

        if ($request->status == 'paid') {

            // verify the amount & currency
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.moyasar.com/v1/payments/$request->id");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, config('services.moyasar.secret_api_key') . ':');

            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response); 
            if($response->currency == 'SAR' && $response->amount == $order->total * 100){
                OrderHistoryController::addOrderHistory('', $order_id, Status::$PREPARING);
                session()->flash('success', 'تمت عملية الشراء بنجاح');
            }else{
                OrderHistoryController::addOrderHistory('', $order_id, Status::$PAYMENT_FAILED);
                session()->flash('error', 'خطأ في المبلغ المدفوع، برجاء الاتصال بخدمة العملاء');
            }
        } else if ($request->status == 'failed') {
            OrderHistoryController::addOrderHistory('', $order_id, Status::$PAYMENT_FAILED);
            session()->flash('error', 'فشلت عملية الدفع، حاول مرة أخرى');
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

        return redirect('/orders/'.$order_id);
    }

    public function payments_save(Request $request)
    {
        logger()->info('payments_save', [$request->all()]);
        Validator::make($request->all(), [
            // 'order_id' => 'required',
            'id' => 'required',
        ])->validate();

        if (!empty($request->order_id)) {
            $order_id = $request->order_id;
        } else {
            $order_id = session()->get('order_id');
        }

        $payment = Payment::create([
            'order_id' => $request->order_id,
            'user_id' => auth()->check() ? auth()->user()->id : null,
            'payment_id' => $request->id,
            'details' => json_encode($request->all())
        ]);

        logger()->info('payments_save $payment', [$payment]);

        return response()->json('saved', 201);
    }
}
