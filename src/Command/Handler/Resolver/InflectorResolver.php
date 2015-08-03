<?php

namespace ShandyPatrol\CommandBus\Command\Handler\Resolver;

use ShandyPatrol\CommandBus\Command\Command;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception\HandlerNotFoundException;

/**
 * Resolve a handler for a command by taking the command class name through a pre-defined list of namespaces.
 *
 * @package ShandyPatrol\CommandBus\Command\Handler\Resolver
 */
class InflectorResolver extends AbstractResolver
{

    protected $namespaces = [];


    /**
     * Constructor.
     *
     * @param array  $handlerNamespaces  Namespaces that handlers are registered in.
     */
    public function __construct(array $handlerNamespaces)
    {
        $this->namespaces = $handlerNamespaces;
    }


    /**
     * {@inheritdoc}
     */
    protected function resolveClass(Command $command)
    {
        $className = get_class($command).'Handler';

        foreach($this->namespaces as $namespace) {

            $resolvedClassName = "{$namespace}\\{$className}";

            if (!class_exists($resolvedClassName)) {
                continue;
            }

            return $resolvedClassName;
        }

        throw new HandlerNotFoundException($command);
    }


    /**
     * Get namespaces.
     *
     * @return array
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }


    /**
     * Set namespaces.
     *
     * @param array  $namespaces  The namespaces to set.
     *
     * @return self
     */
    public function setNamespaces(array $namespaces)
    {
        $this->namespaces = $namespaces;

        return $this;
    }


    /**
     * Add a name space.
     *
     * @param string  $namespace  Namespace to add.
     *
     * @return self
     */
    protected function addHandlerNameSpace($namespace)
    {
        $this->namespaces[] = $namespace;

        return $this;
    }
}