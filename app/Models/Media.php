<?php

namespace App\Models;

class Media extends \Spatie\MediaLibrary\Media
{
    protected $appends = ['url', 'thumb_image', 'tiny_image'];

    /**
     * @return string
     * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
     */
    public function getUrlAttribute()
    {
        return $this->getUrl();
    }


    /**
     * @return string
     * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
     */
    public function getThumbImageAttribute()
    {
        if (array_search("thumb", $this->getMediaConversionNames()) !== false)
            return $this->getUrl('thumb');
        return "";
    }

    /**
     * @return string
     * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
     */
    public function getTinyImageAttribute()
    {
        if (array_search("tiny", $this->getMediaConversionNames()) !== false)
            return $this->getUrl('tiny');
        return "";
    }
}
