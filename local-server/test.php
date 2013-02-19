<?php
require __DIR__ . '/../vendor/autoload.php';

use Icecave\Collections\Vector;
use Icecave\Siesta\Api;
use Icecave\Siesta\Router\Router;
use Icecave\Siesta\Router\PathRoute;
use Icecave\Siesta\Endpoint\Endpoint;
use Icecave\Siesta\Encoding\JsonEncoding;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EP
{
    public function index()
    {
        return array(
            array('id' => 10),
            array('id' => 20),
            array('id' => 30),
        );
    }

    public function get($id)
    {
        return array('id' => intval($id));
    }
}

class MyApi extends Api
{
    public function configure(Router $router, Vector $encodingOptions)
    {
        $encodingOptions->pushBack(new JsonEncoding);

        // $this->route('/things/:id?', new EP);

        $router->addRoute(
            new PathRoute('/things/:id?', '|^/things(/(?P<id>.+))?$|', new EndPoint(new EP, array('id')))
        );
    }
}

$request = Request::createFromGlobals();
$response = new Response;

$api = new MyApi;
$api->process($request, $response);
$response->send();
