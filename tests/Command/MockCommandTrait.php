<?php

namespace ShandyPatrol\CommandBus\Test\Command;

use ShandyPatrol\CommandBus\Command\Command;

/**
 * Get a mocked command.
 *
 * @package ShandyPatrol\CommandBus\Test\Command
 */
trait MockCommandTrait
{

    /**
     * Get a mocked command.
     *
     * @return Command
     */
    protected function _getMockCommand()
    {
        return $this->getMock(Command::class);
    }
}