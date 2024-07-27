<?php
namespace Deployer;

require 'recipe/symfony.php';

// Config
set('repository', 'git@github.com:tcheymol/gjaune.git');
set('flush_cache_file_name', 'flush-cache.php');
set('flush_cache_file_path', '{{current_path}}/public/{{flush_cache_file_name}}');

add('shared_files', ['.env', 'config/secrets/prod/prod.decrypt.private.php']);
add('shared_dirs', [ 'var/log',  'var/sessions',  'vendor/',  'public/bundles/']);
add('writable_dirs', []);

// Hosts
host('111.111.11.11')
    ->set('branch', 'main')
    ->set('deploy_path', '~/www')
    ->set('http_user', 'www-data')
    ->set('homepage_url', '111.111.11.11')
;

// Tasks
task('deploy:reset-opcache', function () {
    run('sleep 5');
    run('echo "<?php opcache_reset(); ?>" >> {{flush_cache_file_path}}');
    run('sleep 5');
    run('wget "{{homepage_url}}/{{flush_cache_file_name}}" --spider --retry-connrefused -t 5');
    run('rm {{flush_cache_file_path}}');
});

// Hooks
before('deploy:info', 'deploy:test_connection');
before('deploy:symlink', 'deploy:reset-opcache');
after('deploy:reset-opcache', 'database:migrate');
after('deploy:failed', 'deploy:unlock');
