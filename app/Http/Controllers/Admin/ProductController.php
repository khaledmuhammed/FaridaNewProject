<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeGroup;
use App\Models\Category;
use App\Models\CategoryWithoutMedia;
use App\Models\Filter;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductLabel;
use App\Models\ProductOption;
use App\Models\ProductsProperty;
use Auth;
use Illuminate\Http\Request;
use Log;
use Validator, Notification;
use App\Notifications\whenAvailable;

class ProductController extends Controller
{
    public function index()
    {
        // dd(bcrypt('12345'));
        if( \request()->has('excel')){
           return (new \App\Exports\ProductsExport)->download('products.xlsx');
        }
        if (\request()->has('name')) {
            $products = Product::where('name', 'like', '%' . request()->name . '%')
                               ->orWhere('name_en', 'like', '%' . request()->name . '%')
                               ->orWhere('product_code', 'like', '%' . request()->name . '%');
            
            if (\request()->ajax()) {

                return response(['products' => $products->with('media')->get()]);
            }
            return view('admin.products.index', ['products' => $products->paginate(15), 'name' => \request()->name]);
        }
        // dd(Product::paginate(15));
        return view('admin.products.index', ['products' => Product::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create', [
            'categories'    => Category::all(),
            'manufacturers' => Manufacturer::all(),
            // 'properties' => ProductsProperty::all(['id','name','name_en','type']),
            'properties' => (new ProductPropertyController)->get_properties(),
        ]);
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
            'name'                 => 'required|string|min:2|max:191',
            'product_code'         => 'string|unique:products,product_code',
            'original_price'       => 'required|numeric|min:1',
            'price_after_discount' => 'nullable|numeric',
            'quantity'             => 'numeric',
            'availability_date'    => 'date',
            // 'manufacturer_id'      => 'required|exists:manufacturers,id',
            'category_id'          => 'required|exists:categories,id',
//            'product_package_id'           => 'nullable|exists:packages,id',
        ])->validate();

        $product = new Product();
        $product->fill($request->all());
        $product->availability = 0;
        $product->searched     = 0;
        $product->bought       = 0;
        $product->save();
        if($request->has('properties')){
            foreach ($request->properties as $property){
                $product->propertyValues()->attach($property['id'], ['stock' => $property['stock'] ]);
            }
        }
        foreach ($request->category_id as $category) {
            $product->categories()->attach($category);
        }
        return response(['route' => action('Admin\ProductController@edit', ['id' => $product->id])]);
    }


    //get ajax in Store Attribute page
    public function getGroupAttribute($group_id)
    {
        return response([
            'attributes' => Attribute::where('id', $group_id)
        ]);
    }

    //to get attributes for each attributeGroup ajax in show.blade
    public function myformAjax($id)
    {
        $attributeGroup = AttributeGroup::find($id);
        $attributes     = $attributeGroup->attributes()->pluck('name', 'id');
        return json_encode($attributes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories        = CategoryWithoutMedia::select('id', 'name')->get();
        $manufacturers     = Manufacturer::select('id', 'name')->get();
        $labels            = ProductLabel::select('id', 'name')->get();
        $product           = Product::with('relatedProducts', 'labels', 'filterOptions:id', 'media', 'productAttributes.attributeGroup')->find($id);
        $productCategories = $product->categories->pluck('id');
        $filters           = Filter::with('options')->forCategories($productCategories)->get();
        $productAttributes = $product->productAttributes;
        $productAttributes = $productAttributes->groupBy('attribute_group_id');
        $attributeGroup    = AttributeGroup::with('attributes')->get();

        if($properties = $product->get_properties()) $product->properties = $properties;

        return view('admin.products.edit', [
            'categories'        => $categories,
            'manufacturers'     => $manufacturers,
            'labels'            => $labels,
            'product'           => $product,
            'filters'           => $filters,
            'productAttributes' => $productAttributes,
            'attributeGroups'   => $attributeGroup,
            'properties' => (new ProductPropertyController)->get_properties(),
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
            'name'                 => 'required|string|min:2|max:191',
            'product_code'         => 'string|unique:products,product_code,' . $id,
            'original_price'       => 'required|numeric|min:1',
            'price_after_discount' => 'nullable|numeric',
            'quantity'             => 'numeric',
            'availability'         => 'boolean',
            'availability_date'    => 'date',
            'shipping_free'        => 'boolean',
            'payment_free'         => 'boolean',
            // 'manufacturer_id'      => 'required|exists:manufacturers,id',
            'category_id'          => 'required|exists:categories,id',
//            'product_package_id'           => 'nullable|exists:packages,id',
        ])->validate();

        $product = Product::find($id);
        $product->update($request->all());
        $product->propertyValues()->sync(collect($request->properties)->mapWithKeys( function($i){ return [$i['id'] => ['stock' => $i['stock']] ];} )->all());
        if($properties = $product->get_properties()) $product->properties = $properties;
        $product->categories()->sync($request->category_id);
        $product->labels()->sync($request->get('label_id', []));
        return response(['product' => $product->load('categories', 'labels')]);
//        return redirect()->action('Admin\ProductController@index');
    }


    /**
     * Update Product Description the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function updateProductDescription(Request $request, Product $product)
    {
        $product->description = $request->description;
        // $product->description_en = $request->description_en;
        $product->save();
        // return response(['description' => $product->description]);
        session()->flash('success', 'تم تعديل وصف المنتج بنجاح');
        return back();
    }

    /**
     * Update Product Filter the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function updateProductFilters(Request $request, Product $product)
    {
        $product->filterOptions()->sync($request->filter_options);
        $product->save();
        return response([]);
    }

    /**
     * Update Related Products the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function updateRelatedProducts(Request $request, Product $product)
    {
        $product->relatedProducts()->sync($request->products);
        $product->save();
        return response([]);
    }

    public function whenAvailable($id)
    {
        $product = Product::find($id);
        foreach($product->whenAvailableUsers as $user) {
            $user->notify(new WhenAvailable($product));
        }

        $product->whenAvailableUsers()->sync([]);

        session()->flash('success', 'تم إرسال الإشعار للعملاء بنجاح');
        return back();
    }

    public function addMediaFile(Request $request, $id)
    {
        Validator::make($request->all(), [
            'file' => 'required',
        ])->validate();

        $product = Product::findOrFail($id);
        $file    = $request->file('file');
        $mime    = $file->getMimeType();

        $media = false;
        if (strstr($mime, "video/")) {
            $media = $product->addMedia($file)->setFileName(md5_file($file) . rand(1, 999999) . "." . $file->extension())->toMediaCollection('videos');
        } else if (strstr($mime, "image/")) {
            $media = $product->addMedia($file)->setFileName(md5_file($file) . rand(1, 999999) . "." . $file->extension())->toMediaCollection('images');
        }
        if ($media) {
            return $media->id;
        }
        // else: log the error
        Log::error('Cannot Upload product file', [
            'user'      => Auth::user()->id,
            'error'     => $file->getErrorMessage(),
            'is valid'  => $file->isValid(),
            'file size' => $file->getClientSize(),
            'product'   => $product->id,
            'mime type' => $mime,
        ]);
    }

    public function addMediaBackground(Request $request, $id)
    {
        Validator::make($request->all(), [
            'background' => 'required',
        ])->validate();

        $product = Product::findOrFail($id);
        $background    = $request->file('background');
        $mime    = $background->getMimeType();

        $media = false;
        $media = $product->addMedia($background)->setFileName(md5_file($background) . rand(1, 999999) . "." . $background->extension())->toMediaCollection('background');
        
        if ($media) {
            return $media->id;
        }
        // else: log the error
        Log::error('Cannot Upload product background', [
            'user'      => Auth::user()->id,
            'error'     => $background->getErrorMessage(),
            'is valid'  => $background->isValid(),
            'background size' => $background->getClientSize(),
            'product'   => $product->id,
            'mime type' => $mime,
        ]);
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
        $product = Product::withCount('orderItems')->find($id);
        // Todo : Prevent product deleting if there was any related data
        $options = ProductOption::where('product_id', $product->id)->count();
        if ($product->order_items_count === 0 && $options === 0) {
            $product->propertyValues()->detach();
            $product->delete();
            session()->flash('success', 'تم حذف المنتج بنجاح');
        } else {
            session()->flash('error', 'لا يمكن حذف المنتج لوجود طلبات مرتبطة به');
        }
        return response(['url' => 'products']);
    }
}
