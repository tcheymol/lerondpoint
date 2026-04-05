<?php

namespace App\Domain\Images;

readonly class ImageManipulator
{
    public function rotateImage(\Imagick $imagick, string $tempFilePath): void
    {
        $imagick->rotateImage(new \ImagickPixel('none'), 90);
        $imagick->writeImage($tempFilePath);
        $imagick->destroy();
    }
}
