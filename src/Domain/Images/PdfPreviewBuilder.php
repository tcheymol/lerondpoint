<?php

namespace App\Domain\Images;

class PdfPreviewBuilder
{
    public static function genPdfThumbnail(string $source, string $target, int $size = 256, int $page = 1): ?string
    {
        try {
            if (file_exists($source) && !is_dir($source)) {
                if ('application/pdf' != \mime_content_type($source)) {
                    return null;
                }
                $size = $size * 4;

                $separator = '/';
                $target = dirname($source).$separator.$target;

                --$page;
                if ($page < 0) {
                    $page = 0;
                }

                $img = new \Imagick($source."[$page]");
                $imH = $img->getImageHeight();
                $imW = $img->getImageWidth();
                if (0 == $imH) {
                    $imH = 1;
                }
                if (0 == $imW) {
                    $imW = 1;
                }

                $sizR = (int) round($size * (min($imW, $imH) / max($imW, $imH)));

                if ($imH == $imW) {
                    $img->thumbnailimage($size, $size);
                }
                if ($imH < $imW) {
                    $img->thumbnailimage($size, $sizR);
                }
                if ($imH > $imW) {
                    $img->thumbnailimage($sizR, $size);
                }

                if (!is_dir(dirname($target))) {
                    mkdir(dirname($target), 0777, true);
                }

                $img->setimageformat('jpeg');

                $img->writeimage($target);
                $img->clear();

                if (file_exists($target)) {
                    return $target;
                }
            }

            return null;
        } catch (\Exception) {
            return null;
        }
    }
}
