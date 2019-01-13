<?php

namespace deployer;

desc('Restart php-fpm');
task('fpm:restart', function () {
    run('sudo systemctl restart php7.1-fpm');
});

desc('Up docker containers');
task('deploy:docker:up', function () {
    run('cd {{release_path}} && docker-compose up -d --build');
});

desc('Down docker containers');
task('deploy:docker:down', function () {
    run('cd {{release_path}} && docker-compose down');
});

desc('Installing vendors'); // todo: После установки composer пытается внести изменения в .env, но не может, т.к. .env расшаренный, вместо файла ссылка, нельзя получить доступ изнутри контейнера.
task('deploy:vendors', function () {
    run('cd {{release_path}} && docker-compose run composer install --no-scripts');
    run('cd {{release_path}} && docker-compose run node npm install');
});

desc('Build frontend');
task('deploy:build:frontend', function () {
    run('cd {{release_path}} && docker-compose run --service-ports node npm run build');
});

desc('Migrate database');
task('database:migrate', function () {
    run('cd {{release_path}}/backend && php bin/console d:m:m --allow-no-migration');
});

desc('Remove node_modules');
task('deploy:remove_node_modules', function () {
    run('rm -Rf {{release_path}}/frontend/node_modules || true');
});

desc('Remove frontend dist');
task('deploy:remove_frontend_dist', function () {
    run('rm -Rf {{release_path}}/frontend/public/dist || true');
});
