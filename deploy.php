<?php

namespace Deployer;

require 'deployer/recipe.php';

inventory('deployer/hosts.yml');

set('repository', 'git@bitbucket.org:seniorcote/tracker.git');
set('git_tty', true);
set('keep_releases', 3);

add('shared_dirs', [
    'backend/var/log',
    'backend/var/sessions',
]);
add('writable_dirs', [
    'backend/var',
]);
add('shared_files', [
    'backend/.env', // todo: .env просто создается (пустой файл), должен копироваться из .env.dist.
]);

task('build', function () {
    run('cd {{release_path}} && build');
});

after('deploy:failed', 'deploy:unlock');
after('deploy:failed', 'deploy:remove_frontend_dist');
after('deploy:unlock', 'deploy:docker:down');
after('deploy:unlock', 'deploy:remove_node_modules');
after('deploy:vendors', 'deploy:build:frontend');
after('deploy', 'fpm:restart');
after('rollback', 'fpm:restart');

before('deploy:symlink', 'database:migrate');
before('deploy:vendors', 'deploy:docker:up');
before('deploy:build:frontend', 'deploy:remove_frontend_dist');
