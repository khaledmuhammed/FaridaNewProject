<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Banner extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $fillable = [
        'title',
        'size',
    ];

    public function positions()
    {
        return $this->morphToMany(Position::class, 'positionable', 'positionables', 'position_id', 'positionable_id')->withPivot('sort');

    }
}
