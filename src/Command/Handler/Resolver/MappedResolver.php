<?php

namespace ShandyPatrol\CommandBus\Command\Handler\Resolver;

use Exception;
use ShandyPatrol\CommandBus\Command\Command;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception\HandlerNotFoundException;

/**
 * Resolve handlers by the command id from a defined mapping.
 *
 * @package ShandyPatrol\CommandBus\Command\Handler\Resolver
 */
class MappedResolver extends AbstractResolver
{

    protected $mapping = [];


    /**
     * Constructor.
     *
     * @param array  $mapping  The handler mapping.
     */
    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }


    /**
     * Get the handler class using the mapping.
     *
     * @param Command  $command  The command to get the handler class from.
     *
     * @throws Exception Could not find handler from mapping.
     *
     * @return string
     */
    protected function resolveClass(Command $command)
    {
        $handlers = array_flip($this->mapping);

        if (!isset($handlers[$command->getIdentifier()])) {
            throw new HandlerNotFoundException($command);
        }

        return $handlers[$command->getIdentifier()];
    }
}