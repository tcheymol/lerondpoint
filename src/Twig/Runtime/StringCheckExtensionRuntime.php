<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class StringCheckExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
    }

    public function isEmail(string $value): bool
    {
        return false !== filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function isUrl(string $value): bool
    {
        return
            false !== filter_var($value, FILTER_VALIDATE_URL)
            || false !== filter_var($value, FILTER_VALIDATE_DOMAIN);
    }
}
