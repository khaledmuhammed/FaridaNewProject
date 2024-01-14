<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeaturedProduct;
use App\Models\Category;
use Illuminate\Http\Request;
use Validator;

class FeaturedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $featuredProducts = FeaturedProduct::paginate(15);
        return view('admin.featured-products.index', compact('featuredProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.featured-products.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|string',
            'category' => 'Numeric|min:1'
        ])->validate();

        $featuredProducts = new  FeaturedProduct();
        $featuredProducts->fill($request->all());
        $featuredProducts->save();
        if($request->has('products')){ // if the featuredproducts type is products
            $featuredProducts->products()->attach($request->products);
        }else{ // if the type is category
            $featuredProducts->category_id = $request->category;
            $featuredProducts->save();
        }
        return redirect()->action('Admin\FeaturedProductController@index');
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

        $featuredProducts = FeaturedProduct::with('products')->find($id);
        $oldProducts      = $featuredProducts->products;
        $oldCategory = $featuredProducts->category;
        $categories = Category::all();
        return view('admin.featured-products.edit', compact(['featuredProducts', 'oldProducts','oldCategory', 'categories']));
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
            'title' => 'required|string',
            'category' => 'Numeric|min:1'
        ])->validate();

        $featuredProducts = FeaturedProduct::find($id);
        $featuredProducts->update($request->all());
        $featuredProducts->category_id = $request->category;
        $featuredProducts->save();
        if($request->has('products')){
            $featuredProducts->products()->sync($request->products);
        }else{
            $featuredProducts->products()->detach();
        }

        return redirect()->action('Admin\FeaturedProductController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $featuredProducts = FeaturedProduct::find($id);
        $featuredProducts->delete();
        return response(['url' => 'featured-products']);

    }


    public function getPositionableFeaturedProducts($id)
    {
        $featuredProduct = FeaturedProduct::find($id);
        if($featuredProduct->category_id){
            $featuredProduct->load('category.products.options','category.products.labels', 'category.products.manufacturer', 'category.products.activeDailyDeal', 'category.products.media', 'category.products.propertyValues');
           $products = $featuredProduct->category->products->where('availability',1)->take(-15)->values();
        }else{
            $featuredProduct->load('products.options','products.labels', 'products.manufacturer', 'products.activeDailyDeal', 'products.media', 'products.propertyValues');
            $products = $featuredProduct->products->where('availability',1)->values();   
        }
        $products = $products->each(function ($item) {
            $item->append('finalPrice', 'rating', 'largeThumbnail', 'dailyDealPrice','maxQuantity');
        });
        return response(['featured_products' => $featuredProduct, 'products' => $products]);
    }
}
