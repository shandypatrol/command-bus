<?php

namespace ShandyPatrol\CommandBus\Command\Handler\Resolver;

use Exception;
use ShandyPatrol\CommandBus\Command\Command;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception\NotFoundHandlerException;

/**
 * Resolve a handler for a command using the command class name.
 *
 * @package ShandyPatrol\CommandBus\Command\Handler\Resolver
 */
class InflectorResolver extends AbstractResolver
{

    protected $handlerNamespaces = [];


    /**
     * Constructor.
     *
     * @param array  $handlerNamespaces  Namespaces that handlers are registered in.
     */
    public function __construct(array $handlerNamespaces)
    {
        $this->handlerNamespaces = $handlerNamespaces;
    }


    /**
     * {@inheritdoc}
     */
    public function resolve(Command $command)
    {
        return $this->getHandler($command);
    }


    /**
     * Get the handler class from the command class.
     *
     * @param Command  $command  The command to resolve a handler for.
     *
     * @throws NotFoundHandlerException Could not find handler.
     *
     * @return object
     */
    protected function getHandler(Command $command)
    {
        $className = get_class($command).'Handler';

        foreach($this->handlerNamespaces as $namespace) {

            $resolvedClassName = "{$namespace}\\{$className}";

            try {
                return parent::getHandler($resolvedClassName);
            } catch(NotFoundHandlerException $e) {
                continue;
            }
        }

        throw new NotFoundHandlerException($className);
    }


    /**
     * Get handler namespaces.
     *
     * @return array
     */
    public function getHandlerNamespaces()
    {
        return $this->handlerNamespaces;
    }


    /**
     * Set handler namespaces.
     *
     * @param array  $handlerNamespaces  The handler namespaces to set.
     *
     * @return self
     */
    public function setHandlerNamespaces(array $handlerNamespaces)
    {
        $this->handlerNamespaces = $handlerNamespaces;

        return $this;
    }


    /**
     * Add a handler name space.
     *
     * @param string  $namespace  Namespace to add.
     *
     * @return self
     */
    protected function addHandlerNameSpace($namespace)
    {
        $this->handlerNamespaces[] = $namespace;

        return $this;
    }
}