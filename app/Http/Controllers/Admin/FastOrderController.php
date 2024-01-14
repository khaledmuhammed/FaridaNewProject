<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FastOrder;
use Illuminate\Http\Request;
use Validator;

class FastOrderController extends Controller
{
    public function index()
    {
        $fastOrders = FastOrder::orderBy('id', 'desc');

        if (request()->filled('status') && request()->status != 'all') {
            $fastOrders = $fastOrders->where('status', request()->status);
            session()->put('fastOrders.status', request()->status);
        } else {
            session()->forget('fastOrders.status');
        }

        if (\request()->has('name_mobile') OR session()->get('fastOrders.name_mobile')) {
            if (request()->name_mobile == '') {
                session()->forget('fastOrders.name_mobile');
            }
            $val = request()->name_mobile != '' ? request()->name_mobile : session()->get('fastOrders.name_mobile');
            if ($val) {
                $fastOrders = $fastOrders->where('name', 'like', '%'.$val.'%')
                                        ->orWhere('mobile', 'like', $val);

                session()->put('fastOrders.name_mobile', $val);
            }
        }

        if (\request()->has('from') OR \request()->has('to') OR session()->get('fastOrders.from') OR session()->get('fastOrders.to')) {
            if (request()->from == '') {
                session()->forget('fastOrders.from');
            }
            if (request()->to == '') {
                session()->forget('fastOrders.to');
            }
            $from = request()->from != '' ? request()->from : session()->get('fastOrders.from');
            $to = request()->to != '' ? request()->to : session()->get('fastOrders.to');
            if ($from && $to) {
                $fastOrders = $fastOrders->whereBetween('created_at', [$from, $to]);
                session()->put('fastOrders.from', $from);
                session()->put('fastOrders.to', $to);
            } else if ($from) {
                $fastOrders = $fastOrders->where('created_at', 'like', '%'.$from.'%');
                session()->put('fastOrders.from', $from);
            } else if ($to) {
                $fastOrders = $fastOrders->where('created_at', 'like', '%'.$to.'%');
                session()->put('fastOrders.to', $to);
            }
        }

        return view('admin.fast-orders.index', [
            'fastOrders' => $fastOrders->paginate(20)
        ]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(FastOrder $fastOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FastOrder $fastOrder)
    {
        return view('admin.fast-orders.edit', compact('fastOrder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FastOrder $fastOrder)
    {
        Validator::make($request->all(), [
            'status'   => 'in:completed,pended,canceled',
        ])->validate();

        $fastOrder->update($request->all());

        session()->flash('success', 'تم تحديث حالة الطلب بنجاح');
        return redirect()->action('Admin\FastOrderController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
