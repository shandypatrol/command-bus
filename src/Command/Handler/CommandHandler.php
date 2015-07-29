<?php

namespace ShandyPatrol\CommandBus\Command\Handler;

use ShandyPatrol\CommandBus\Command\Command;

/**
 * A command handler.
 *
 * @package ShandyPatrol\CommandBus\Command\Handler
 */
interface CommandHandler
{

    /**
     * Execute a command.
     *
     * @param Command  $command  The command that needs handling.
     *
     * @return void
     */
    public function execute(Command $command);
}