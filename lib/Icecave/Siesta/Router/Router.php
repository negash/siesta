<?php
namespace Icecave\Siesta\Router;

use Icecave\Collections\Map;
use Icecave\Siesta\Endpoint\EndpointInterface;
use Icecave\Siesta\TypeCheck\TypeCheck;
use Symfony\Component\HttpFoundation\Request;

class Router implements RouterInterface
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
        $this->routes = array();
    }

    /**
     * @param string            $pathPattern
     * @param EndpointInterface $endpoint
     */
    public function route($pathPattern, EndpointInterface $endpoint)
    {
        $this->typeCheck->route(func_get_args());

        list($regex, $names) = $this->compilePathPattern($pathPattern);

        $this->routes[] = array(
            $regex,
            $names,
            $endpoint
        );
    }

    /**
     * @param Request $request
     *
     * @return EndpointInterface|null
     */
    public function resolve(Request $request)
    {
        $this->typeCheck->resolve(func_get_args());

        $method  = $request->getMethod();
        $path    = urldecode($request->getPathInfo());
        $matches = array();

        foreach ($this->routes as $route) {
            list($regex, $names, $endpoint) = $route;
            if (preg_match($regex, $path, $matches)) {
                $parameters = new Map;
                foreach ($names as $index => $name) {
                    $parameters->set($name, $matches[$index + 1]);
                }

                $match = new RouteMatch($endpoint, $parameters);

                if ($endpoint->accepts($match)) {
                    return $match;
                }
            }
        }

        return null;
    }

    /**
     * @param string $pathPattern
     *
     * @return tuple<string, string> A 2-tuple containing the regex pattern and argument names.
     */
    public function compilePathPattern($pathPattern)
    {
        $this->typeCheck->compilePathPattern(func_get_args());

        // Match wildcards:
        //  - *
        //  - :name
        //  - :optionalName? (only at end of path)
        $atoms = preg_split(
            '/(\*|:[a-z_]\w*|\/:[a-z_]\w*\?$)/i',
            rtrim($pathPattern, '/'),
            null,
            PREG_SPLIT_DELIM_CAPTURE
        );

        $regex = '';
        $names = array();

        foreach ($atoms as $index => $atom) {
            // Not a wildcard ...
            if ($index % 2 === 0) {
                $regex .= preg_quote($atom, '|');
            // Positional wildcard ...
            } elseif ('*' === $atom) {
                $names[] = 'arg' . count($names);
                $regex .= '([^/]+)';
            // Optional named wildcard ...
            } elseif ('/' === $atom[0]) {
                $names[] = trim($atom, ':/?');
                $regex .= '(?:/([^/]+))?';
            // Required named wildcard ...
            } else {
                $names[] = trim($atom, ':/?');
                $regex .= '([^/]+)';
            }
        }

        return array('|^' . $regex . '$|', $names);
    }

    private $typeCheck;
    private $routes;
}
