<?php
namespace Icecave\Siesta;

use Icecave\Collections\Vector;
use Icecave\Siesta\Encoding\EncodingSelector;
use Icecave\Siesta\Encoding\EncodingSelectorInterface;
use Icecave\Siesta\Router\Router;
use Icecave\Siesta\TypeCheck\TypeCheck;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Api
{
    /**
     * @param Router|null                    $router
     * @param EncodingSelectorInterface|null $encodingSelector
     */
    public function __construct(Router $router = null, EncodingSelectorInterface $encodingSelector = null)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        if (null === $router) {
            $router = new Router;
        }

        if (null === $encodingSelector) {
            $encodingSelector = new EncodingSelector;
        }

        $this->router = $router;
        $this->encodingSelector = $encodingSelector;
        $this->encodingOptions = new Vector;
    }

    /**
     * @return RouterInterface
     */
    public function router()
    {
        $this->typeCheck->router(func_get_args());

        return $this->router;
    }

    /**
     * @return EncodingSelectorInterface
     */
    public function encodingSelector()
    {
        $this->typeCheck->encodingSelector(func_get_args());

        return $this->encodingSelector;
    }

    /**
     * @return Vector
     */
    public function encodingOptions()
    {
        $this->typeCheck->encodingOptions(func_get_args());

        return $this->encodingOptions;
    }

    /**
     * @param Request  $request
     * @param Response $response
     */
    public function process(Request $request, Response $response)
    {
        $this->typeCheck->process(func_get_args());

        if ($routeMatch = $this->router->resolve($request)) {
            $encoding = $this->encodingSelector->select($request, $this->encodingOptions->elements());
            $inputPayload = $encoding->readRequest($request);
            $outputPayload = $routeMatch->endpoint()->process($request, $routeMatch, $inputPayload);
            $encoding->writeResponse($request, $response, $outputPayload);
        } else {
            $response->prepare($request);
            $this->errorResponse($response, 404, 'Resource not found.');
        }
    }

    /**
     * @param Response $response
     * @param integer  $statusCode
     * @param string   $message
     */
    protected function errorResponse(Response $response, $statusCode, $message)
    {
        $response->setStatusCode($statusCode);
        $response->headers->set('Content-Type', 'text/plain');
        $response->setContent($message);
    }

    private $typeCheck;
    private $router;
    private $encodingSelector;
    private $encodingOptions;
}
