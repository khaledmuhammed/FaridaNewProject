<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Validator;

class ManufacturerController extends Controller
{
    public function index()
    {
        return view('admin.manufacturers.index', [
            'manufacturers' => Manufacturer::paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manufacturers.create', [
            'manufacturers' => Manufacturer::all()
        ]);
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
            'name' => 'required|unique:manufacturers|max:255',
        ])->validate();

        $manufacturer = new Manufacturer();
        $manufacturer->fill($request->all());
        $manufacturer->save();

        // Save the Manufacturer Logo
        if ($request->hasFile('logo')) {
            $this->addManufacturerImage($manufacturer, $request->file('logo'));
        }

        return redirect()->action('Admin\ManufacturerController@index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('admin.products.show')->withProduct($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.manufacturers.edit', [
            'manufacturer' => Manufacturer::find($id),
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
            'name' => 'required|unique:manufacturers,name,' . $id . '|max:255',
        ]);

        $manufacturer = Manufacturer::find($id);
        $manufacturer->update($request->all());
        $manufacturer->save();

        // Save the Manufacturer Logo
        if ($request->hasFile('logo')) {
            $this->addManufacturerImage($manufacturer, $request->file('logo'));
        }

        return redirect()->action('Admin\ManufacturerController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manufacturer  = Manufacturer::find($id);
        $productsCount = $manufacturer->products->count();
        if ($manufacturer->products->count() > 0)
            return back()->withErrors(['error' => ["There are $productsCount products from this manufacturer. In order to delete the manufacturer you have to delete all it's products"]]);
        $manufacturer->delete();
        return redirect()->action('Admin\ManufacturerController@index');
    }

    public function addManufacturerImage(Manufacturer $manufacturer,\Illuminate\Http\UploadedFile $image)
    {
        $manufacturer->clearMediaCollection('logo');
        $manufacturer->addMedia($image)->setFileName(md5_file($image) . rand(1, 999999) . "." . $image->extension())->toMediaCollection('logo');
    }
}
