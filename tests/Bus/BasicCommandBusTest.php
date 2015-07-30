<?php

namespace ShandyPatrol\CommandBus\Test\Bus;

use PHPUnit_Framework_TestCase;
use ShandyPatrol\CommandBus\Bus\BasicCommandBus;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\HandlerResolver;
use ShandyPatrol\CommandBus\Test\Command\MockCommandTrait;

/**
 * Basic command bus test.
 *
 * @package ShandyPatrol\CommandBus\Test\Bus
 */
class BasicCommandBusTest extends PHPUnit_Framework_TestCase
{

    use MockCommandTrait;

    /**
     * Tests construction.
     *
     * @return void
     */
    public function testInitialise()
    {
        $this->assertInstanceOf('\ShandyPatrol\CommandBus\Bus\BasicCommandBus', $this->getBasicCommandBus($this->_getMockHandlerResolver()));
    }


    /**
     * Tests executes command.
     *
     * @return void
     */
    public function testExecutesCommand()
    {
        $handler = $this->_getMockHandler();

        $resolver = $this->_getMockHandlerResolver();
        $resolver->method('resolve')->willReturn($handler);

        $commandBus = $this->getBasicCommandBus($resolver);

        $handler->expects($this->once())->method('execute');
        $commandBus->execute($this->_getMockCommand());
    }


    /**
     * Get the command bus that will be under test.
     *
     * @param HandlerResolver  $handlerResolver  Mocked handler resolver.
     *
     * @return BasicCommandBus
     */
    protected function getBasicCommandBus(HandlerResolver $handlerResolver)
    {
        return new BasicCommandBus($handlerResolver);
    }


    /**
     * Gets a mocked handler.
     *
     * @return HandlerResolver
     */
    protected function _getMockHandler()
    {
        return $this->getMock('\ShandyPatrol\CommandBus\Command\Handler\CommandHandler');
    }


    /**
     * Gets a mocked handler resolver.
     *
     * @return HandlerResolver
     */
    protected function _getMockHandlerResolver()
    {
       return $this->getMock('\ShandyPatrol\CommandBus\Command\Handler\Resolver\HandlerResolver');
    }
}
