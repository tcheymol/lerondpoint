<?php
namespace Deployer;

require 'recipe/symfony.php';

// Config
set('repository', 'git@github.com:tcheymol/gjaune.git');
set('flush_cache_file_name', 'flush-cache.php');
set('flush_cache_file_path', '{{current_path}}/public/{{flush_cache_file_name}}');

add('shared_files', ['.env', 'var/data.db', 'config/secrets/prod/prod.decrypt.private.php']);
add('shared_dirs', [ 'var/log',  'var/sessions',  'vendor/',  'public/bundles/']);
add('writable_dirs', []);

// Hosts
host('gjaune')
    ->set('branch', 'main')
    ->set('deploy_path', '~/gjaune')
    ->set('http_user', 'www-data')
    ->set('homepage_url', 'gjaune')
;

task('deploy:set-prod-env', function () {
    run('export APP_ENV=prod');
});

task('deploy:compile-asset-map', function () {
    run('{{bin/console}} asset-map:compile');
});

// Hooks
before('deploy:vendors', 'deploy:set-prod-env');
before('deploy:symlink', 'database:migrate');
before('deploy:publish', 'deploy:compile-asset-map');
after('deploy:failed', 'deploy:unlock');
