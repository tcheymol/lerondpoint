<?php

namespace App\Domain\Images;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Uid\Uuid;

readonly class UploadFilesHelper
{
    public function __construct(
        private ThumbnailGenerator $thumbnailGenerator,
        private RequestStack $requestStack,
        private string $publicDir,
    ) {
    }

    private function generateThumbnailInUploadDir(UploadedFile $file): ?string
    {
        try {
            $thumbnailPath = $this->thumbnailGenerator->buildThumbnail($file);
            $request = $this->requestStack->getCurrentRequest();
            if (!$thumbnailPath || !$request) {
                return null;
            }
            $randomizedFileName = sprintf('%s-%s', Uuid::v4(), $file->getClientOriginalName());

            new File($thumbnailPath)
                ->move(sprintf('%s/uploads', $this->publicDir), $randomizedFileName);

            return sprintf('%s/uploads/%s', $request->getSchemeAndHttpHost(), $randomizedFileName);
        } catch (\Exception) {
            return null;
        }
    }

    public function uploadThumbnailToUploadDir(FileBag $files): ?string
    {
        $file = $files->get('file');
        if (!$file instanceof UploadedFile) {
            return null;
        }

        $filePath = $this->generateThumbnailInUploadDir($file);

        if (!$filePath) {
            unlink($file->getPathname());

            return null;
        }

        return $filePath;
    }
}
