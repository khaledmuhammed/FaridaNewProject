<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Validator;


class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::paginate(15);
        return view('admin.payment-methods.index', compact('paymentMethods'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.payment-methods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name'      => 'required',
            'price'     => 'sometimes|numeric',
            'is_active' => 'required|boolean',
        ])->validate();

        $paymentMethod = new PaymentMethod();
        $paymentMethod->fill($request->all());
        $paymentMethod->save();

        return redirect()->action('Admin\PaymentMethodController@index');

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
        $paymentMethod = PaymentMethod::find($id);
        return view('admin.payment-methods.edit', compact('paymentMethod'));
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
            'name'      => 'required',
            'price'     => 'sometimes|numeric',
            'is_active' => 'required|boolean',
        ])->validate();

        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->fill($request->all());
        $paymentMethod->save();

        return redirect()->action('Admin\PaymentMethodController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->delete();
        return response(['url' => 'payment-methods']);

    }
}
