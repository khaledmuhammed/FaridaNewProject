<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Order, OrderHistory, Status};
use Illuminate\Http\Request;
use App\Http\Controllers\User\OrderHistoryController;
use App\Services\Aramex;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('shippingMethod', 'paymentMethod', 'user', 'orderItems','orderHistory')->latest();
        // $from = \request()->has('from') ? date(request()->from) : '';
        // $to   = \request()->has('to') ? date(request()->to) : '';

        if (\request()->has('name') OR session()->get('filter.name')) {
            if (request()->name == '') {
                session()->forget('filter.name');
            }
            $val = request()->name != '' ? request()->name : session()->get('filter.name');
            if ($val) {
                $orders = $orders->where('id', 'like', $val)
                        ->orWhere('username', 'like', '%'.$val.'%')
                        ->orWhere('mobile', 'like', $val);
                session()->put('filter.name', $val);
            }
        }

        if (\request()->has('from') OR \request()->has('to') OR session()->get('filter.from') OR session()->get('filter.to')) {
            if (request()->from == '') {
                session()->forget('filter.from');
            }
            if (request()->to == '') {
                session()->forget('filter.to');
            }
            $from = request()->from != '' ? request()->from : session()->get('filter.from');
            $to = request()->to != '' ? request()->to : session()->get('filter.to');
            if ($from && $to) {
                $orders = $orders->whereBetween('created_at', [$from, $to]);
                session()->put('filter.from', $from);
                session()->put('filter.to', $to);
            } else if ($from) {
                $orders = $orders->where('created_at', 'like', '%'.$from.'%');
                session()->put('filter.from', $from);
            } else if ($to) {
                $orders = $orders->where('created_at', 'like', '%'.$to.'%');
                session()->put('filter.to', $to);
            }
        }

        $orders = $orders->paginate(15);
        return view('admin.orders.index', [
            'orders' => $orders
        ]);
    }

    public function bankTransferOrders()
    {
        $orders = Order::latest()->get()->filter(function ($order) {
            if($order->orderHistory->last()['status_id'] == Status::$VALIDATING) 
                return $order;
        })->sortByDesc('id');

        return view('admin.orders.bank-transfers', [
            'orders' => $orders->values()->all()
        ]);
    }

    public function changeToPreparing($order_id)
    {
        logger()->error("changeToPreparing \n", ['order_id' => $order_id]);
        $order = Order::find($order_id);
        if ($order->orderHistory->last()['status_id'] == Status::$VALIDATING) {
            if ($order->bankTransfer) {
                // Add status preparing
                OrderHistoryController::addOrderHistory('', $order->id, Status::$PREPARING);
  
                // Send to Aramex
                try {
                    $aramex =  new Aramex;
                    $rate   = $aramex->createShipments($order);
                } catch (\Exception $e) {

                }
  
                session()->flash('success', 'تم تغيير حالة الطلب' . $order->id .' إلى : '.__('preparing'));
            } else {
                session()->flash('error', 'لا توجد حوالة بنكية لهذا الطلب');
            }
        }
        return back();
    }

    public function changeToCanceled($order_id)
    {
        logger()->info("changeToCanceled \n", ['order_id' => $order_id]);
        $order = Order::find($order_id);
        if ($order->currentStatus->id == Status::$VALIDATING) {
            if (!$order->bankTransfer) {
                // Add status canceled
                OrderHistoryController::addOrderHistory('', $order->id, Status::$CANCELED);
                
                session()->flash('success', 'تم تغيير حالة الطلب' . $order->id .' إلى : '.__('canceled'));
            } else {
                session()->flash('error', 'توجد حوالة بنكية لهذا الطلب');
            }
        }
        return back();
    }

    // public function sendToAramexManual($order_id)
    // {

    // }

    public function addOrderHistory(Request $request)
    {
        // logger()->error("addOrderHistory \n", ['request' => $request]);
        $order = Order::find($request->order_id);

        if (!$order) {
            session()->flash('error', __('Order not found'));
            return back();
        }

        // Add status
        OrderHistoryController::addOrderHistory('', $request->order_id, $request->status_id);

        session()->flash('success', __('Order status has been changed'));

        return back();
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
    public function show($id)
    {
        $order = Order::with('orderItems.orderable', 'orderItems.property_value.property','coupon')->find($id);
        $statuses = Status::pluck('name_ar', 'id');
        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.orders.edit')->withOrder(Order::with('orderItems.orderable', 'user')->find($id));
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
        $order            = Order::find($id);
        $order->status_id = $request->status_id;
        $order->save();

        return redirect()->action('Admin\OrderController@index');
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

    public function sendToAramex(Order $order)
    {
        try {
            $aramex =  new Aramex;
            $aramex->createShipments($order);
            session()->flash('success', __('Order has been sent to Aramex'));
        } catch (\Exception $e) {

        }

        return back();
    }

    public function aramexLabel($aramexID)
    {
        $aramex =  new Aramex;
        $pdfUrl = $aramex->printLabel($aramexID);

        return redirect($pdfUrl);
    }
    
    public function aramexTrackShipment($aramexID, $order_id)
    {
        $aramex =  new Aramex;
        $trackShipment = $aramex->trackShipment($aramexID);

        return view('admin.orders.trackShipment', compact('trackShipment', 'aramexID','order_id'));
    }
}
