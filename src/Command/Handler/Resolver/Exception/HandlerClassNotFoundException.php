<?php

namespace ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception;

use Exception;

/**
 * Handler class could not be found.
 *
 * @package ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception
 */
class HandlerClassNotFoundException extends Exception
{

    /**
     * {@inheritdoc}
     */
    public function __construct($class, $code = 0, $clause = null)
    {
        parent::__construct("Handler with class {$class} was not found", $code, $clause);
    }
}