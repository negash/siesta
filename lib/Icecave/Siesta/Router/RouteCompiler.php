<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\Endpoint\Parameter;
use Icecave\Siesta\TypeCheck\TypeCheck;

/**
 * Compiles path patterns into Route instances.
 */
class RouteCompiler
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
    }

    /**
     * @param string $pathPattern
     *
     * @return Route
     */
    public function compile($pathPattern)
    {
        $this->typeCheck->compile(func_get_args());

        // Match wildcards:
        //  - :name
        //  - :optionalName? (only at end of path)
        $atoms = preg_split(
            '/(:[a-z_]\w*|\/:[a-z_]\w*\?$)/i',
            rtrim($pathPattern, '/'),
            null,
            PREG_SPLIT_DELIM_CAPTURE
        );

        $regexPattern = '';
        $routingParameters = array();
        $identityParameters = array();

        foreach ($atoms as $index => $atom) {
            // Not a wildcard ...
            if ($index % 2 === 0) {
                $regexPattern .= preg_quote($atom, '|');
            // Optional named wildcard ...
            } elseif ('/' === $atom[0]) {
                $identityParameters[] = new Parameter(trim($atom, ':/?'), false);
                $regexPattern .= '(?:/([^/]+))?';
            // Required named wildcard ...
            } else {
                $routingParameters[] = new Parameter(trim($atom, ':/?'));
                $regexPattern .= '([^/]+)';
            }
        }

        return new Route(
            $pathPattern,
            '|^' . $regexPattern . '$|',
            $routingParameters,
            $identityParameters
        );
    }

    private $typeCheck;
}
