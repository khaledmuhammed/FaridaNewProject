<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.packages.index', [
            'packages' => Package::paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.packages.create');
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
            'name'              => 'required|string|min:2|max:191',
            'price'             => 'required|numeric|min:1',
            'quantity'          => 'numeric',
            'availability'      => 'boolean',
            'availability_date' => 'date',

        ])->validate();

        $package = new Package();
        $package->fill($request->all());
        $package->searched = 0;
        $package->bought   = 0;
        $package->save();

        //Product assigning
        foreach ($request->products as $product) {
            $productDecode = json_decode($product);
            $aProduct = Product::find($productDecode->product_id);
            $package->intoPackages()->save($aProduct, ['into_package_quantity' => $productDecode->into_package_quantity]);
        }

        if ($request->hasFile('image')) {
            $this->addImage($package, $request->file('image'));
        }

        return redirect()->action('Admin\PackageController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $package = Package::find($id);
        //find all products per package
        $products = Package::find($id)->intoPackages()->where('package_id', $id)->get();

        //get price for each product
        foreach ($products as $product) {
            $productsPriceArr[] = $product->original_price;
        }

        //get Total price of all praducts
        $priceAll = array_sum($productsPriceArr);

        return view('admin.packages.show', [
            'package'  => $package,
            'priceAll' => $priceAll,
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
        $package          = Package::find($id);
        $products         = Product::select('id', 'name', 'original_price', 'product_code')->get();
        $selectedProducts = Package::find($id)->intoPackages()->where('package_id', $id)->get();

        return view('admin.packages.edit', [
            'package'          => $package,
            'products'         => $products,
            'selectedProducts' => $selectedProducts,
        ]);
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
            'name'              => 'required|string|min:2|max:191',
            'price'             => 'required|numeric|min:1',
            'quantity'          => 'numeric',
            'availability'      => 'boolean',
            'availability_date' => 'date',

        ])->validate();

        $package = Package::find($id);
        $package->update($request->all());
        $package->searched = 0;
        $package->bought   = 0;
        $package->save();

        //Product assigning
        $package->intoPackages()->sync([]);
        foreach ($request->products as $product) {
            $productDecode = json_decode($product);
            $aProduct = Product::find($productDecode->product_id);
            $package->intoPackages()->save($aProduct, ['into_package_quantity' => $productDecode->into_package_quantity]);
        }

        if ($request->hasFile('image')) {
            $this->addImage($package, $request->file('image'));
        }

        return redirect()->action('Admin\PackageController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::find($id);
        $package->delete();
        return response(['url' => 'packages']);
    }

    public function addImage(Package $package,\Illuminate\Http\UploadedFile $image)
    {
        $package->clearMediaCollection('image');
        $package->addMedia($image)->setFileName(md5_file($image) . rand(1, 999999) . "." . $image->extension())->toMediaCollection('image');
    }
}
