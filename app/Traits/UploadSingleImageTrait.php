<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait UploadSingleImageTrait {

    public function processSingleImage($image, $folder = 'articlePic/', $disk = 'public', $width = 300, $height = 300)
    {
        if (isset($image)) {
            $filename = time() . '.' . 'webp';
            $path = public_path('upload/' . $folder . $filename);
            $save_url = 'upload/' . $folder . $filename;

            // Make sure the directory exists
            if (!file_exists(public_path('upload/' . $folder))) {
                mkdir(public_path('upload/' . $folder), 0777, true);
            }

            Image::make($image->getRealPath())->encode('webp', 100)->resize($width, $height)->save($path);

            return $save_url;
        }
        return null;
    }

    public function ckProcessSingleImage($image, $folder='articlePic/', $disk='public', $width = 300, $height = 300)
    {
        if(isset($image)){
            $filename = time() . '.' .'webp';
            Image::make($image->getRealPath())->encode('webp', 100)->resize($width, $height)->save(public_path($folder . $filename));
            return $filename;
        }
        return null;
    }

}
