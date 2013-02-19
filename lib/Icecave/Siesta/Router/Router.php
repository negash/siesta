<?php
namespace Icecave\Siesta\Router;

use Icecave\Collections\Set;
use Icecave\Siesta\TypeCheck\TypeCheck;
use InvalidArgumentException;

class Router implements RouterInterface
{
    /**
     * @param RouteCompiler|null $routeCompiler
     */
    public function __construct(RouteCompiler $routeCompiler = null)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        if (null === $routeCompiler) {
            $routeCompiler = new RouteCompiler;
        }

        $this->routeCompiler = $routeCompiler;
        $this->routes = new Set(
            null,
            function (RouteInterface $route) {
                return $route->identity();
            }
        );
    }

    /**
     * @param string $path
     *
     * @return RouteMatch|null
     */
    public function resolve($path)
    {
        $this->typeCheck->resolve(func_get_args());

        foreach ($this->routes as $route) {
            if ($match = $route->match($path)) {
                return $match;
            }
        }

        return null;
    }

    /**
     * @param string  $pathPattern
     * @param object  $endpoint
     * @param boolean $allowReplace
     *
     * @return RouteInterface
     */
    public function mount($pathPattern, $endpoint, $allowReplace = false)
    {
        $this->typeCheck->mount(func_get_args());

        $route = $this->routeCompiler->compile($pathPattern, $endpoint);

        if (!$allowReplace && $this->routes->contains($route)) {
            throw new InvalidArgumentException('There is already an endpoint mounted at "' . $pathPattern . '".');
        }

        $this->routes->add($route);

        return $route;
    }

    /**
     * @param string $pathPattern
     *
     * @return RouteInterface|null
     */
    public function unmount($pathPattern)
    {
        $this->typeCheck->unmount(func_get_args());

        foreach ($this->routes as $route) {
            if ($route->pathPattern() === $pathPattern) {
                $this->routes->remove($route);

                return $route;
            }
        }

        return null;
    }

    private $typeCheck;
    private $routeCompiler;
    private $routes;
}
