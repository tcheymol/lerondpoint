<?php

namespace App\Twig\Runtime;

use App\Entity\Track;
use Twig\Extension\RuntimeExtensionInterface;

class FallbackImageExtensionRuntime implements RuntimeExtensionInterface
{
    public function showFallbackImage(Track $track): string
    {
        return match ($track->getKind()?->getName()) {
            'AUDIO' => 'images/fallback_audio.png',
            'TEXTE' => 'images/fallback_text.png',
            'VIDÉO' => 'images/fallback_video.png',
            default => 'images/fallback_image.png',
        };
    }
}
