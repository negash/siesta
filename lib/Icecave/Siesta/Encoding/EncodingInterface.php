<?php
namespace Icecave\Siesta\Encoding;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface EncodingInterface
{
    /**
     * @param string $contentType
     */
    public function supportsContentType($contentType);

    /**
     * @param string $fileExtension
     */
    public function supportsFileExtension($fileExtension);

    /**
     * @param Request $request
     */
    public function supportsRequest(Request $request);

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function readRequest(Request $request);

    /**
     * @param Request  $request
     * @param Response $response
     * @param mixed    $payload
     */
    public function writeResponse(Request $request, Response $response, $payload);
}
