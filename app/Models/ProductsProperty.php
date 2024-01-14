<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsProperty extends Model
{
    protected $fillable = ['name', 'name_en', 'type'];
    
    public function values(){
        return $this->hasMany(ProductsPropertiesValue::class);
    }

    public function delete(){
        foreach( $this->values->pluck('id')->all() as $id){
            if(\DB::table('product_property')->where('property_value_id', $id)->count()){
                throw new \Exception(__('Can not be deleted, because it has related products'));
            }
            if(OrderItem::where('property_value_id',$id)->count()){
                return ['success'=>false, 'message'=> __('Can not be deleted, because it has related order')];
            }
        }
        \DB::beginTransaction();
        $this->values()->delete();
        $result = parent::delete();
        \DB::commit();
        return $result;
    }
}
