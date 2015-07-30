<?php

namespace ShandyPatrol\CommandBus\Bus;

use ShandyPatrol\CommandBus\Command\Command;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\HandlerResolver;


/**
 * A basic command bus.
 *
 * @package ShandyPatrol\CommandBus
 */
class BasicCommandBus implements CommandBus
{

    protected $handlerResolver;


    /**
     * Constructor.
     *
     * @param HandlerResolver  $handlerResolver  Resolves commands to their handler.
     */
    public function __construct(HandlerResolver $handlerResolver)
    {
        $this->handlerResolver = $handlerResolver;
    }


    /**
     * {@inheritdoc}
     */
    public function execute(Command $command)
    {
        $handler = $this->handlerResolver->resolve($command);

        $handler->execute($command);
    }
}