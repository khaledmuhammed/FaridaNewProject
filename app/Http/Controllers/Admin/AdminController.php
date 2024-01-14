<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        /*
        * - عدد العملاء
        *- عدد الطلبات
        *- عدد المنتجات
        *- عدد طلبات اليوم
        *هذا في الصفحة الرئيسية في لوحة التحكم ، وتحتها آخر 10 طلبات
        */

        $users       = User::count();
        $orders      = Order::count();
        $todayOrders = Order::where('created_at', today())->count();
        $products    = Product::count();
        $lastOrders  = Order::withCount('orderItems')->with('user', 'orderHistory', 'paymentMethod')->latest()->take(20)->get();
        return view('admin.dashboard', compact(['users', 'orders', 'todayOrders', 'products', 'lastOrders']));
    }
}
