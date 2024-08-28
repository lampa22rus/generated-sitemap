<?php

namespace Lampa\Exceptions;

use Exception;
use Lampa\Entity\AbstractSitemap;
use Throwable;

class InvalidInitialArgument extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param Throwable|null $previous
     */
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct("Invalid initial argument: $message", $code, $previous);
    }
}