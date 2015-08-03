<?php

namespace ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception;

use Exception;
use ShandyPatrol\CommandBus\Command\Command;

/**
 * A handler could not be found for command.
 *
 * @package ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception
 */
class HandlerNotFoundException extends Exception
{

    /**
     * {@inheritdoc}
     */
    public function __construct(Command $command, $code = 0, $clause = null)
    {
        parent::__construct("Could not find a handler for command with identifier {$command->getIdentifier()}", $code, $clause);
    }
}