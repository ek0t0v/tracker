<?php

namespace Deployer;

require 'phar://deployer.phar/recipe/symfony3.php';
require 'deployer/recipes.php';

inventory('deployer/hosts.yml');

set('application', 'symfony');
set('repository', '');
set('git_tty', true); 

add('shared_files', [
    '.env',
    'backend/.env',
]);
add('shared_dirs', []);
add('writable_dirs', []);

host('tracker.local')
    ->set('deploy_path', '~/{{application}}');    

task('build', function () {
    run('cd {{release_path}} && build');
});

after('deploy:failed', 'deploy:unlock');

before('deploy:symlink', 'database:migrate');