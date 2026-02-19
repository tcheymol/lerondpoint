<?php

namespace App\Domain\Images;

use App\Entity\Attachment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\UuidV4;

readonly class ImageManipulator
{
    public function rotateImage(\Imagick $imagick, string $tempFilePath): void {
        $imagick->rotateImage(new \ImagickPixel('none'), 90);
        $imagick->writeImage($tempFilePath);
        $imagick->destroy();
    }
}
