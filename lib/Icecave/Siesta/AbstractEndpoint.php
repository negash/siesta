<?php
namespace Icecave\Siesta;

use Icecave\Evoke\Invoker;
use ReflectionClass;

abstract class AbstractEndpoint implements EndpointInterface
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function execute(Request $request, Invoker $invoker = null)
    {
        if (null === $invoker) {
            $invoker = new Invoker;
        }

        list($positional, $keyword) = $this->parseArguments($request);

        $requiredCount = $this->numberOfRequiredParameters();
        $providedCount = count($positional);

        if ($providedCount < $requiredCount) {
            throw new Exception\NotFoundException;
        } elseif ('GET' !== $request->method()) {
            $method = strtolower($request->method());
        } elseif ($requiredCount === $providedCount) {
            $method = 'index';
        } else {
            $method = 'get';
        }

        $callable = array($this, $method);

        if (!is_callable($callable)) {
            throw new Exception\HttpException(
                405,
                sprintf(
                    '%s does not support %s request.',
                    get_class($this),
                    $request->method()
                )
            );
        }

        return $invoker->invoke($callable, $positional, $keyword);
    }

    protected function numberOfRequiredParameters()
    {
        $reflector = new ReflectionClass($this);

        return $reflector->getMethod('index')->getNumberOfRequiredParameters();
    }

    protected function parseArguments(Request $request)
    {
        $path = trim($request->path(), '/');

        if ('' === $path) {
            $positional = array();
        } else {
            $positional = explode('/', $path);
        }

        $keyword = array();
        $payload = $request->payload();

        if (null !== $payload) {
            if (!is_array($payload) && !is_object($payload)) {
                throw new BadMethodCallException('Payload must be an array or object.');
            }
            foreach ($payload as $key => $value) {
                $keyword[$key] = $value;
            }
        }

        $keyword += $request->options();

        return array($positional, $keyword);
    }
}
