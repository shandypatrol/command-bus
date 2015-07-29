<?php

namespace ShandyPatrol\CommandBus\Test\Command\Hander\Resolver;

use ShandyPatrol\CommandBus\Command\Handler\Resolver\MappedResolver;
use ShandyPatrol\CommandBus\Test\Command\MockCommandTrait;

/**
 * Mapped resolver test
 *
 * @package ShandyPatrol\CommandBus\Test\Command\Hander\Resolver
 */
class MappedResolverTest extends \PHPUnit_Framework_TestCase
{

    use MockCommandTrait;


    /**
     * Tests construction.
     *
     * @return void
     */
    public function testInitialise()
    {
        $this->assertInstanceOf('\ShandyPatrol\CommandBus\Command\Handler\Resolver\MappedResolver', $this->getMappedResolver());
    }


    /**
     * Test that it can resolve a handler from a command.
     *
     * TODO: FIXME!!
     *
     * @return void
     */
    public function testResolvesHandler()
    {
        $resolver = $this->getMappedResolver(['\ShandyPatrol\CommandBus\Command\ExampleCommand' => 'command.identifier.example']);

        $command = $this->_getMockCommand();
        $command->method('getIdentifier')->willReturn('command.identifier.example');

        $this->assertInstanceOf('\ShandyPatrol\CommandBus\Command\ExampleCommand',  $resolver->resolve($command));
    }


    /**
     * Test that an exception is thrown when a handler is not mapped.
     *
     * @return void
     */
    public function testHandlerNotMappedException()
    {
        $this->setExpectedException('Exception'); //TODO: ADD SPECIFIC EXCEPTION

        $resolver = $this->getMappedResolver(['\ShandyPatrol\CommandBus\Command\ExampleCommand' => 'command.identifier.example']);

        $resolver->resolve($this->_getMockCommand());
    }


    /**
     * Test that an exception is thrown when a handler class is not found.
     *
     * @return void
     */
    public function testHandlerNotFoundException()
    {
        $this->setExpectedException('\ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception\NotFoundHandlerException');

        $resolver = $this->getMappedResolver(['\ShandyPatrol\CommandBus\Command\ExampleCommand' => 'command.identifier.example']);

        $command = $this->_getMockCommand();
        $command->method('getIdentifier')->willReturn('command.identifier.example');

        $resolver->resolve($command);
    }


    /**
     * Get the mapped resolver that will be under test.
     *
     * @param array  $mapping  The resolver mapping.
     *
     * @return MappedResolver
     */
    protected function getMappedResolver(array $mapping = [])
    {
        return new MappedResolver($mapping);
    }
}
