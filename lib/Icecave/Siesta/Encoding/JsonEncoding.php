<?php
namespace Icecave\Siesta\Encoding;

class JsonEncoding implements EncodingInterface
{
    /**
     * @return string
     */
    public function contentType()
    {
        return 'application/json';
    }

    /**
     * @param string $contentType
     */
    public function supportsContentType($contentType)
    {
        return strcasecmp($contentType, 'application/json') === 0;
    }

    /**
     * @param string $content
     *
     * @return mixed
     */
    public function decodePayload($content)
    {
        return json_decode($content, true);
    }

    /**
     * @param mixed $payload
     *
     * @return string
     */
    public function encodePayload($payload)
    {
        return json_encode($payload);
    }
}
