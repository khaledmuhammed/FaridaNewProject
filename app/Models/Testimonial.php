<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Testimonial extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $fillable = ['title', 'comment', 'username', 'featured'];

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}
