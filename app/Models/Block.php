<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Block extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $fillable = [
        'title',
        'description',
        'text_button',
        'link_button',
    ];
}
