<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{

    protected $fillable = [
        'name',
        'sort',
    ];


//###################  Cast Start ########################
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'sort' => 'integer'
    ];
//###################  Cast End ########################


//###################  Relationships Start #################

    public function attributes()
    {
        return $this->hasMany('App\Models\Attribute');
    }

    public function filters()
    {
        return $this->hasMany('App\Models\Filter');
    }
//###################  Relationships End ###################


//###################  Scopes Start ########################
    public function scopeName($query, $id)
    {
        return $query->where('name', $id);
    }

//###################  Scopes End ########################

}
