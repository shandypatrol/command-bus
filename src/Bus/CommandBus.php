<?php

namespace ShandyPatrol\CommandBus\Bus;

use ShandyPatrol\CommandBus\Command\Command;

/**
 * Command bus.
 *
 * @package ShandyPatrol\CommandBus
 */
interface CommandBus
{

    /**
     * Execute a command.
     *
     * @param Command  $command  The command to execute.
     *
     * @return void
     */
    public function execute(Command $command);
}