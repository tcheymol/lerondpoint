<?php

namespace App\Helper;

use App\Twig\Runtime\StringCheckExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class StringCheckExtension extends AbstractExtension
{
    #[\Override]
    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_email', [StringCheckExtensionRuntime::class, 'isEmail']),
            new TwigFunction('is_url', [StringCheckExtensionRuntime::class, 'isUrl']),
        ];
    }
}
