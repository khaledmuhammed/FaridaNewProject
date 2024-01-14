<?php

namespace App\Http\Controllers\User;


use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        $image = Image::all();
        return $image;

    }

    public function show(Image $id)
    {
        return $id;

    }

}
