<?php

namespace Lampa\Exceptions;

use Exception;
use Lampa\Entity\AbstractSitemap;
use Throwable;

class InsufficientPermissionsWriteException extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param Throwable|null $previous
     */
    public function __construct($message = null, $code = 0, Throwable $previous = null)
    {
        $message = "Not enough rights to write";
        parent::__construct($message, $code, $previous);
    }
}