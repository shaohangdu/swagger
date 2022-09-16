<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
//set('application', 'manage_usr');

// Project repository
set('repository', 'git@github.com:shaohangdu/swagger.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts
// Stage server.
host('127.0.0.1')
    ->set('application', 'checkIN')
    ->set('env_file', '.env.staging')
    ->set('deploy_path', '~/{{application}}')
    ->set('http_user', 'www-data')
    ->user('apps')
    ->port(56888);
// Production server.
// host('140.110.122.29')
//     ->set('application', 'manage_usr')
//     ->set('env_file', '.env.production')
//     ->set('deploy_path', '~/{{application}}')
//     ->set('http_user', 'www-data')
//     ->user('apps')
//     ->port(22);


// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

// Setting my env files.

desc('Creating symlinks for my env files');
task('my:env', function () {
    $shared_path = "{{deploy_path}}/shared";
    $env_file_local = '.env';
    $env_file_production = get('env_file');

    // Remove local env file from release dir.
    run("if [ -f $(echo {{release_path}}/$env_file_local) ]; then rm -rf {{release_path}}/$env_file_local; fi");
    // Remove local env file from shared dir.
    run("if [ -f $(echo $shared_path/$env_file_local) ]; then rm -rf $shared_path/$env_file_local; fi");

    // Upload production env file to shared dir.
    if ( testLocally("[ -f $env_file_production ]") ) {
        upload($env_file_production, $shared_path);
    }

    // Symlink shared dir to release dir.
    if ( test("[ -f $shared_path/$env_file_production ]") && !test("[ -f {{release_path}}/$env_file_local ]") ) {
        run("{{bin/symlink}} $shared_path/$env_file_production {{release_path}}/$env_file_local");
    }
});

// task('update_mpdf', function () {
//     $shared_path = "{{deploy_path}}/current";

//     run("chmod 777 $shared_path/vendor/mpdf/mpdf/tmp");
// });

after('deploy:shared', 'my:env');
// after('deploy:symlink', 'update_mpdf');
