<?php

namespace App\Domain\Images;

class PdfPreviewBuilder
{
    public static function genPdfThumbnail($source, $target, $size = 256, $page = 1): ?string
    {
        try {
            if (file_exists($source) && !is_dir($source)) {
                if ('application/pdf' != \mime_content_type($source)) {
                    return null;
                }

                $separator = '/';
                $target = dirname((string) $source).$separator.$target;
                $size = intval($size);
                $page = intval($page);

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

                $sizR = round($size * (min($imW, $imH) / max($imW, $imH)));

                $img->setImageColorspace(255);
                $img->setImageBackgroundColor('white');
                $img = $img->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);
                $img->setimageformat('jpeg');

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

                $img->writeimage($target);

                $img->clear();
                $img->destroy();

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
