<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\ActionIconExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ActionIconExtension extends AbstractExtension
{
    #[\Override]
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_actions_icon_paths', [ActionIconExtensionRuntime::class, 'getActionsIconsPaths']),
        ];
    }
}
