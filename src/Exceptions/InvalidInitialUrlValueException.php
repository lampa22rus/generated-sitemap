<?php

namespace Lampa\Exceptions;

use Exception;
use Lampa\Entity\AbstractSitemap;
use Throwable;

class InvalidInitialUrlValueException extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param Throwable|null $previous
     */
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        $message = "Invalid initial value in initial data. Invalid key: " . implode(',', $message) . ". ";
        $message .= "Allowed values: " . implode(',', AbstractSitemap::$allowedKeysUrl) . ".";
        parent::__construct($message, $code, $previous);
    }
}