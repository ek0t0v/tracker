<?php

namespace deployer;

require 'phar://deployer.phar/recipe/symfony4.php';

desc('Restart php-fpm');
task('fpm:restart', function () {
    run('sudo systemctl restart php7.1-fpm');
});

desc('Up docker containers');
task('deploy:docker:up', function () {
    run('docker-compose up -d --build');
});

desc('Down docker containers');
task('deploy:docker:down', function () {
    run('docker-compose down');
});

desc('Installing vendors');
task('deploy:vendors', function () {
    run('docker-compose run composer install');
    run('docker-compose run node npm install');
});

desc('Build frontend');
task('deploy:build:frontend', function () {
    run('docker-compose run --service-ports node npm run build');
});
