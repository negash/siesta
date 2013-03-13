<?php
namespace Icecave\Siesta;

use UnexpectedValueException;

abstract class AbstractRouter implements RouterInterface
{
    /**
     * @param Request $request
     *
     * @return tuple<EndpointInterface, Request>
     */
    public function resolve(Request $request)
    {
        list($resource, $request) = $this->popResource($request);

        $method   = $this->methodName($resource);
        $callable = array($this, $method);

        if (!is_callable($callable)) {
            throw new Exception\NotFoundException;
        }

        $result = call_user_func($callable);

        if (null === $result) {
            throw new Exception\NotFoundException;
        } elseif ($result instanceof EndpointInterface) {
            return array($result, $request);
        } elseif ($result instanceof RouterInterface) {
            return $result->resolve($request);
        }

        throw new UnexpectedValueException(
            sprintf(
                '%s::%s() returned %s (expected RouterInterface, EndpointInterface or null).',
                get_class($this),
                $method,
                is_object($result)
                    ? get_class($result)
                    : gettype($result)
            )
        );
    }

    protected function popResource(Request $request)
    {
        $request = clone $request;

        $resource = trim($request->path(), '/');
        $position = strpos($resource, '/');

        if (false === $position) {
            $request->setPath('/');
        } else {
            $request->setPath('/' . substr($resource, $position + 1));
            $resource = substr($resource, 0, $position);
        }

        return array($resource, $request);
    }

    protected function methodName($resource) {
         return $resource . 'Route';
    }
}
