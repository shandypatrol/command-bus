<?php

namespace ShandyPatrol\CommandBus\Command;

/**
 * A command.
 *
 * @package ShandyPatrol\CommandBus\Command
 */
interface Command
{

    /**
     * Get the identifier.
     *
     * @return string
     */
    public function getIdentifier();
}