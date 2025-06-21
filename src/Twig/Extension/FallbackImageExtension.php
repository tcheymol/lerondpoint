<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\FallbackImageExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FallbackImageExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('fallback_image', callable: [FallbackImageExtensionRuntime::class, 'showFallbackImage']),
        ];
    }
}
