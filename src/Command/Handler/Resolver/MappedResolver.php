<?php

namespace ShandyPatrol\CommandBus\Command\Handler\Resolver;

use Exception;
use ShandyPatrol\CommandBus\Command\Command;

/**
 * Resolve handlers by the command id from a defined mapping.
 *
 * @package ShandyPatrol\CommandBus\Command\Handler\Resolver
 */
class MappedResolver extends AbstractResolver
{

    protected $handlerMapping = [];


    /**
     * Constructor.
     *
     * @param array  $handlerMapping  The handler mapping.
     */
    public function __construct(array $handlerMapping)
    {
        $this->handlerMapping = $handlerMapping;
    }


    /**
     * {@inheritdoc}
     */
    public function resolve(Command $command)
    {
        return $this->getHandler($this->resolveClassNameFromMapping($command));
    }


    /**
     * Get the handler class.
     *
     * @param Command  $command  The command to get the handler class from.
     *
     * @throws Exception Could not find handler from mapping.
     *
     * @return string
     */
    protected function resolveClassNameFromMapping(Command $command)
    {
        $handlers = array_flip($this->handlerMapping);

        if (!isset($handlers[$command->getIdentifier()])) {
            //TODO: ADD SPECIFIC EXCEPTION
            throw new Exception("Handler not found for command with identifier {$command->getIdentifier()}");
        }

        return $handlers[$command->getIdentifier()];
    }
}