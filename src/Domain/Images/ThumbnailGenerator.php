<?php

namespace App\Domain\Images;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class ThumbnailGenerator
{
    public function buildThumbnail(UploadedFile $file, int $size = 255): ?string
    {
        try {
            $extension = $file->getMimeType();
        } catch (\Exception) {
            return null;
        }

        if ('application/pdf' === $extension) {
            return $this->buildPdfThumbnail($file, $size);
        } elseif (getimagesize($file->getPathname())) {
            return $this->buildImageThumbnail($file->getRealPath(), $size);
        } else {
            return null;
        }
    }

    private function buildPdfThumbnail(File $file, int $size = 256): ?string
    {
        $originalFilename = $file instanceof UploadedFile ? $file->getClientOriginalName() : $file->getFilename();
        $thumbnailPath = sprintf('thumbnail-%s.png', $originalFilename);

        return PdfPreviewBuilder::genPdfThumbnail($file->getPathname(), $thumbnailPath, $size);
    }

    private function buildImageThumbnail(string $imagePath, int $size = 255): ?string
    {
        try {
            $thumbnailPath = $imagePath.'-thumbnail.png';
            $imagick = new \Imagick(realpath($imagePath));
            $imagick->thumbnailImage($size, 0);
            $imagick->writeImage($thumbnailPath);

            return $thumbnailPath;
        } catch (\Exception) {
            return null;
        }
    }
}
