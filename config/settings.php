<?php

// Cache
$app['cache.path'] = dirname(__DIR__) . '/resources/cache';

// Twig cache
$app['twig.options.cache'] = $app['cache.path'] . '/twig';

// Cache for services
$app['services.options.cache'] = $app['cache.path'] . '/services';

// Include a local settings.php for database credentials and other environment specific configurations
require_once __DIR__ . '/settings.local.php';