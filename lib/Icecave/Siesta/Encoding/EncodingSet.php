<?php
namespace Icecave\Siesta\Encoding;

use Icecave\Collections\Vector;

class EncodingSet extends Vector
{
    public function defaultEncoding()
    {
        return $this->front();
    }

    public function findByContentType($contentType)
    {
        $wildcard = false;
        foreach ($this as $encoding) {
            if ($encoding->supportsContentType($contentType)) {
                return $encoding;
            }
        }

        return null;
    }
}
