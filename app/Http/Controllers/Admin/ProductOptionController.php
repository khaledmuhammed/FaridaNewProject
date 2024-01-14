<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOption;
use Illuminate\Http\Request;
use Validator;

class ProductOptionController extends Controller
{

    private $validation = [
        'name'                 => 'required|string|min:2|max:191',
        'product_code'         => 'nullable|string|unique:products,product_code',
        'original_price'       => 'nullable|numeric',
        'price_after_discount' => 'nullable|numeric',
        'quantity'             => 'required|numeric|min:0',
        'availability'         => 'boolean',
        'availability_date'    => 'date',
        'type'                 => 'required|exists:option_types,name',
        'product_id'           => 'required|exists:products,id',
    ];

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
    public function store(Request $request, $product_id)
    {
        $data               = $request->all();
        $data['product_id'] = $product_id;
        $data['type']       = 'size';
        Validator::make($data, $this->validation)->validate();

        ProductOption::create($data);
        return redirect()->action('Admin\ProductController@edit', $product_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductOption $productOption
     * @return \Illuminate\Http\Response
     */
    public function show(ProductOption $productOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductOption $productOption
     * @return \Illuminate\Http\Response
     */
    public function edit($product_id, $option_id)
    {
        $productOption = ProductOption::findOrFail($option_id);
        return view('admin.product-options.edit', [
            'product' => $productOption->product,
            'option'  => $productOption,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ProductOption       $productOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id, $option_id)
    {
        $productOption      = ProductOption::findOrFail($option_id);
        $data               = $request->all();
        $data['product_id'] = $product_id;
        $data['type']       = 'size';
        Validator::make($data, $this->validation)->validate();

        $productOption->update($data);
        return redirect()->action('Admin\ProductController@edit', $productOption->product_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductOption $productOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductOption $productOption)
    {
        //
    }

    public function addImage(Request $request, $id)
    {
        $productOption = ProductOption::findOrFail($id);
        $media         = $productOption
            ->addMediaFromRequest("image")
            ->setFileName(rand(1, 999999))
            ->toMediaCollection('images');
        return $media->id;
    }
}
