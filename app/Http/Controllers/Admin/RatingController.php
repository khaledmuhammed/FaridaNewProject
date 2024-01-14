<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Validator;

class RatingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ratings.index', [
            'ratings' => Rating::with('Product', 'User')->paginate(15),
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.ratings.edit', [
            'rating'   => Rating::find($id),
            'products' => Product::pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'rating'     => 'required|numeric|max:191',
            'comment'    => 'string',
            'approved'   => 'boolean',
            'product_id' => 'numeric|exists:products,id',
        ])->validate();

        $rating = Rating::find($id);
        $rating->update($request->all());

        return redirect()->action('Admin\RatingController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $rating = Rating::find($id);
        $rating->delete();
        return response(['url' => 'ratings']);
    }
}
