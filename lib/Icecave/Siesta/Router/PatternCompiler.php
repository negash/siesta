<?php
namespace Icecave\Siesta\Router;

use Icecave\Siesta\TypeCheck\TypeCheck;

/**
 * Compiles path patterns into regex patterns.
 */
class PatternCompiler
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
                $identityParameters[] = trim($atom, ':/?');
                $regexPattern .= '(?:/([^/]+))?';
            // Required named wildcard ...
            } else {
                $routingParameters[] = trim($atom, ':/?');
                $regexPattern .= '([^/]+)';
            }
        }

        return array(
            '|^' . $regexPattern . '$|',
            $routingParameters,
            $identityParameters,
        );
    }

    private $typeCheck;
}
