<?php

namespace ShandyPatrol\CommandBus\Test\Command\Hander\Resolver;

use ShandyPatrol\CommandBus\Command\Command;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\Exception\HandlerNotFoundException;
use ShandyPatrol\CommandBus\Test\Command\MockCommandTrait;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\InflectorResolver;

/**
 * Inflector resolver test
 *
 * @package ShandyPatrol\CommandBus\Test\Command\Hander\Resolver
 */
class InflectorResolverTest extends \PHPUnit_Framework_TestCase
{

    use MockCommandTrait;


    /**
     * Tests construction.
     *
     * @return void
     */
    public function testInitialise()
    {
        $this->assertInstanceOf(InflectorResolver::class, $this->getInflectorResolver());
    }


    /**
     * Test that an exception is thrown when a handler is not mapped.
     *
     * @return void
     */
    public function testHandlerNotFoundException()
    {
        $this->setExpectedException(HandlerNotFoundException::class);

        $resolver = $this->getInflectorResolver([
            '\ShandyPatrol\CommandBus\Test\Models\Command\Handler\Cache',
            '\ShandyPatrol\CommandBus\Test\Models\Command\Handler\Entity',
            '\ShandyPatrol\CommandBus\Test\Models\Command\Handler\Flatten',
        ]);

        $resolver->resolve($this->_getMockCommand());
    }


    /**
     * Test that it can resolve a handler from a command.
     *
     * @return void
     */
    public function testResolvesHandler()
    {
        $resolver = $this->getInflectorResolver([
            '\ShandyPatrol\CommandBus\Test\Models\Command\Handler\Cache',
            '\ShandyPatrol\CommandBus\Test\Models\Command\Handler\Entity',
            '\ShandyPatrol\CommandBus\Test\Models\Command\Handler\Flatten',
            '\ShandyPatrol\CommandBus\Test\Models\Command\Handler',
        ]);

        $command = $this->getMockBuilder(Command::class)
            ->setMockClassName('ExampleCommand')
            ->getMock();

        $handler = $resolver->resolve($command);

        $this->assertInstanceOf('\ShandyPatrol\CommandBus\Test\Models\Command\Handler\ExampleCommandHandler', $handler);
    }


    /**
     * Get the inflector resolver that will be under test.
     *
     * @param array  $namespaces  The namespaces to resolve against.
     *
     * @return InflectorResolver
     */
    protected function getInflectorResolver(array $namespaces = [])
    {
        return new InflectorResolver($namespaces);
    }
}
