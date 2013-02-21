<?php
namespace Icecave\Siesta\PathResolver;

use Buzz\Message\RequestInterface;
use Icecave\Siesta\TypeCheck\TypeCheck;

/**
 * Resolves based on a path prefix.
 */
class SubPathResolver extends AbstractForwardingResolver
{
    /**
     * @param PathPattern $pathPattern
     * @param ResolverInterface $nextResolver
     */
    public function __construct(PathPattern $pathPattern, ResolverInterface $nextResolver)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->pathPattern = $pathPattern;

        parent::__construt($nextResolver);
    }

    /**
     * @param RequestInterface $request
     * @param Map|null &$arguments
     *
     * @return RequestInterface|null
     */
    public function makeForwardingRequest(RequestInterface $request, Map &$arguments = null)
    {
        $resource = null;
        $arguments = $this->pathPattern->match($request->getResource(), false, $resource);

        if (null === $arguments) {
            return null;
        } elseif (null === $resource) {
            return null;
        }

        $request = clone $request;
        $request->setResource($suffix);

        return $request;
    }
}
