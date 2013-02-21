<?php
namespace Icecave\Siesta;

use Icecave\Siesta\Encoding\EncodingInterface;
use Icecave\Siesta\Encoding\EncodingSelector;
use Icecave\Siesta\Encoding\EncodingSelectorInterface;
use Icecave\Siesta\Endpoint\Endpoint;
use Icecave\Siesta\Router\Router;
use Icecave\Siesta\Router\PathRoute;
use Icecave\Siesta\Router\PatternCompiler;
use Icecave\Siesta\TypeCheck\TypeCheck;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Api
{
    /**
     * @param Router|null                    $router
     * @param EncodingSelectorInterface|null $encodingSelector
     * @param PatternCompiler|null           $patternCompiler
     */
    public function __construct(
        Router $router = null,
        EncodingSelectorInterface $encodingSelector = null,
        PatternCompiler $patternCompiler = null
    ) {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        if (null === $router) {
            $router = new Router;
        }

        if (null === $encodingSelector) {
            $encodingSelector = new EncodingSelector;
        }

        if (null === $patternCompiler) {
            $patternCompiler = new PatternCompiler;
        }

        $this->router = $router;
        $this->encodingOptions = array();
        $this->encodingSelector = $encodingSelector;
        $this->patternCompiler = $patternCompiler;
        $this->isConfigured = false;
    }

    public function router()
    {
        $this->typeCheck->router(func_get_args());

        return $this->router;
    }

    /**
     * @param EncodingInterface $encoding
     */
    public function addEncoding(EncodingInterface $encoding)
    {
        $this->typeCheck->addEncoding(func_get_args());

        return $this->encodingOptions[] = $encoding;
    }

    /**
     * @param string $pathPattern
     * @param object $endpointImplementation
     */
    public function route($pathPattern, $endpointImplementation)
    {
        $this->typeCheck->route(func_get_args());

        list($identity, $regexPattern, $identityParameters) = $this->patternCompiler->compile($pathPattern);

        $endpoint = new EndPoint($endpointImplementation, $identityParameters);
        $route = new PathRoute($identity, $regexPattern, $endpoint);

        $this->router()->addRoute($route);
    }

    abstract public function configure();

    /**
     * @param Request  $request
     * @param Response $response
     */
    public function process(Request $request, Response $response)
    {
        $this->typeCheck->process(func_get_args());

        if (!$this->isConfigured) {
            $this->configure($this->router, $this->encodingOptions);
            $this->isConfigured = true;
        }

        if ($routeMatch = $this->router->resolve($request)) {
            $encoding = $this->encodingSelector->select($request, $this->encodingOptions);
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
    private $encodingOptions;
    private $encodingSelector;
    private $patternCompiler;
    private $isConfigured;
}
