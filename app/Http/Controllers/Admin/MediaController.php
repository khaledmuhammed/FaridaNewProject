<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)

    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'path'       => 'required',
            'product_id' => 'required'
        ])->validate();

        //$files has all requests
        $files   = $request->file('path');
        $product = Product::find($request->product_id);

        $type = "null";
        //to take one by one
        foreach ($files as $file) {
            //getMimeType() this method get type of file
            $mime = $file->getMimeType();
            if (strstr($mime, "video/")) {
                //media code
                $product->addMedia($file)->setFileName(md5_file($file) . rand(1, 999999) . "." . $file->extension())->toMediaCollection('videos');
            } else if (strstr($mime, "image/")) {
                $product->addMedia($file)->setFileName(md5_file($file) . rand(1, 999999) . "." . $file->extension())->toMediaCollection('images');
                $type = "img";
            }
        }

        return $type;
        return redirect()->action('Admin\ProductController@show', $request->product_id);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Media::find($id)->delete();
            return response([]);

        } catch (\Exception $e) {
            return response([], 411);

        }

    }
}
