<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Helper
{
    /**
     * Handle image upload and return the image path.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string
     */
    public static function uploadImage($file, $directory = 'public/images')
    {
        $path = $file->store($directory);
        return basename($path);
    }
}
