<?php

namespace App\Domain\Images;

readonly class ImageManipulator
{
    /**
     * @throws \ImagickException
     */
    public function rotateImage(\Imagick $imagick, string $tempFilePath): void
    {
        $imagick->rotateImage(new \ImagickPixel('none'), 90);
        $imagick->writeImage($tempFilePath);
        $imagick->clear();
    }
}
