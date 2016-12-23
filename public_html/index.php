<?php

ini_set("session.save_path", dirname(__DIR__) . "/resources/session");

require_once dirname(__DIR__) . '/vendor/autoload.php';

$app = new Silex\Application();

require_once dirname(__DIR__) . '/config/settings.php';
require_once dirname(__DIR__) . '/src/app.php';
require_once dirname(__DIR__) . '/src/controllers.php';

$app->run();
