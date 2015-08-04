<?php

namespace ShandyPatrol\CommandBus\Test\Bus;

use ArrayIterator;
use PHPUnit_Framework_TestCase;
use ShandyPatrol\CommandBus\Bus\CommandBus;
use ShandyPatrol\CommandBus\Command\Handler\CommandHandler;
use ShandyPatrol\CommandBus\Command\Handler\Resolver\HandlerResolver;
use ShandyPatrol\CommandBus\Middleware\MiddlewareCollection;
use ShandyPatrol\CommandBus\Middleware\Middleware;
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
        $this->assertInstanceOf(
            CommandBus::class,
            $this->getCommandBus($this->_getMockHandlerResolver(), $this->_getMockMiddlewareCollection())
        );
    }


    /**
     * Tests traverses command through middleware.
     *
     * @return void
     */
    public function testTraversesMiddleware()
    {
        $handler = $this->_getMockHandler();

        $resolver = $this->_getMockHandlerResolver();
        $resolver->method('resolve')->willReturn($handler);

        $collection = [];

        for ($i = 0; $i > 10; $i++) {
            $middleware = $this->getMock(Middleware::class);
            $middleware->expects($this->once())->method('affect');
            $collection[] = $middleware;
        }

        $middlewareCollection = $this->_getMockMiddlewareCollection($collection);
        $middlewareCollection->method('getPrioritisedOrder')->willReturn($middlewareCollection);
        $middlewareCollection->expects($this->once())->method('getPrioritisedOrder');

        $commandBus = $this->getCommandBus($resolver, $middlewareCollection);
        $commandBus->execute($this->_getMockCommand());
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

        $middlewareCollection = $this->_getMockMiddlewareCollection();
        $middlewareCollection->method('getPrioritisedOrder')->willReturn($middlewareCollection);

        $commandBus = $this->getCommandBus($resolver, $middlewareCollection);

        $handler->expects($this->once())->method('execute');
        $commandBus->execute($this->_getMockCommand());
    }


    /**
     * Get the command bus that will be under test.
     *
     * @param HandlerResolver       $handlerResolver       Mocked handler resolver.
     * @param MiddlewareCollection  $middlewareCollection  Mocked middleware collection.
     *
     * @return CommandBus
     */
    protected function getCommandBus(HandlerResolver $handlerResolver, MiddlewareCollection $middlewareCollection)
    {
        return new CommandBus($handlerResolver, $middlewareCollection);
    }


    /**
     * Gets a mocked handler.
     *
     * @return CommandHandler
     */
    protected function _getMockHandler()
    {
        return $this->getMock(CommandHandler::class);
    }


    /**
     * Gets a mocked middleware collection.
     *
     * @param Middleware[]  $middleware  The middleware.
     *
     * @return MiddlewareCollection
     */
    protected function _getMockMiddlewareCollection(array $middleware = [])
    {
        $middlewareCollectionMock = $this->getMockBuilder(MiddlewareCollection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $iterator = new ArrayIterator($middleware);

        $middlewareCollectionMock->expects($this->any())
            ->method('valid')
            ->willReturnCallback(function() use ($iterator) { return $iterator->valid(); });

        $middlewareCollectionMock->expects($this->any())
            ->method('next')
            ->willReturnCallback(function() use ($iterator) { $iterator->next(); });

        $middlewareCollectionMock->expects($this->any())
            ->method('key')
            ->willReturnCallback(function() use ($iterator) { return $iterator->key(); });

        $middlewareCollectionMock->expects($this->any())
            ->method('current')
            ->willReturnCallback(function() use ($iterator) { return $iterator->current(); });

        $middlewareCollectionMock->expects($this->any())
            ->method('rewind')
            ->willReturnCallback(function() use ($iterator) { $iterator->rewind(); });

        $middlewareCollectionMock->expects($this->any())->method('count')->willReturn($iterator->count());

        return $middlewareCollectionMock;
    }


    /**
     * Gets a mocked handler resolver.
     *
     * @return HandlerResolver
     */
    protected function _getMockHandlerResolver()
    {
       return $this->getMock(HandlerResolver::class);
    }
}
