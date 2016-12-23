<?php


// Enable for development only
// use Symfony\Component\Debug\Debug;

// ini_set('html_errors', 0);
// ini_set('display_errors', 1);
// error_reporting(-1);

$app['database'] = [
    'driver' => 'pdo_mysql',
    'dbuser' => '',
    'dbpass' => '',
    'dbname' => '',
    'dbhost' => '',
];

// This has to be a sha256 encoded string. The string provided below translates to the password: test
$app['admin_password'] = '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08';

// Enable for development only
// $app['debug'] = true;
// Debug::enable();