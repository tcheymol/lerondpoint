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
            new TwigFunction('preview_track', [TrackPreviewExtensionRuntime::class, 'computePreviewUrl']),
        ];
    }
}
