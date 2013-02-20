<?php
namespace Icecave\Siesta\Encoding;

use Symfony\Component\HttpFoundation\Request;

interface EncodingSelectorInterface
{
    /**
     * @param Request                  $request
     * @param array<EncodingInterface> $encodingOptions
     */
    public function select(Request $request, array $encodingOptions);
}
