<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait UploadMultipleImagesTrait {

    public function processMultipleImages($images, $folder = 'articlePic/', $disk = 'public', $width = 615, $height = 415) {
        $uploadedImages = [];
        if (isset($images) && is_array($images)) {
            foreach ($images as $key=>$image) {
                $filename = hexdec(uniqid()) . '.' . 'webp';
                Image::make($image->getRealPath())->encode('webp', 100)->resize($width, $height)->save(public_path('upload/'.$folder . $filename));
                $uploadedImages[$key] = 'upload/'.$folder . $filename;
                // dd($uploadedImages[$key]);
            }
        }
        return $uploadedImages;
    }
}
