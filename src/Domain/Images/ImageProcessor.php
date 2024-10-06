<?php

namespace App\Domain\Images;

use Reconnect\S3Bundle\Service\FlysystemS3Client;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\UuidV4;

readonly class ImageProcessor
{
    public function __construct(private FlysystemS3Client $s3Adapter)
    {
    }

    public function uploadFile(File $file): ?string
    {
        try {
            return $this->s3Adapter->uploadFile($file, UuidV4::v4()->toString());
        } catch (\Exception) {
            return null;
        }
    }

    public function buildThumbnail(UploadedFile $file): ?string
    {
        try {
            $extension = $file->getMimeType();
        } catch (\Exception) {
            return null;
        }

        if ($extension === 'application/pdf') {
            return $this->buildPdfThumbnail($file);
        } elseif (getimagesize($file->getPathname())) {
            return $this->buildImageThumbnail($file->getRealPath());
        } else {
            return null;
        }
    }

    public function buildPdfThumbnail(File $file): string
    {
        $originalFilename = $file instanceof UploadedFile
            ? $file->getClientOriginalName()
            : $file->getFilename();
        $thumbnailName = 'thumbnail-'.$originalFilename;

        return PdfPreviewBuilder::genPdfThumbnail($file->getPathname(), $thumbnailName.'.png');
    }

    public function buildImageThumbnail(string $imagePath): ?string
    {
        try {
            $thumbnailPath = $imagePath.'-thumbnail.png';
            $imagick = new \Imagick(realpath($imagePath));
            $imagick->thumbnailImage(100, 0);
            $imagick->writeImage($thumbnailPath);

            return $thumbnailPath;
        } catch (\Exception) {
            return null;
        }
    }

    public function generateThumbnail(UploadedFile $file): ?string
    {
        $thumbnailPath = $this->buildThumbnail($file);
        $thumbnailKey = $this->uploadFile(new File($thumbnailPath));

        unlink($thumbnailPath);

        return $thumbnailKey;
    }
}