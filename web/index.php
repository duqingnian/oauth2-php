<?php
require_once __DIR__.'/../vendor/autoload.php';
ini_set('display_errors', 0);
error_reporting(0);
$app = new Silex\Application();
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app['debug'] = false;
$app->mount('/api', new OAuth\Server\Server());
$request = OAuth2\HttpFoundationBridge\Request::createFromGlobals();
$app->run($request);