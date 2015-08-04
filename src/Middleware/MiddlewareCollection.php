<?php

namespace ShandyPatrol\CommandBus\Middleware;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * Middleware collection
 *
 * @package ShandyPatrol\CommandBus\Middleware
 */
class MiddlewareCollection implements ArrayAccess, Iterator, Countable
{

    protected $middleware = [];

    protected $position = 0;


    /**
     * Constructor.
     *
     * @param array  $middleware  The middleware.
     */
    public function __construct(array $middleware)
    {
        $this->middleware = $middleware;
    }


    /**
     * Get the middleware in prioritised order.
     *
     * @return self
     */
    public function getPrioritisedOrder()
    {
        $order = $this->toArray();

        usort($order, function(Middleware $a, Middleware $b){

            if ($a->getPriority() === $b->getPriority()) {
                return 0;
            }

            return $a->getPriority() < $b->getPriority() ? -1 : 1;
        });

        return new self($order);
    }


    /**
     * Get the raw array.
     *
     * @return Middleware[]
     */
    public function toArray()
    {
        return $this->middleware;
    }


    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->middleware[] = $value;
        } else {
            $this->middleware[$offset] = $value;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->middleware[$offset]);
    }


    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->middleware[$offset]);
    }


    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return isset($this->middleware[$offset]) ? $this->middleware[$offset] : null;
    }


    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->position = 0;
    }


    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->middleware[$this->position];
    }


    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->position;
    }


    /**
     * {@inheritdoc}
     */
    public function next()
    {
        ++$this->position;
    }


    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return isset($this->middleware[$this->position]);
    }


    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->middleware);
    }
}