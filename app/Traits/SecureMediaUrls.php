<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait SecureMediaUrls
{
    /**
     * Get a secure URL for a media item using our media controller
     *
     * @param Media|null $media
     * @return string|null
     */
    public function getSecureMediaUrl(?Media $media = null): ?string
    {
        if (!$media) {
            return null;
        }
        
        return route('media.show', ['id' => $media->id]);
    }
    
    /**
     * Get a secure URL for the first media in a collection
     *
     * @param string $collectionName
     * @return string|null
     */
    public function getSecureMediaUrlForCollection(string $collectionName): ?string
    {
        $media = $this->getFirstMedia($collectionName);
        return $this->getSecureMediaUrl($media);
    }
}
