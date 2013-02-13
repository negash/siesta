<?php
namespace Icecave\Siesta;

use Icecave\Siesta\TypeCheck\TypeCheck;

class Router
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
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
}
