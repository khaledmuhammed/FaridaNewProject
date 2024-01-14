<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductLabel;
use Illuminate\Http\Request;
use Validator;


class ProductLabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productLabels = ProductLabel::paginate(15);
        return view('admin.product-labels.index', compact('productLabels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product-labels.create');
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
            'name'  => 'required|string',
            'color' => 'required|string',
        ])->validate();

        $productLabel = new ProductLabel();
        $productLabel->fill($request->all());
        $productLabel->save();
        return redirect()->action('Admin\ProductLabelController@index');

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
        $productLabel = ProductLabel::find($id);
        return view('admin.product-labels.edit', compact('productLabel'));
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
        Validator::make($request->all(), [
            'name'  => 'required|string',
            'color' => 'required|string',
        ])->validate();

        $productLabel = ProductLabel::find($id);
        $productLabel->fill($request->all());
        $productLabel->save();
        return redirect()->action('Admin\ProductLabelController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productLabel = ProductLabel::find($id);
        $productLabel->delete();
        return response(['url' => 'product-labels']);
    }
}
