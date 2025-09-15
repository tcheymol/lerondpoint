<?php

namespace App\Domain\Images;

use Psr\Log\LoggerInterface;
use Reconnect\S3Bundle\Service\PdfService;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class ThumbnailGenerator
{
    public function __construct(private PdfService $pdfService, private LoggerInterface $logger)
    {
    }

    public function buildThumbnail(UploadedFile $file, int $size = 255): ?string
    {
        $mime = 'image/jpeg';
        try {
            $mime = $file->getMimeType();
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Error while guessing mime type: %s', $e->getMessage()));
        }

        if ('application/pdf' === $mime) {
            return $this->buildPdfThumbnail($file, $size);
        } elseif ($mime && str_contains($mime, 'image/')) {
            return $this->buildImageThumbnail($file->getRealPath(), $size);
        } else {
            return null;
        }
    }

    private function buildPdfThumbnail(File $file, int $size = 256): ?string
    {
        $originalFilename = $file instanceof UploadedFile ? $file->getClientOriginalName() : $file->getFilename();
        $thumbnailPath = sprintf('thumbnail-%s.png', $originalFilename);

        return $this->pdfService->generatePdfThumbnail($file->getPathname(), $thumbnailPath, $size) ?: null;
    }

    private function buildImageThumbnail(string $imagePath, int $size = 255): ?string
    {
        try {
            $thumbnailPath = $imagePath.'-thumbnail.jpg';

            $imagick = new \Imagick(realpath($imagePath));
            $imagick->thumbnailImage($size, 0);
            $imagick->writeImage($thumbnailPath);
            $imagick->setImageFormat('jpeg');

            return $thumbnailPath;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Error while generating image thumbnail: %s', $e->getMessage()));

            return null;
        }
    }
}
