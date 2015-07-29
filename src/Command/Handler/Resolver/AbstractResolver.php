<?php

namespace ShandyPatrol\CommandBus\Command\Handler\Resolver;
use ShandyPatrol\CommandBus\Command\Handler\CommandHandler;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception\InvalidHandlerException;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception\NotFoundHandlerException;

/**
 * Abstract handler resolver.
 *
 * @package ShandyPatrol\CommandBus\Command\Handler\Resolver
 */
abstract class AbstractResolver implements HandlerResolver
{

    /**
     * Get the handler from the fully resolved class name.
     *
     * @param string  $class  The class name to get a handler from.
     *
     * @throws NotFoundHandlerException Handler class does not exist.
     * @throws InvalidHandlerException  Handler is invalid.
     *
     * @return object
     */
    protected function getHandler($class)
    {

        if (!class_exists($class)) {
            throw new NotFoundHandlerException($class);
        }

        $object = $class();

        if (!($object instanceof CommandHandler)) {
            throw new InvalidHandlerException($class);
        }

        return $object;
    }
}