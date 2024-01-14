<?php

namespace App\Http\Controllers\User;


use App\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('frontend.testimonials.index', compact('testimonials'));
    }
}
