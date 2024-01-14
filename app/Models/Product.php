<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\{Model};
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;
use DB;

class Product extends Model implements HasMediaConversions
{
    use HasMediaTrait;

    protected $dates = [
        'created_at'
    ];

    protected $casts = [
        'price'                => 'decimal',
        'price_after_discount' => 'decimal',
        'points'               => 'integer',
    ];

    protected $fillable = [
        'name',
        'name_en',
        'product_code',
        'original_price',
        'price_after_discount',
        'quantity',
        'searched',
        'bought',
        'availability',
        'availability_date',
        'weight',
        'not_sold_alone',
        'manufacturer_id',
        'product_package_id',
        'description',
        'description_en',
        'sub_description',
        'shipping_free',
        'payment_free',
    ];

//    protected $appends = ['rating', 'finalPrice', 'thumbnail', 'largeThumbnail', 'dailyDealPrice', 'type'];
    protected $appends = ['thumbnail', 'type', 'theName'];


    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
//             ->width(368)
             ->height(500)
             ->sharpen(10);
        $this->addMediaConversion('tiny')
//             ->width(368)
             ->height(100)
             ->sharpen(10);
    }

    //###################  Relationships Start #################

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryWithoutMedia::class, 'category_product', 'product_id', 'category_id');
    }

    public function dailyDeals()
    {
        return $this->hasMany(DailyDeal::class);
    }

    public function activeDailyDeal()
    {
        return $this->hasMany('App\Models\DailyDeal')
                    ->whereDate('start_date', '<=', Carbon::now())
                    ->where('end_date', '>', Carbon::now());
    }

    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'orderable');
    }

    //not real relation; Used to overcome the issue of orderItems morph to relationship (product & package)
    public function intoPackages()
    {
        return $this->belongsToMany('App\Models\Package', 'into_package');
    }


    public function cartItems()
    {
        return $this->hasMany('App\Models\CartItem');
    }

    public function wishlistItems()
    {
        return $this->hasMany('App\Models\WishlistItem');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    
    // public function productAttributes()
    // {
    //     return $this->hasMany('App\Models\ProductAttribute');
    // }

    public function productAttributes()
    {
        return $this->belongsToMany('App\Models\Attribute', 'product_attributes')->withPivot('text');
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'related_products', 'first_product_id', 'second_product_id');
    }

    public function packages()
    {
        return $this->belongsToMany('App\Models\Package', 'into_package');
    }

    /*    public function package()
        {
            return $this->belongsTo(Package::class,'product_package_id');
        }*/

    public function labels()
    {
        return $this->belongsToMany(ProductLabel::class);
    }

    public function options()
    {
        return $this->hasMany('App\Models\ProductOption', 'product_id')->where('availability', 1);
    }

    public function filterOptions()
    {
        return $this->belongsToMany(FilterOption::class);
    }

    public function whenAvailableUsers()
    {
        return $this->belongsToMany(User::class, 'when_available');
    }

    public function propertyValues(){
        return $this->belongsToMany(ProductsPropertiesValue::class, 'product_property', 'product_id', 'property_value_id')->withPivot('stock');
    }

//###################  Relationships End ###################


//###################  Scopes Start ########################

    public function scopeFilter($query, $filter_id, Array $filter_options)
    {
        $filter_option_product_table = 'A' . $filter_id;
        $filter_options_table        = 'B' . $filter_id;
        return $query->join('filter_option_product AS ' . $filter_option_product_table, 'products.id', '=', $filter_option_product_table . '.product_id')
                     ->join('filter_options AS ' . $filter_options_table, function ($join) use ($filter_options, $filter_option_product_table, $filter_options_table) {
                         $join->on($filter_options_table . '.id', '=', $filter_option_product_table . '.filter_option_id')
                              ->whereIn($filter_options_table . '.id', $filter_options);
                     });
    }

    public function scopeOfCategory($query, $category_id)
    {
        return $query->whereHas('categories', function ($query) use ($category_id) {
            $query->where('category_product.category_id', $category_id);
        });
    }

    public function scopeByManufacturer($query, $manufacturer_id)
    {
        return $query->where('manufacturer_id', $manufacturer_id);
    }

    public function scopeAvailable($query)
    {
        return $query->where('availability', True);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', 0)
                     ->where('availability_date', '<', Carbon::today());
    }

    public function scopePreOrder($query)
    {
        return $query->where('quantity', 0)
                     ->where('availability_date', '>', Carbon::today());
    }

    public function scopeMostBought($query)
    {
        return $query->orderBy('bought');
    }

    public function scopeMostSearched($query)
    {
        return $query->orderBy('searched');
    }

    public function scopeOnDiscounts($query)
    {
        return $query->where('price_after_discount', '<', 'price')
                     ->orWhere('price_after_discount', '<>', '');
    }

