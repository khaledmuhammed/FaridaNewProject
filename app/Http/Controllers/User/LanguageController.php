<?php

namespace App\Http\Controllers\User;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    //
    public function switchLang()
    {
        $lang = session()->get('applocale') === 'ar' ? 'en' : 'ar';
        Session::put('applocale', $lang);

        return Redirect::back();
    }

}
