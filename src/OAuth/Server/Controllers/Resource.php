<?php

namespace OAuth\Server\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class Resource
{
    public static function addRoutes($routing)
    {
        $routing->get('/resource', array(new self(), 'resource'))->bind('access');
    }
    public function resource(Application $app)
    {
        $server = $app['oauth_server'];
        $response = $app['oauth_response'];
        if (!$server->verifyResourceRequest($app['request'], $response)) {
            return $server->getResponse();
        } else {
            $action = $app['request']->get('action');
            $api_response=array();
            switch ($action) {
                case 'debug':
                    $api_response=array('name'=>'aaa','age'=>33);
                    break;
                default:
                    break;
            }
            return new Response(json_encode($api_response));
        }
    }
}
