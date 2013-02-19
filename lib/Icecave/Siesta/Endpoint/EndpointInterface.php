<?php
namespace Icecave\Siesta\Endpoint;

use Icecave\Siesta\Router\RouteMatch;
use Symfony\Component\HttpFoundation\Request;

/**
 * An end point produced an API response payload from an API request payload.
 */
interface EndpointInterface
{
    /**
     * @param Request    $request
     * @param RouteMatch $routeMatch
     * @param mixed      $payload
     *
     * @return mixed
     */
    public function process(Request $request, RouteMatch $routeMatch, $payload);
}
