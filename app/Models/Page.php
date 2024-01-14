<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'title_ar',
        'content',
        'content_ar',
        'is_active',
    ];

    protected $appends = ['theTitle', 'theContent'];

    public function getTheTitleAttribute()
    {
        $title = $this->title;

        if (app()->getLocale() == 'ar' && $this->title_ar) {
            $title = $this->title_ar;
        }

        return $title;
    }

    public function getTheContentAttribute()
    {
        $content = $this->content;

        if (app()->getLocale() == 'ar' && $this->content_ar) {
            $content = $this->content_ar;
        }

        return $content;
    }
}
