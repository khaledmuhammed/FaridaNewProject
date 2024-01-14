<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public static $ADMIN    = 1;
    public static $EMPLOYEE = 2;
    public static $CLIENT   = 3;

    protected $fillable = ['name', 'name_ar'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
