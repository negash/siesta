<?php
namespace Icecave\Siesta\Router;

interface RouteInterface
{
    /**
     * @return integer
     */
    public function identity();
    
    /**
     * @return string
     */
    public function pathPattern();

    /**
     * @param string $path
     *
     * @return RouteMatch|null
     */
    public function match($path);
}
