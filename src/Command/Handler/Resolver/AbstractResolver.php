<?php

namespace ShandyPatrol\CommandBus\Command\Handler\Resolver;

use ShandyPatrol\CommandBus\Command\Command;
use ShandyPatrol\CommandBus\Command\Handler\CommandHandler;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception\InvalidHandlerException;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception\HandlerClassNotFoundException;

/**
 * Abstract handler resolver.
 *
 * @package ShandyPatrol\CommandBus\Command\Handler\Resolver
 */
abstract class AbstractResolver implements HandlerResolver
{


    /**
     * {@inheritdoc}
     */
    public function resolve(Command $command)
    {
        return $this->getHandler($this->resolveClass($command));
    }


    /**
     * Resolve the class name
     *
     * @return string
     */
    protected abstract function resolveClass(Command $command);


    /**
     * Get the handler from the fully resolved class name.
     *
     * @param string  $class  The class name to get a handler from.
     *
     * @throws HandlerClassNotFoundException Handler class does not exist.
     * @throws InvalidHandlerException       Handler is invalid.
     *
     * @return object
     */
    protected function getHandler($class)
    {

        if (!class_exists($class)) {
            throw new HandlerClassNotFoundException($class);
        }

        $object = new $class();

        if (!($object instanceof CommandHandler)) {
            throw new InvalidHandlerException($class);
        }

        return $object;
    }
}