<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyDeal;
use Illuminate\Http\Request;
use Validator;

class DailyDealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.daily-deals.index', [
            'dailyDeals' => DailyDeal::with('Product')->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.daily-deals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'price'      => 'required|numeric',
            'quantity'   => 'numeric',
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
            'product_id' => 'required|exists:products,id',
        ])->validate();

        $dailyDeal = new DailyDeal();
        $dailyDeal->fill($request->all());
        $dailyDeal->save();

        return redirect()->action('Admin\DailyDealController@index');
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
        return view('admin.daily-deals.edit', [
            'dailyDeal' => DailyDeal::with('product')->find($id),
        ]);
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
            'price'      => 'required|numeric',
            'quantity'   => 'numeric',
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
            'product_id' => 'required|exists:products,id',
        ])->validate();

        $dailyDeal = DailyDeal::find($id);
        $dailyDeal->update($request->all());
        $dailyDeal->save();

        return redirect()->action('Admin\DailyDealController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dailyDeal = DailyDeal::find($id);
        $dailyDeal->delete();
        return response(['url' => 'dailyDeals']);
    }
}
