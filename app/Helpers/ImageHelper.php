<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Upload an image, convert it to WebP format, and save to storage.
     *
     * @param UploadedFile $file
     * @param string $directory Directory inside storage/app/public/
     * @return string Path to the saved file (e.g. 'blogs/gallery/abc.webp')
     */
    public static function uploadAndConvertToWebp(UploadedFile $file, string $directory): string
    {
        $filename = Str::random(40) . '.webp';
        $path = $directory . '/' . $filename;
        
        $imageType = $file->getMimeType();
        $sourcePath = $file->getRealPath();
        
        $image = null;
        switch ($imageType) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = @imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = @imagecreatefrompng($sourcePath);
                if ($image !== false) {
                    // Preserve transparency
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
                break;
            case 'image/gif':
                $image = @imagecreatefromgif($sourcePath);
                break;
            case 'image/webp':
                // Already webp, just store it normally
                return $file->storeAs($directory, $filename, 'public');
            default:
                // Fallback for unsupported types, just store normally
                return $file->storeAs($directory, $file->hashName(), 'public');
        }
        
        if ($image !== false && $image !== null) {
            // Ensure the directory exists in storage
            Storage::disk('public')->makeDirectory($directory);
            
            // Save as webp
            $destination = Storage::disk('public')->path($path);
            imagewebp($image, $destination, 80);
            imagedestroy($image);
            
            return $path;
        }
        
        // Fallback if imagecreate fails
        return $file->storeAs($directory, $file->hashName(), 'public');
    }
}
