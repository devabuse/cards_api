<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

use Cards\Service;
use Cards\Validation;

$app->post('/api/card', function (Request $request) use ($app) {
    $validator = new Validation\CardValidation($app['validator'], json_decode($request->getContent(), true));
    $errors = $validator->getErrors();

    if(empty($errors) === true) {
        $serviceCardPost = new Service\ServiceCardPost($app['db'], $app['cache'], $request);

        return $app->json($serviceCardPost->execute());
    }

    return $app->json(['message' => 'Could not process entity. Have you provided the required variables?'], 422);
});

$app->get('/api/card/{cardHash}', function ($cardHash) use ($app) {
    $serviceCardGet = new Service\ServiceCardGet($app['db'], $app['cache'], $cardHash);
    $card = $serviceCardGet->execute();

    if($card !== false) {
        return $app->json($card);
    }

    return $app->json(['message' => 'This card could not be found'], 404);
});

$app->get('/login', function (Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', [
        'error' => !empty($app['security.last_error']) ? $app['security.last_error']($request) : '',
        'last_username' => $app['session']->get('_security.last_username'),
        'title' => 'Login',
    ]);
})->bind('login');

$app->get('/logout', function () use ($app) {
    $app['session']->clear();

    return $app->redirect($app['url_generator']->generate('login'));
})->bind('logout');

$app->get('/admin', function () use ($app) {
    return $app['twig']->render('dashboard.html.twig', [
        'cards' => $app['dashboard']->getData(),
        'title' => 'Dashboard',
        'count' => $app['dashboard']->getCount(),
    ]);
})->bind('admin');

$app->error(function (\Exception $e, $code) use ($app) {
    // Don't send generalised messages when debug mode is enabled
    if ($app['debug'] === true) {
        return;
    }

    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'An unknown error has occurred please try again later.';
    }

    return new Response($message, $code);
});
