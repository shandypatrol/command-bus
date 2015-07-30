<?php

namespace ShandyPatrol\CommandBus\Test\Models\Command\Handler;

use ShandyPatrol\CommandBus\Command\Command;
use ShandyPatrol\CommandBus\Command\Handler\CommandHandler;

/**
 * Represents a command handler.
 *
 * @package ShandyPatrol\CommandBus\Test\Models\Command\Handler
 */
class ExampleCommandHandler implements CommandHandler
{

    /**
     * {@inheritdoc}
     */
    public function execute(Command $command)
    {

    }
}