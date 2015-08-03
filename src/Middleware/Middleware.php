<?php

namespace ShandyPatrol\CommandBus\Middleware;
use ShandyPatrol\CommandBus\Command\Command;

/**
 * Middleware
 *
 * @package ShandyPatrol\CommandBus\Middleware
 */
interface Middleware
{

    /**
     * Get priority.
     *
     * @return int
     */
    public function getPriority();


    /**
     * Affect a command prior to execution.
     *
     * @param Command   $command  The command to affect.
     * @param callable  $next     The command to affect.
     *
     * @return void
     */
    public function affect(Command $command, callable $next);
}