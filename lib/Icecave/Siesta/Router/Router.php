<?php
namespace Icecave\Siesta\Router;

use Icecave\Collections\Map;
use Icecave\Siesta\TypeCheck\TypeCheck;
use InvalidArgumentException;

class Router implements RouterInterface
{
    /**
     * @param PatternCompiler|null $patternCompiler
     */
    public function __construct(PatternCompiler $patternCompiler = null)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        if (null === $patternCompiler) {
            $patternCompiler = new PatternCompiler;
        }

        $this->patternCompiler = $patternCompiler;
        $this->routes = new Map;
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
     *
     * @return RouteInterface
     */
    public function mount($pathPattern, $endpoint)
    {
        $this->typeCheck->mount(func_get_args());

        list($regexPattern, $routingParameters, $identityParameters) = $this->patternCompiler->compile($pathPattern);

        $route = new Route(
            $pathPattern,
            $regexPattern,
            $endpoint,
            $routingParameters,
            $identityParameters
        );

        $this->routes->set($route->identity(), $route);

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

        foreach ($this->routes as $identity => $route) {
            if ($route->pathPattern() === $pathPattern) {
                return $this->routes->remove($identity);
            }
        }

        return null;
    }

    private $typeCheck;
    private $patternCompiler;
    private $routes;
}
