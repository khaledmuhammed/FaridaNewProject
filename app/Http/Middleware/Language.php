<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Language
{
    protected $languages = ['en', 'ar'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('applocale')) {
            Session::put('applocale', 'ar');
        }

        app()->setLocale(Session::get('applocale'));

        return $next($request);
    }
}
