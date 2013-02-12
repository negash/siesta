<?php
namespace Icecave\Siesta\Router;

interface EndpointInterface
{
    /**
     * @param RouteMatch $match
     *
     * @return boolean
     */
    public function accepts(RouteMatch $match);
}
