<?php

namespace Deployer;

require 'deployer/recipe.php';

inventory('deployer/hosts.yml');

set('repository', 'git@bitbucket.org:seniorcote/tracker.git');
set('git_tty', true);
set('keep_releases', 3);

add('shared_dirs', []);
add('writable_dirs', []);
add('shared_files', [
    'backend/.env',
]);

task('build', function () {
    run('cd {{release_path}} && build');
});

after('deploy:failed', 'deploy:unlock');
after('deploy:vendors', 'deploy:build:frontend');
after('deploy:build:frontend', 'deploy:docker:down');
after('deploy', 'fpm:restart');
after('rollback', 'fpm:restart');

before('deploy:symlink', 'database:migrate');
before('deploy:vendors', 'deploy:docker:up');
