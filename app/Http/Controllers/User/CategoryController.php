<?php

namespace App\Http\Controllers\User;


use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::with('filters.options')->find($id);

        if (!$category) {
            return back();
        }
        if ($category && $category->is_active == 0) {
            return back();
        }

        $products = $category->products()->with('options','labels', 'media', 'activeDailyDeal', 'manufacturer', 'propertyValues')->where('availability',1)->orderBy('id', 'desc')->get();
        
        $products = $products->each(function ($item) {
            $item->append('finalPrice', 'rating', 'largeThumbnail', 'dailyDealPrice','maxQuantity');
        });

        return view('frontend.category.show')->withCategory($category)->withProducts($products)->withTitle($category->theName);
    }

    /**
     * Filter the products based on Filter Options
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function filter($id)
    {
        $filters = request()->filter_options;

        $products = Product::with('labels', 'media', 'activeDailyDeal', 'manufacturer')->ofCategory($id);

        foreach ($filters as $filter_id => $options) {
            //$key = filter id
            if (!empty($options))
                $products->filter($filter_id, $options);
        }

        $products->select('products.*')->distinct();
        $products = $products->get();
        $products = $products->each(function ($item) {
            $item->append('finalPrice', 'rating', 'largeThumbnail', 'dailyDealPrice','maxQuantity');
        });

        return $products;

    }

}
