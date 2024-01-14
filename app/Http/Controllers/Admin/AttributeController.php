<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeGroup;
use Illuminate\Http\Request;
use Validator;

class AttributeController extends Controller
{
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
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:attributes|max:255',
        ])->validate();

        $attribute = new Attribute();
        $attribute->fill($request->all());
        $attribute->save();

        $attributes = $attribute->attributeGroup->attributes;

        return response(['attributes' => $attributes]);
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
        return view('admin.attributes.edit', [
            'attribute' => Attribute::find($id)]);
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
            'name' => 'required|max:255|unique:attributes,name,' . $id,
        ])->validate();

        $attribute = Attribute::find($id);
        $attribute->update($request->all());
        $attribute->save();

        $attributes = $attribute->attributeGroup->attributes;

        return response(['attributes' => $attributes]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute        = Attribute::find($id);
        $attributeGroupId = $attribute->attribute_group_id;
        $attribute->delete();

        $attributes = AttributeGroup::find($attributeGroupId)->attributes;
        return response(['attributes' => $attributes]);

    }
}
