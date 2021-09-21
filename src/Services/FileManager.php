<?php

namespace Namviet\Account\Services;

use Illuminate\Support\Arr;

class FileManager
{

    public $fullPath = false;

    /**
     * @return bool
     */
    public function getFullPath(): bool
    {
        return $this->fullPath;
    }

    /**
     * @param bool $fullPath
     */
    public function setFullPath(bool $fullPath): void
    {
        $this->fullPath = $fullPath;
    }

    public function resizePng($source, $destination, $size, $quality = null)
    {
// $source - Original image file
// $destination - Resized image file name
// $size - Single number for percentage resize
// Array of 2 numbers for fixed width + height
// $quality - Optional image quality. JPG & WEBP = 0 to 100, PNG = -1 to 9

        // (A) FILE CHECKS
        // Allowed image file extensions
        $ext = strtolower(pathinfo($source)['extension']);
        if (!in_array($ext, ["bmp", "gif", "jpg", "jpeg", "png", "webp"])) {
            throw new Exception('Invalid image file type');
        }

        // Source image not found!
        if (!file_exists($source)) {
            throw new Exception('Source image file not found');
        }

        // (B) IMAGE DIMENSIONS
        $dimensions = getimagesize($source);
        $width = $dimensions[0];
        $height = $dimensions[1];

        if (is_array($size)) {
            $new_width = $size[0];
            $new_height = $size[1];
        } else {
            $new_width = ceil(($size / 100) * $width);
            $new_height = ceil(($size / 100) * $height);
        }

        // (C) RESIZE
        // Respective PHP image functions
        $fnCreate = "imagecreatefrom" . ($ext === "jpg" ? "jpeg" : $ext);
        $fnOutput = "image" . ($ext === "jpg" ? "jpeg" : $ext);

        // Image objects
        $original = $fnCreate($source);
        $resized = imagecreatetruecolor($new_width, $new_height);

        // Transparent images only
        if ($ext === "png" || $ext === "gif") {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagefilledrectangle(
                $resized, 0, 0, $new_width, $new_height,
                imagecolorallocatealpha($resized, 255, 255, 255, 127)
            );
        }

        // Copy & resize
        imagecopyresampled(
            $resized, $original, 0, 0, 0, 0,
            $new_width, $new_height, $width, $height
        );

        // (D) OUTPUT & CLEAN UP
        if (is_numeric($quality)) {
            $fnOutput($resized, $destination, $quality);
        } else {
            $fnOutput($resized, $destination);
        }
        imagedestroy($original);
        imagedestroy($resized);
    }


    public function getDataFiles($object, $fieldName = 'logo', $multiple = true)
    {
        if (empty($object['file_uris'][$fieldName])) {
            return '';
        }
        if ($multiple === true) {
            $uris = array_values($object['file_uris'][$fieldName]);
            return array_map(function ($uri) {
                return $this->fullPath === true ? env('CDN_URL') . $uri : $uri;
            }, $uris);
        }
        return $this->fullPath === true ? env('CDN_URL') . Arr::first($object['file_uris'][$fieldName]) : Arr::first($object['file_uris'][$fieldName]);
    }
}
