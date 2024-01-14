<?php

namespace App\Http\Controllers\User;

use App\Models\{Category, Settings};
use View;

class Controller extends \App\Http\Controllers\Controller
{
    public function __construct()
    {

        $superCategories = Category::with('categoriesActive')->where('super_category_id', null)->where('is_active', 1)->get();
        $settings = Settings::pluck('value', 'name');

        View::share('superCategories', $superCategories);
        View::share('settings', $settings);
    }
}
