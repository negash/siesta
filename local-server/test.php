<?php
require __DIR__ . '/../vendor/autoload.php';

use Icecave\Siesta\Endpoint\EndpointInspector;
use Icecave\Siesta\Endpoint\EndpointInterface;

class UserRepos implements EndpointInterface
{
    public function index($user)
    {
    }

    public function get($user, $name)
    {
    }

    public function post($user, $name, $description)
    {
    }

    public function put($user, $name, $description)
    {
    }

    public function delete($user, $name)
    {
    }
}


$endpoint = new UserRepos;

$inspector = new EndpointInspector;
$inspector->inspect($endpoint);


// 
// 
// $router->router('/users/:id?', new UsersEndpoint);
// 
// $router->router('/user/:user/repos/:name?', new UsersEndpoint);
