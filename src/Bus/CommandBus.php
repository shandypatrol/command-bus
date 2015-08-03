<?php

namespace ShandyPatrol\CommandBus\Bus;

use ShandyPatrol\CommandBus\Command\Command;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\HandlerResolver;
use ShandyPatrol\CommandBus\Middleware\Exception\StopPropagationException;
use ShandyPatrol\CommandBus\Middleware\MiddlewareCollection;


/**
 * The command bus.
 *
 * @package ShandyPatrol\CommandBus
 */
class CommandBus
{

    protected $handlerResolver;

    protected $middlewareCollection;


    /**
     * Constructor.
     *
     * @param HandlerResolver       $handlerResolver       Resolves commands to their handler.
     * @param MiddlewareCollection  $middlewareCollection  Middleware to affect a command before execution.
     */
    public function __construct(HandlerResolver $handlerResolver, MiddlewareCollection $middlewareCollection)
    {
        $this->handlerResolver = $handlerResolver;
        $this->middlewareCollection = $middlewareCollection;
    }


    /**
     * {@inheritdoc}
     */
    public function execute(Command $command)
    {
        try {
           $this->fireMiddlewareChain($command);
        } catch(StopPropagationException $e) {
            return;
        }

        $this->handlerResolver->resolve($command)->execute($command);
    }


    /**
     * Start running the command through the middleware.
     *
     * @param Command  $command  The command to send through the middleware chain
     *
     * @return void
     */
    protected function fireMiddlewareChain(Command $command)
    {

       $next = function() {};

       foreach($this->middlewareCollection->getPrioritisedOrder() as $middleware) {
           $next = function($command) use ($middleware, $next) {
                $middleware->affect($command, $next);
            };
        }

        $next($command);
    }
}