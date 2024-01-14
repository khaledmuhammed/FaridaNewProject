<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionType extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    //protected $primaryKey = 'name'; // TODO: doesn't work. name always returns 0

    protected $appends = ['name_ar'];

    public function getNameArAttribute()
    {
        return __($this->name);
    }
}
