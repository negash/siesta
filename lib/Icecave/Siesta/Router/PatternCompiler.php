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
     * @return tuple<string, string, array>
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

        $identity = '';
        $regexPattern = '';
        $identityParameters = array();

        foreach ($atoms as $index => $atom) {
            // Not a wildcard ...
            if ($index % 2 === 0) {
                $identity .= $atom;
                $regexPattern .= preg_quote($atom, '|');
                continue;
            }

            $atomPattern = '(?P<' . trim($atom, ':/?') . '>[^/]+)';
            $atomName = trim($atom, ':/?');

            // Optional named wildcard ...
            if ('/' === $atom[0]) {
                $identity .= '/?';
                $identityParameters[] = $atomName;
                $regexPattern .= '(?:/' . $atomPattern . ')?';
            // Required named wildcard ...
            } else {
                $identity .= '*';
                $regexPattern .= $atomPattern;
            }
        }

        return array(
            $identity,
            '|^' . $regexPattern . '$|',
            $identityParameters,
        );
    }

    private $typeCheck;
}