//###################  Scopes End ########################

//###################  Attributes Start ########################
    public function getRatingAttribute()
    {
        return round($this->ratings->avg('rating'));
    }

    public function getFinalPriceAttribute()
    {
        if ($this->activeDailyDeal->count()) {
            return $this->activeDailyDeal->first()->price;
        } else {
            return $this->price_after_discount ? $this->price_after_discount : $this->original_price;
        }
    }

    public function getThumbnailAttribute()
    {
        $media = $this->getMedia('images');
        if (count($media) > 0)
            return $media[0]->getUrl('tiny');
        else
            return "";
    }

    public function getLargeThumbnailAttribute()
    {
        $media = $this->getMedia('images');
        if (count($media) > 0)
            return $media[0]->getUrl('thumb');
        else
            return "";
    }

    public function getDailyDealPriceAttribute()
    {
        $dailyDeal = $this->activeDailyDeal->first();
        return $dailyDeal ? $dailyDeal->price : null;
    }

    public function getTypeAttribute()
    {
        return 'product';
    }

    public function getMaxQuantityAttribute()
    {
        return $this->quantity;

        // $ordersCount = $this->orderItems()->whereHas('order', function ($q) {
        //     $q->whereHas('orderHistory', function ($k) {
        //         //TODO: Make sure this condition is right and enough
        //         $k->where('status_id', '>', Status::$CANCELED);
        //     });
        // })->sum('count');

        // return $this->quantity - $ordersCount;
    }

    public function getTheNameAttribute()
    {
        $name = $this->name;

        if (app()->getLocale() == 'en' && $this->name_en) {
            $name = $this->name_en;
        }

        return $name;
    }

//###################  Attributes End ########################

    public function get_properties(){
        if(DB::table('product_property')->where('product_id','=',$this->id)->count() == 0) return null;
        $qb = static::query()
            ->join('product_property', 'products.id', '=', 'product_property.product_id')
            ->join('products_properties_values', 'product_property.property_value_id', '=', 'products_properties_values.id')
            ->join('products_properties', 'products_properties_values.products_property_id', '=', 'products_properties.id')
            ->where('products.id','=', $this->id);
        $data = $qb->select(
            'products_properties.id AS property_id',
            'products_properties.name AS name',
            'products_properties.name_en AS name_en',
            'products_properties.type AS property_type',
            'products_properties_values.id AS value_id',
            'sort_order',
            'stock',
            'value',
            'value_en'
        )->get();
        $properties = [
            'id' => $data->first()->property_id,
            'name' => $data->first()->name,
            'name_en' => $data->first()->name_en,
            'type' => $data->first()->property_type
        ];

        foreach($data as $row){
            $properties['values'][] = [
                'id' => $row->value_id,
                'sort_order' => $row->sort_order,
                'stock' => $row->stock,
                'value' => $row->value,
                'value_en' => $row->value_en
            ];
        }

        $Values_with_stock_zero = ProductsProperty::with('values')->where('type',$properties['type'])->first()->values->filter(function($v) use($properties){
            return !in_array($v->id, collect($properties['values'])->pluck('id')->all());
        });
        
        foreach($Values_with_stock_zero as $v){
            $properties['values'][] = [
                'id' => $v['id'],
                'sort_order' => $v['sort_order'],
                'stock' => 0,
                'value' => $v['value'],
                'value_en' => $v['value_en']
            ];
        }

        uasort($properties['values'], function($a, $b){
            return $a['sort_order'] - $b['sort_order'];
        });
        $properties['values'] = array_values($properties['values']);
        return $properties;
    }
}
