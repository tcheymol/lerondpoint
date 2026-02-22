<?php

namespace App\Twig;

use Twig\Attribute\AsTwigFilter;

class AutolinkExtension
{
    #[AsTwigFilter('autolink', isSafe: ['html'])]
    public function autolink(?string $text): string
    {
        if (null === $text || '' === $text) {
            return '';
        }

        $escaped = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        $pattern = '~(https?://[^\s<>"\']+)~i';
        $linked = preg_replace(
            $pattern,
            '<a href="$1" class="text-dark" target="_blank" rel="noopener noreferrer">$1</a>',
            $escaped
        );

        return nl2br($linked ?? $escaped);
    }
}
