<?php

namespace ShandyPatrol\CommandBus\Middleware;

use ShandyPatrol\CommandBus\Middleware\Exception\StopPropagationException;

/**
 * Abstract middleware.
 *
 * @package ShandyPatrol\CommandBus\Middleware
 */
abstract class AbstractMiddleware implements Middleware
{

    /**
     * Stop propagation and execution of command.
     *
     * @throws StopPropagationException Stop propagation and execution of command.
     *
     * @return void
     */
    public function stopPropagation()
    {
        throw new StopPropagationException($this);
    }
}