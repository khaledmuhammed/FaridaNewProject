<?php

namespace App\Services;

use Spatie\MediaLibrary\UrlGenerator\BaseUrlGenerator;

class MediaLibraryUrlGenerator extends BaseUrlGenerator
{
    /**
     * Get the url for the profile of a media item.
     *
     * @return string
     */
    public function getUrl(): string
    {
        if ($this->media->disk == 'gcs') // if file in the google cloud storage
            return config('app.mhd_cdn_url','') . '/'. config('filesystems.disks.gcs.path_prefix') .'/' . $this->getPathRelativeToRoot();
        return config('app.url') . '/storage/' . $this->getPathRelativeToRoot();
    }
}
