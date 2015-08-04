<?php

namespace ShandyPatrol\CommandBus\Middleware\Exception;

use Exception;
use ShandyPatrol\CommandBus\Middleware\Middleware;

/**
 * Stops the propagation of middleware stopping the impending execution of a command.
 *
 * @package ShandyPatrol\CommandBus\Middleware
 */
class StopPropagationException extends Exception
{

    protected $_middleware;


    /**
     * {@inheritdoc}
     *
     * @param Middleware  $middleware  The middleware that has stopped propagation.
     */
    public function __construct(Middleware $middleware, $code = 0, $cause = null)
    {
        parent::__construct(get_class($middleware)." has stopped propagation", $code, $cause);
    }


    /**
     * Get Middleware.
     *
     * @return Middleware
     */
    public function getMiddleware()
    {
        return $this->_middleware;
    }
}