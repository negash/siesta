<?php
namespace Icecave\Siesta\Endpoint;

use Icecave\Siesta\Router\RouteMatch;

interface EndpointInterface
{
    /**
     * @param RouteMatch $match
     *
     * @return boolean
     */
    public function accepts(RouteMatch $match);
}
