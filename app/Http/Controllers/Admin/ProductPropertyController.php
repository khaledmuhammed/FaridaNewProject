<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductsProperty;
use App\Models\ProductsPropertiesValue;
use App\Models\OrderItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;

class ProductPropertyController extends Controller
{
    /**
     * return a property value of as:{'id','name','name_en','type', 'values'} ,
     * where `values` is array of objects of: {'id','value','value_en','sort_order'}
     * 
     * @param int $id   if $id=0 return all properties , else return one property
     */
    public function get_properties($id = 0){
        $property_fields = ['id','name','name_en','type'];
        $value_fields = ['id','value','value_en','sort_order'];
        if($id){ // get one property by $id
            $property = ProductsProperty::find($id, $property_fields);
            $property->values = $property->values()->select($value_fields)->get();
            return $property;
        }else{ // get all properties
            $properties = ProductsProperty::all($property_fields);
            foreach ($properties as $property){
                $property->values = $property->values()->select($value_fields)->get();
            }
            return $properties;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.products-properties', ['properties' => $this->get_properties()]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $new_property = ProductsProperty::create([
                'name' => $request->name,
                'name_en' => $request->name_en,
                'type' => $request->type
            ]);
            $new_property->values()->createMany($request->values);
            DB::commit();
            return ['success' => true, 'new_property'=> $this->get_properties($new_property->id)];
        } catch (Exception $e){
            DB::rollback();
            return ['success'=>false, 'message'=>$e->getMessage()];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            $property = ProductsProperty::find($id);
            $property->name = $request->name;
            $property->name_en = $request->name_en;
            $property->type = $request->type;
            $property->save();
            foreach($request->values as $value){
                if(array_key_exists('id', $value)){ // updating one of product property values 
                    $existedValue = ProductsPropertiesValue::find($value['id']);
                    $existedValue->value = $value['value'];
                    $existedValue->value_en = $value['value_en'];
                    $existedValue->sort_order = $value['sort_order'];
                    $existedValue->save();
                }else{ // add new value to the product property values
                    $property->values()->create($value);
                }
            }
            DB::commit();
            return ['success' => true, 'updated_property' => $this->get_properties($id)];
        }catch(Exception $e){
            DB::rollback();
            return ['success'=> false, 'message'=>$e->getMessage()];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $property = ProductsProperty::find($id);
            $property->delete();
            return ['success'=> true, 'id' =>$id];
        }catch(Exception $e){
            return ['success'=>false, 'id' => $id,'message'=>$e->getMessage()];
        }
    }

    /**
     * deleting a ProductsPropertiesValue model
     * @param int $id  the id of ProductsPropertiesValue in the DB
     */
    public function delete_value($id){
        if(DB::table('product_property')->where('property_value_id', $id)->where('stock','>',0)->count()){
            return ['success'=>false, 'message'=> __('Can not be deleted, because it has related products')];
        }
        if(OrderItem::where('property_value_id',$id)->count()){
            return ['success'=>false, 'message'=> __('Can not be deleted, because it has related order')];
        }

        $value = ProductsPropertiesValue::find($id);
        $value->delete();
        return ['success' => true];
    }
}
