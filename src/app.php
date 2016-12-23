<?php

use Silex\Provider;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Cards\Dashboard;

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\RememberMeServiceProvider());

$app->register(new Silex\Provider\HttpFragmentServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.options' => [
        'cache' => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
        'strict_variables' => true
    ],
    'twig.path' => [dirname(__DIR__) . '/templates']
]);

$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), [
    'translator.messages' => [],
]);

$app->register(new CHH\Silex\CacheServiceProvider, [
    'cache.options' => [
        'default' => [
            'driver' => 'filesystem',
            'directory' => $app['services.options.cache']
        ]
    ]
]);

$app->register(new Silex\Provider\SwiftmailerServiceProvider(), [
    'swiftmailer.use_spool' => false,
    'swiftmailer.options' => $app['swiftmailer_options'],
]);

if ($app['debug'] && isset($app['cache.path'])) {
    $app->register(new Silex\Provider\ServiceControllerServiceProvider());
    $app->register(new Silex\Provider\WebProfilerServiceProvider(), [
        'profiler.cache_dir' => $app['cache.path'] . '/profiler',
    ]);
}

$app->register(new Silex\Provider\DoctrineServiceProvider(), [
    'db.options' => [
        'driver' => $app['database']['driver'],
        'dbname' => $app['database']['dbname'],
        'user' => $app['database']['dbuser'],
        'password' => $app['database']['dbpass'],
        'host' => $app['database']['dbhost'],
    ],
]);

$app['security.encoder.digest'] = $app->share(function ($app) {
    return new MessageDigestPasswordEncoder('sha256', false, 1);
});

$app['security.firewalls'] = [
    'admin' => [
        'pattern' => '^/admin',
        'form' => [
            'login_path' => '/login',
            'check_path' => '/admin/login_check',
            'default_target_path' => 'admin',
        ],
        'remember_me' => [
            'always_remember_me' => true,
        ],
        'users' => [
            'admin' => [
                'ROLE_ADMIN',
                $app['admin_password']
            ],
        ],
    ],
];

$app['dashboard'] = $app->share(function ($app) {
    return new Dashboard\Dashboard($app['security.token_storage']->getToken(), $app['db']);
});


// do some security stuff for each request
$app->after(function (Request $request, Response $response) {
    $response->headers->set('X-Frame-Options', 'DENY');
    $response->headers->set('X-Content-Type-Options', 'nosniff');
});

return $app;
