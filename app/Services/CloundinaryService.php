<?php

namespace App\Services;

use Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloundinaryService
{
    public function upload($file, $folder)
    {
        $image = Cloudinary::upload($file->getRealPath(), [
            'folder' => env('CLOUDINARY_FOLDER') . $folder
        ]);
        $url = $image->getSecurePath();

        if (!$url) {
            throw new \Exception("Upload failed or returned null URL.");
        }
    
        return $url;
    }

    public function uploadFile($file, $folder)
    {
        $image = Cloudinary::upload($file->getRealPath(), [
            'folder' => env('CLOUDINARY_FOLDER') . $folder,
            'resource_type' => 'auto'
        ]);
        $url = $image->getSecurePath();

        return $url;
    }

    public function delete($url)
    {
        $publicId = $this->extractPublicIdFromUrl($url);
        Cloudinary::destroy($publicId);
        return true;
    }

    private function extractPublicIdFromUrl($url)
    {
        $path = parse_url($url, PHP_URL_PATH);

        $result = Str::after($path, env('CL_ID'));

        $result = Str::beforeLast($result, '.');
        return $result;
    }
}