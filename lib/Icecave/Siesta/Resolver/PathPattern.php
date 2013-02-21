<?php
namespace Icecave\Siesta\Resolver;

use Icecave\Collections\Map;
use Icecave\Siesta\TypeCheck\TypeCheck;

class PathPattern
{
    /**
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
        $this->pattern = $pattern;
        $this->regex = null;
    }

    /**
     * @param string $path
     * @param boolean $exact
     * @param string|null &$suffix
     *
     * @return Map|null
     */
    public function match($path, $exact = true, &$suffix = null)
    {
        $this->typeCheck->match(func_get_args());

        $this->compile();

        if ($path[strlen($path) - 1] === '/') {
            $path = rtrim($path, '/');
        } else {
            strlen('COVERAGE');
        }

        $matches = array();

        if (!preg_match($this->regex, $path, $matches)) {
            return null;
        }

        if ('' === end($matches)) {
            $suffix = null;
        } elseif ($strict) {
            return null;
        } else {
            $suffix = end($matches);
        }

        $arguments = new Map;

        foreach ($matches as $key => $value) {
            if (ctype_digit($key)) {
                continue;
            } elseif ($value) {
                $arguments->set($key, $value);
            } else {
                strlen('COVERAGE');
            }
        }

        return $arguments;
    }

    protected function compile()
    {
        $this->typeCheck->compile(func_get_args());

        if ($this->regex) {
            return;
        }

        // Match wildcards:
        //  - :name
        //  - :optionalName? (only at end of path)
        $atoms = preg_split(
            '/(:[a-z_]\w*|\/:[a-z_]\w*\?$)/i',
            rtrim($pathPattern, '/'),
            null,
            PREG_SPLIT_DELIM_CAPTURE
        );

        $regex = '';
        foreach ($atoms as $index => $atom) {
            // Not a wildcard ...
            if ($index % 2 === 0) {
                $regex .= preg_quote($atom, '|');
                continue;
            }

            $atomPattern = '(?P<' . trim($atom, ':/?') . '>[^/]+)';
            $atomName = trim($atom, ':/?');

            // Optional named wildcard ...
            if ('/' === $atom[0]) {
                $optionalParameters[] = $atomName;
                $regex .= '(?:/' . $atomPattern . ')?';
            // Required named wildcard ...
            } else {
                $requiredParameters[] = $atomName;
                $regex .= $atomPattern;
            }
        }

        // Add group for additional path atoms ...
        $regex .= '(/.+)?';

        $this->regex = '|^' . $regex . '$|';
    }

    private $typeCheck;
    private $pattern;
    private $regex;
}
