<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class ProductAttributeController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'attribute_id' => 'required|exists:attributes,id',
            'text'         => 'required|string',
        ])->validate();

        Validator::make($request->all(), [
            'attribute_id' => Rule::unique('product_attributes')->where(function ($query) use ($request) {
                return $query->where('product_id', $request->product_id);
            })
        ])->validate();


        $attribute = new ProductAttribute();
        $attribute->fill($request->all());
        $attribute->save();

        $productAttributes = Product::find($request->product_id)->productAttributes()->with('attributeGroup')->get();
        return response(['attributes'         => $productAttributes,
                         'grouped_attributes' => $productAttributes->groupBy('attribute_group_id')]);
//        return redirect()->action('Admin\ProductController@edit', $request->product_id);
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $validator       = Validator::make($request->all(), [
            'text' => 'required|string',
        ])->validate();
        $attribute       = ProductAttribute::where('attribute_id', $request->attribute_id)
                                           ->where('product_id', $request->product_id)->first();
        $attribute->text = $request->text;
        $attribute->save();
        return response(['attribute' => $attribute]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy()
    {
        $attribute = ProductAttribute::where('attribute_id', request()->attribute_id)
                                     ->where('product_id', request()->product_id)->first();
        $attribute->delete();


        $productAttributes = Product::find(request()->product_id)
                                    ->productAttributes()
                                    ->with('attributeGroup')
                                    ->get();
        return response(['attributes'         => $productAttributes,
                         'grouped_attributes' => $productAttributes->groupBy('attribute_group_id')]);
    }
}
