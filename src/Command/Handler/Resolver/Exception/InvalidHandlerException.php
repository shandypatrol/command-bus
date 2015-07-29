<?php

namespace ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception;

use Exception;

/**
 * Invalid handler.
 *
 * @package ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception
 */
class InvalidHandlerException extends Exception
{

    /**
     * {@inheritdoc}
     */
    public function __construct($class, $code = 0, $clause = null)
    {
        parent::__construct("Invalid handler {$class}, must be an instance of CommandHandler", $code, $clause);
    }
}