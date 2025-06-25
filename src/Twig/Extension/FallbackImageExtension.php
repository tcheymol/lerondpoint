<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\FallbackImageExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FallbackImageExtension extends AbstractExtension
{
    #[\Override]
    public function getFunctions(): array
    {
        return [
            new TwigFunction('fallback_image', callable: [FallbackImageExtensionRuntime::class, 'showFallbackImage']),
        ];
    }
}
