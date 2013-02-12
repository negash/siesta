<?php
namespace Icecave\Siesta\Router;

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
     * @param string            $resource
     * @param EndpointInterface $endpoint
     */
    public function route($resource, EndpointInterface $endpoint)
    {
        $this->typeCheck->route(func_get_args());

        throw new \Exception('Not implemented.');
    }

    /**
     * @param Request $request
     *
     * @return EndpointInterface|null
     */
    public function resolve(Request $request)
    {
        $this->typeCheck->resolve(func_get_args());

        throw new \Exception('Not implemented.');
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
