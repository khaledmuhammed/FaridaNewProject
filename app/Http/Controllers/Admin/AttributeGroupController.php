<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeGroup;
use Illuminate\Http\Request;
use Validator;

class AttributeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Respons
     */
    public function index()
    {
        return view('admin.attribute-groups.index', [
            'attributeGroups' => AttributeGroup::paginate(15)]);
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
            'name' => 'required|unique:attribute_groups|max:255',
        ])->validate();

        $attributeGroup = new AttributeGroup();
        $attributeGroup->fill($request->all());
        $attributeGroup->sort = 0;
        $attributeGroup->save();

        return redirect()->action('Admin\AttributeGroupController@index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attributeGroup = AttributeGroup::with('attributes')->find($id);
        return view('admin.attribute-groups.edit', [
            'attributeGroup' => $attributeGroup,
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
            'name' => 'required|max:191|unique:attribute_groups,name,' . $id,
        ])->validate();

        $attributeGroup = AttributeGroup::find($id);
        $attributeGroup->fill($request->all());
        $attributeGroup->sort = 0;
        $attributeGroup->save();

        return response(['name' => $attributeGroup->name]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attributeGroup = AttributeGroup::find($id);
        $attributeGroup->delete();
        return response(['url' => 'attributeGroups']);

    }
}
