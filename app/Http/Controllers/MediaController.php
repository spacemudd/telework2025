<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Generate a temporary URL for accessing media files securely
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $media = Media::findOrFail($id);
        
        // Generate a temporary URL that expires in 5 minutes
        $temporaryUrl = Storage::disk($media->disk)->temporaryUrl(
            $media->getPath(),
            now()->addMinutes(5)
        );
        
        return redirect()->to($temporaryUrl);
    }
}
