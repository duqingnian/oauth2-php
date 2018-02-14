<?php

namespace OAuth\Server\Controllers;

use Silex\Application;

class Authorize
{
    public static function addRoutes($routing)
    {
        $routing->get('/authorize', array(new self(), 'authorize'))->bind('authorize');
        $routing->post('/authorize', array(new self(), 'authorizeFormSubmit'))->bind('authorize_post');
    }
    public function authorize(Application $app)
    {
        $server = $app['oauth_server'];
        $response = $app['oauth_response'];
        if (!$server->validateAuthorizeRequest($app['request'], $response)) {
            return $server->getResponse();
        }
        return $server->handleAuthorizeRequest($app['request'], $response, true);die();
    }
}
