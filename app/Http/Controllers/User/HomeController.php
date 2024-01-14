<?php

namespace App\Http\Controllers\User;

use App\Models\{Manufacturer, Testimonial};

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manufacturers = Manufacturer::all();
        $testimonials = Testimonial::featured()->take(10)->get();
        // dd($manufacturers);
        return view('frontend.home', compact(['manufacturers', 'testimonials']));
    }
}
