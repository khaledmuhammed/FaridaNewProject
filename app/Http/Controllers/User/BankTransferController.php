<?php

namespace App\Http\Controllers\User;

use App\Models\{BankTransfer, Order};
use Illuminate\Http\Request;
use Validator;

class BankTransferController extends Controller
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
    public function store(Request $request)
    {
        $bankTransfer = new BankTransfer();
        $bankTransfer->fill($request->all());
        $bankTransfer->save();

        return response()->json(['status'=>'added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BankTransfer  $bankTransfer
     * @return \Illuminate\Http\Response
     */
    public function show($order_id,$token = null)
    {
        $order = Order::find($order_id);
        $string = $order_id.$order->username;
        $localToken = hash('sha256', $string);

        $msg = '';
        if ($token) {
            if ($token == $localToken) {
                return view('frontend.bank-transfer.show',compact('order', 'msg'));
            }
            if ($token == substr($localToken,0,10)) {
                return view('frontend.bank-transfer.show',compact('order', 'msg'));
            }
        } 

        $msg  = "غير مسموح لك الدخول على هذه الصفحة!";
        $msg .= "<br/>";
        $msg .= "إذا أردت تعبئة نموذج تأكيد الإيداع، يرجى الدخول من خلال الرابط المرسل على بريدك الإلكتروني.";

        return view('frontend.bank-transfer.show',compact('order', 'msg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankTransfer  $bankTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(BankTransfer $bankTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankTransfer  $bankTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankTransfer $bankTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankTransfer  $bankTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankTransfer $bankTransfer)
    {
        //
    }
}
