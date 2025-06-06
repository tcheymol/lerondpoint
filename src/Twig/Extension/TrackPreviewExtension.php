<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\TrackPreviewExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TrackPreviewExtension extends AbstractExtension
{
    #[\Override]
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_track_preview_url', [TrackPreviewExtensionRuntime::class, 'getTrackPreviewUrl']),
            new TwigFunction('get_preview_url', [TrackPreviewExtensionRuntime::class, 'getPreviewUrl']),
            new TwigFunction('get_previous_track_id', [TrackPreviewExtensionRuntime::class, 'getPreviousTrackId']),
            new TwigFunction('get_next_track_id', [TrackPreviewExtensionRuntime::class, 'getNextTrackId']),
        ];
    }
}
