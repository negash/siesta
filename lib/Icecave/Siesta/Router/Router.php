<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\TypeCheck\TypeCheck;
use Icecave\Siesta\Endpoint\Inspector;

class Router
{
    /**
     * @param Inspector|null      $inspector
     * @param RouteCompiler|null  $routeCompiler
     * @param RouteValidator|null $routeValidator
     */
    public function __construct(
        Inspector $inspector = null,
        RouteCompiler $routeCompiler = null,
        RouteValidator $routeValidator = null
    ) {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        if (null === $inspector) {
            $inspector = new Inspector;
        }

        if (null === $routeCompiler) {
            $routeCompiler = new RouteCompiler;
        }

        $this->inspector = $inspector;
        $this->routeCompiler = $routeCompiler;
        $this->routes = new Set(
            null,
            function (Route $route) {
                return $route->identity();
            }
        );
    }

    /**
     * @param string  $path
     * @param object  $endpoint
     * @param boolean $replace
     */
    public function mount($path, $endpoint, $replace = false)
    {
        $this->typeCheck->mount(func_get_args());

        $signature = $this->inspector->inspect($endpoint);
        $route = $this->routeCompiler->compile($path);

        $this->routeValidator->validate($route, $signature);

        if (!$replace && $this->routes->contains($route)) {
            throw new InvalidArgumentException('There is already an endpoint mounted at "' . $path . '".');
        }

        $this->routes->add($route);
    }

    /**
     * @param string $path
     *
     * @return boolean
     */
    public function unmount($path)
    {
        $this->typeCheck->unmount(func_get_args());

        $route = $this->routeCompiler->compile($path);

        return $this->routes->remove($route);
    }

    private $typeCheck;
    private $inspector;
    private $routeCompiler;
    private $routeValidator;
    private $routes;
}
