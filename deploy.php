<?php

namespace Deployer;

require 'recipe/symfony4.php';

set('application', 'ShareFilm Backend');
set('repository', 'git@github.com:valledesilicona/back.git');
set('use_relative_symlinks', false);
set('ssh_multiplexing', false);
set('writable_dirs', ['var/cache', 'var/log', 'var/sessions']);


host('134.209.29.140')
    ->stage('production')
    ->user('root')
    ->set('branch', 'master')
    ->set('deploy_path', '/var/www/ShareFilm');

after('deploy:failed', 'deploy:unlock');

