<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\StringCheckExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class StringCheckExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_email', [StringCheckExtensionRuntime::class, 'isEmail']),
            new TwigFunction('is_url', [StringCheckExtensionRuntime::class, 'isUrl']),
        ];
    }
}
