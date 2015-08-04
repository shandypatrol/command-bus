<?php

namespace ShandyPatrol\CommandBus\Test\Command\Hander\Resolver;

use ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception\HandlerClassNotFoundException;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception\HandlerNotFoundException;
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
        $this->assertInstanceOf(MappedResolver::class, $this->getMappedResolver());
    }


    /**
     * Test that it can resolve a handler from a command.
     *
     * @return void
     */
    public function testResolvesHandler()
    {
        $resolver = $this->getMappedResolver([
            '\ShandyPatrol\CommandBus\Test\Models\Command\Handler\ExampleCommandHandler'  => 'command.identifier.example',
            '\ShandyPatrol\CommandBus\Test\Models\Command\Handler\Example2CommandHandler' => 'command.identifier.example,two',
            '\ShandyPatrol\CommandBus\Test\Models\Command\Handler\Example3CommandHandler' => 'command.identifier.example,three',
            '\ShandyPatrol\CommandBus\Test\Models\Command\Handler\Example4CommandHandler' => 'command.identifier.example.four',
        ]);

        $command = $this->_getMockCommand();
        $command->method('getIdentifier')->willReturn('command.identifier.example');

        $handler = $resolver->resolve($command);

        $this->assertInstanceOf('\ShandyPatrol\CommandBus\Test\Models\Command\Handler\ExampleCommandHandler', $handler);
    }


    /**
     * Test that an exception is thrown when a handler is not mapped.
     *
     * @return void
     */
    public function testHandlerNotFoundException()
    {
        $this->setExpectedException(HandlerNotFoundException::class);

        $resolver = $this->getMappedResolver(['\ShandyPatrol\CommandBus\Command\ExampleCommand' => 'command.identifier.example']);

        $resolver->resolve($this->_getMockCommand());
    }


    /**
     * Test that an exception is thrown when a handler class is not found.
     *
     * @return void
     */
    public function testHandlerClassNotFoundException()
    {
        $this->setExpectedException(HandlerClassNotFoundException::class);

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
