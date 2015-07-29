<?php

namespace ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception;

use Exception;

/**
 * Handler could not be found.
 *
 * @package ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception
 */
class NotFoundHandlerException extends Exception
{

    /**
     * {@inheritdoc}
     */
    public function __construct($class, $code = 0, $clause = null)
    {
        parent::__construct("Handler {$class} could not be found", $code, $clause);
    }
}