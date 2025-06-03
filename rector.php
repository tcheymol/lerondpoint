<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Exception\Configuration\InvalidConfigurationException;

try {
    return RectorConfig::configure()
        ->withPaths([
            __DIR__ . '/assets',
            __DIR__ . '/config',
            __DIR__ . '/public',
            __DIR__ . '/src',
            __DIR__ . '/tests',
        ])
        ->withComposerBased(twig: true, doctrine: true, phpunit: true, symfony: true)
        ->withPhpSets(php84: true)
        ->withTypeCoverageLevel(0);
} catch (InvalidConfigurationException $e) {
    echo 'Rector configuration error: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}
