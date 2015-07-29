<?php

namespace ShandyPatrol\CommandBus\Command\Handler\Resolver;

use ShandyPatrol\CommandBus\Command\Command;
use ShandyPatrol\CommandBus\Command\Handler\CommandHandler;

/**
 * Resolver a handler for a command.
 *
 * @package ShandyPatrol\CommandBus\Command\Handler\Resolver
 */
interface HandlerResolver
{

    /**
     * Resolve a command to its handler.
     *
     * @param Command  $command  The command to resolve a handler for.
     *
     * @return CommandHandler
     */
    public function resolve(Command $command);

}