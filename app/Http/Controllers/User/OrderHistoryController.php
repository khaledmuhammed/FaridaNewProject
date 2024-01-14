<?php

namespace App\Http\Controllers\User;

use App\Models\OrderHistory;
use Illuminate\Http\Request;
use App\Models\{Status, Order};
use App\Notifications\Statuses\{Preparing, Validating, Shipping, Delivered, Canceled, PaymentFailed};

class OrderHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store($request)
    {
        $orderHistory             = new OrderHistory();
        $orderHistory->notes      = $request->notes;
        $orderHistory->order_id   = $request->order_id;
        $orderHistory->status_id  = $request->status_id;
        $orderHistory->sent_email = $request->sent_email;
        $orderHistory->sent_sms   = $request->sent_sms;
        $orderHistory->save();

        return $orderHistory;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderHistory  $orderHistory
     * @return \Illuminate\Http\Response
     */
    public function show(OrderHistory $orderHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderHistory  $orderHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderHistory $orderHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderHistory  $orderHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderHistory $orderHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderHistory  $orderHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderHistory $orderHistory)
    {
        //
    }

    public static function addOrderHistory($notes,$order_id,$status_id,$sent_email = 0,$sent_sms = 0)
    {
        $request = new \stdClass();
        $request->notes = $notes;
        $request->order_id = $order_id;
        $request->status_id = $status_id;
        $request->sent_email = $sent_email;
        $request->sent_sms = $sent_sms;
        $orderHistory = self::store($request);

        $order = Order::find($order_id);
        try{ // ignore notification errors (due to invalide emails)

                if ($status_id == Status::$CANCELED) 
                {
                    $order->notify(new Canceled($order,$orderHistory));
                }

                if ($status_id == Status::$PAYMENT_FAILED) 
                {
                    $order->notify(new PaymentFailed($order,$orderHistory));
                }

                if ($status_id == Status::$VALIDATING) 
                {
                    $order->notify(new Validating($order,$orderHistory));
                }

                if ($status_id == Status::$PREPARING) 
                {
                    $order->notify(new Preparing($order,$orderHistory));
                }

                if ($status_id == Status::$SHIPPING) 
                {
                    $order->notify(new Shipping($order,$orderHistory));
                }

                if ($status_id == Status::$DELIVERED) 
                {
                    $order->notify(new Delivered($order,$orderHistory));
                }
        }catch(\Exception $e){}
    }
}
